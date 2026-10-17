<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayHeroService
{
    protected ?string $username;
    protected ?string $password;
    protected ?string $authToken;
    protected int $channelId;
    protected ?string $accountId;
    protected ?string $callbackUrl;

    public function __construct()
    {
        $this->username    = SiteSetting::get('payhero_username', config('services.payhero.username'));
        $this->password    = SiteSetting::get('payhero_password', config('services.payhero.password'));
        $this->authToken   = SiteSetting::get('payhero_auth_token', config('services.payhero.auth_token'));
        $this->channelId   = (int) SiteSetting::get('payhero_channel_id', config('services.payhero.channel_id'));
        $this->accountId   = SiteSetting::get('payhero_account_id', config('services.payhero.account_id'));

        // Determine sensible default callback URL
        $defaultCallback = url('/webhook/payhero');
        if (app()->isProduction() && str_starts_with($defaultCallback, 'http://')) {
            $defaultCallback = 'https://' . substr($defaultCallback, 7);
        }

        $configuredCallback = SiteSetting::get('payhero_callback_url', config('services.payhero.callback_url'));

        // If not set, or pointing to local/tunnel development domains, use production URL
        if (empty($configuredCallback)
            || str_contains($configuredCallback, 'localhost')
            || str_contains($configuredCallback, '127.0.0.1')
            || str_contains($configuredCallback, 'trycloudflare.com')) {
            $this->callbackUrl = $defaultCallback;
        } else {
            $this->callbackUrl = $configuredCallback;
        }
    }

    /**
     * Initiate a payment via PayHero API (STK Push)
     */
    public function initiatePayment(float $amount, string $phoneNumber, string $reference, string $provider = 'm-pesa', string $networkCode = '63902'): array
    {
        $formattedPhone = $this->formatPhoneNumber($phoneNumber);
        $credentials    = $this->authToken ?: base64_encode($this->username . ':' . $this->password);
        $authorization  = str_starts_with($credentials, 'Basic ')
            ? $credentials
            : 'Basic ' . $credentials;

        $payload = [
            'amount'             => (float) $amount,
            'phone_number'       => $formattedPhone,
            'provider'           => $provider,
            'network_code'       => $networkCode,
            'channel_id'         => $this->channelId,
            'external_reference' => $reference,
            'callback_url'       => $this->callbackUrl,
        ];

        if (!empty($this->accountId)) {
            $payload['account_id'] = (int) $this->accountId;
        }

        Log::info('PayHero Payment Initiation Payload:', $payload);

        try {
            $response = Http::withHeaders([
                'Content-Type'  => 'application/json',
                'Authorization' => $authorization,
            ])->post('https://backend.payhero.co.ke/api/v2/payments', $payload);

            if ($response->successful()) {
                Log::info('PayHero Payment Response Success:', $response->json());
                return ['success' => true, 'data' => $response->json()];
            }

            $status = $response->status();
            $rawMsg = $response->json('error_message') ?? $response->json('message') ?? $response->body();

            Log::error('PayHero Payment Response Failure:', ['status' => $status, 'body' => $response->body()]);

            $friendlyMsg = 'PayHero request failed with status ' . $status . ': ' . $rawMsg;
            if ($status === 401 && (str_contains(strtolower((string) $rawMsg), 'unable to perform request') || empty($rawMsg))) {
                $friendlyMsg = "PayHero Authorization Failed (401: Unable to perform request). This typically occurs when: 1) The PayHero Service Wallet balance is 0.00 KES (top up KES 50-100 float on app.payhero.co.ke), 2) The API Username / Password has expired or changed, or 3) Channel ID ({$this->channelId}) is inactive.";
            } elseif ($status === 404) {
                $friendlyMsg = "PayHero Endpoint Not Found (404: $rawMsg). Please verify your PayHero API configuration.";
            }

            return [
                'success' => false,
                'status'  => $status,
                'raw'     => $rawMsg,
                'message' => $friendlyMsg,
            ];
        } catch (\Exception $e) {
            Log::error('PayHero Payment Exception: ' . $e->getMessage());
            return ['success' => false, 'message' => 'PayHero Request Error: ' . $e->getMessage()];
        }
    }

    /**
     * Format phone number to E.164-like format starting with 254.
     * e.g. 0722123456 → 254722123456
     */
    protected function formatPhoneNumber(string $phone): string
    {
        $phone = preg_replace('/\s+/', '', $phone); // strip spaces
        $phone = ltrim($phone, '+');               // remove leading +

        if (str_starts_with($phone, '0')) {
            $phone = '254' . substr($phone, 1);
        }

        return $phone;
    }

    /**
     * Check real-time payment status directly from PayHero API.
     * Used when the webhook has not yet arrived for a pending deposit,
     * so the frontend detects cancellations within the next poll cycle.
     *
     * IMPORTANT: Pass the CheckoutRequestID (ws_CO_...) here — that is what
     * PayHero's transaction-status endpoint looks up via the 'reference' param.
     * Passing the external_reference (DEP_xxx) returns a 404.
     *
     * @param  string $checkoutRequestId  The CheckoutRequestID returned by the STK push
     * @return array{status: string, network_message: string|null}
     *              status: QUEUED | SUCCESS | FAILED
     */
    public function checkStatus(string $checkoutRequestId): array
    {
        $credentials = $this->authToken ?: base64_encode($this->username . ':' . $this->password);
        $authorization = str_starts_with($credentials, 'Basic ')
            ? $credentials
            : 'Basic ' . $credentials;

        try {
            $response = Http::withHeaders([
                'Authorization' => $authorization,
            ])->get('https://backend.payhero.co.ke/api/v2/transaction-status', [
                'reference' => $checkoutRequestId,
            ]);

            if ($response->successful()) {
                $body = $response->json();
                Log::info('PayHero Status Check Response:', $body);

                // PayHero returns status as 'Success', 'Failed', 'QUEUED', etc.
                // ResultCode 0 = success; anything else is a failure or pending.
                $statusRaw  = strtoupper($body['status'] ?? $body['Status'] ?? 'QUEUED');
                $resultCode = $body['ResultCode'] ?? $body['result_code'] ?? null;
                $networkMsg = $body['ResultDesc'] ?? $body['result_desc']
                    ?? $body['network_message'] ?? $body['NetworkMessage'] ?? null;

                if ($statusRaw === 'SUCCESS' || (isset($resultCode) && (int) $resultCode === 0)) {
                    return ['status' => 'SUCCESS', 'network_message' => $networkMsg];
                }

                if ($statusRaw === 'FAILED' || $statusRaw === 'FAIL'
                    || (isset($resultCode) && (int) $resultCode !== 0)) {
                    return ['status' => 'FAILED', 'network_message' => $networkMsg];
                }

                return ['status' => 'QUEUED', 'network_message' => null];
            }

            Log::warning('PayHero Status Check Failed:', ['status' => $response->status(), 'body' => $response->body()]);
        } catch (\Exception $e) {
            Log::error('PayHero Status Check Exception: ' . $e->getMessage());
        }

        return ['status' => 'QUEUED', 'network_message' => null];
    }
}
