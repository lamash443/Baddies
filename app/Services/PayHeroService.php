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
        $this->callbackUrl = SiteSetting::get('payhero_callback_url', config('services.payhero.callback_url'));
    }

    /**
     * Initiate a payment via PayHero API (STK Push)
     */
    public function initiatePayment(float $amount, string $phoneNumber, string $reference, string $provider = 'm-pesa', string $networkCode = '63902'): array
    {
        $formattedPhone = $this->formatPhoneNumber($phoneNumber);
        $credentials    = $this->authToken ?: base64_encode($this->username . ':' . $this->password);

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
                'Authorization' => 'Basic ' . $credentials,
            ])->post('https://backend.payhero.co.ke/api/v2/payments', $payload);

            if ($response->successful()) {
                Log::info('PayHero Payment Response Success:', $response->json());
                return ['success' => true, 'data' => $response->json()];
            }

            Log::error('PayHero Payment Response Failure:', ['status' => $response->status(), 'body' => $response->body()]);

            return [
                'success' => false,
                'message' => 'PayHero request failed with status ' . $response->status() . ': '
                    . ($response->json('error_message') ?? $response->json('message') ?? $response->body()),
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

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . $credentials,
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
