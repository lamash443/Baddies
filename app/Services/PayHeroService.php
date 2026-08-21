<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayHeroService
{
    protected ?string $username;
    protected ?string $password;
    protected ?string $authToken;
    protected int $channelId;
    protected string $callbackUrl;

    public function __construct()
    {
        $this->username = config('services.payhero.username');
        $this->password = config('services.payhero.password');
        $this->authToken = config('services.payhero.auth_token');
        $this->channelId = (int) config('services.payhero.channel_id');
        $this->callbackUrl = config('services.payhero.callback_url');
    }

    /**
     * Initiate a payment via PayHero API
     *
     * @param float $amount
     * @param string $phoneNumber
     * @param string $reference
     * @param string $provider
     * @param string $networkCode
     * @return array
     */
    public function initiatePayment(float $amount, string $phoneNumber, string $reference, string $provider = 'm-pesa', string $networkCode = '63902'): array
    {
        $formattedPhone = $this->formatPhoneNumber($phoneNumber);
        $credentials = $this->authToken ?: base64_encode($this->username . ':' . $this->password);

        $payload = [
            'amount' => (float) $amount,
            'phone_number' => $formattedPhone,
            'provider' => $provider,
            'network_code' => $networkCode,
            'channel_id' => $this->channelId,
            'external_reference' => $reference,
            'callback_url' => $this->callbackUrl,
        ];

        Log::info('PayHero Payment Initiation Payload:', $payload);

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . $credentials,
            ])->post('https://backend.payhero.co.ke/api/v2/payments', $payload);

            if ($response->successful()) {
                Log::info('PayHero Payment Response Success:', $response->json());
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }

            Log::error('PayHero Payment Response Failure:', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return [
                'success' => false,
                'message' => 'PayHero request failed with status ' . $response->status() . ': ' . ($response->json('error_message') ?? $response->json('message') ?? $response->body())
            ];
        } catch (\Exception $e) {
            Log::error('PayHero Payment Exception: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'PayHero Request Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Format phone number to standard format.
     * Starts with 254... e.g. 254708344101
     */
    protected function formatPhoneNumber(string $phone): string
    {
        $phone = preg_replace('/\s+/', '', $phone); // remove spaces
        $phone = ltrim($phone, '+'); // remove leading plus

        if (str_starts_with($phone, '0')) {
            $phone = '254' . substr($phone, 1);
        }

        return $phone;
    }
}
