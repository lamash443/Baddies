<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GeoLocationService
{
    /**
     * Resolve IP address to location details (cached for 30 days).
     *
     * @param string|null $ip
     * @return array{country: ?string, country_code: ?string, city: ?string, region: ?string}
     */
    public static function lookup(?string $ip): array
    {
        if (empty($ip)) {
            return [
                'country' => 'Unknown',
                'country_code' => null,
                'city' => 'Unknown',
                'region' => null,
            ];
        }

        // Check if IP is loopback or private network
        if (self::isPrivateOrLocal($ip)) {
            return [
                'country' => 'Kenya (Local)',
                'country_code' => 'KE',
                'city' => 'Nairobi',
                'region' => 'Nairobi County',
            ];
        }

        $cacheKey = 'ip_geo_' . md5($ip);

        return Cache::remember($cacheKey, now()->addDays(30), function () use ($ip) {
            try {
                // 1. Try ip-api.com (fast, no token required)
                $response = Http::timeout(2)
                    ->get("http://ip-api.com/json/{$ip}", [
                        'fields' => 'status,message,country,countryCode,regionName,city',
                    ]);

                if ($response->successful() && ($response->json('status') === 'success')) {
                    return [
                        'country' => $response->json('country'),
                        'country_code' => strtoupper($response->json('countryCode') ?? ''),
                        'city' => $response->json('city'),
                        'region' => $response->json('regionName'),
                    ];
                }
            } catch (\Throwable $e) {
                // Fallback attempt
            }

            try {
                // 2. Fallback to freeipapi.com
                $fallback = Http::timeout(2)->get("https://freeipapi.com/api/json/{$ip}");
                if ($fallback->successful() && $fallback->json('countryName')) {
                    return [
                        'country' => $fallback->json('countryName'),
                        'country_code' => strtoupper($fallback->json('countryCode') ?? ''),
                        'city' => $fallback->json('cityName'),
                        'region' => $fallback->json('regionName'),
                    ];
                }
            } catch (\Throwable $e) {
                // Ignore fallback error
            }

            return [
                'country' => 'Unknown',
                'country_code' => null,
                'city' => null,
                'region' => null,
            ];
        });
    }

    /**
     * Check if IP is localhost, private subnet, or loopback.
     */
    public static function isPrivateOrLocal(string $ip): bool
    {
        return $ip === '127.0.0.1'
            || $ip === '::1'
            || str_starts_with($ip, '192.168.')
            || str_starts_with($ip, '10.')
            || preg_match('/^172\.(1[6-9]|2[0-9]|3[0-1])\./', $ip) === 1
            || $ip === 'localhost';
    }

    /**
     * Convert 2-letter ISO country code into emoji flag.
     */
    public static function getFlagEmoji(?string $countryCode): string
    {
        if (!$countryCode || strlen($countryCode) !== 2) {
            return '🌐';
        }

        $code = strtoupper($countryCode);
        $ordA = ord('A');
        $first = ord($code[0]) - $ordA;
        $second = ord($code[1]) - $ordA;

        if ($first < 0 || $first > 25 || $second < 0 || $second > 25) {
            return '🌐';
        }

        // Regional Indicator Symbol Letter A is 0x1F1E6
        return mb_chr(0x1F1E6 + $first) . mb_chr(0x1F1E6 + $second);
    }
}
