<?php

namespace App\Models;

use App\Services\GeoLocationService;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'ip_address',
        'country',
        'country_code',
        'city',
        'region',
        'user_agent',
        'first_visit_at',
        'last_visit_at',
        'visits_count',
        'total_time_seconds',
        'visit_date',
    ];
    
    protected $casts = [
        'first_visit_at' => 'datetime',
        'last_visit_at' => 'datetime',
        'visit_date' => 'date',
        'total_time_seconds' => 'integer',
        'visits_count' => 'integer',
    ];

    /**
     * Get human-readable formatted time on site.
     */
    public function getFormattedTimeOnSiteAttribute(): string
    {
        $seconds = $this->effective_time_seconds;

        if ($seconds < 60) {
            return "{$seconds}s";
        }

        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $remainingSeconds = $seconds % 60;

        if ($hours > 0) {
            return "{$hours}h {$minutes}m" . ($remainingSeconds > 0 ? " {$remainingSeconds}s" : '');
        }

        return "{$minutes}m" . ($remainingSeconds > 0 ? " {$remainingSeconds}s" : '');
    }

    /**
     * Return calculated seconds if total_time_seconds is 0 or null (for legacy records).
     */
    public function getEffectiveTimeSecondsAttribute(): int
    {
        if ($this->total_time_seconds > 0) {
            return (int) $this->total_time_seconds;
        }

        // Estimate for older records: time difference between first visit/created_at and last_visit_at
        $start = $this->first_visit_at ?? $this->created_at;
        $end = $this->last_visit_at;

        if ($start && $end && $end->greaterThan($start)) {
            $diff = $end->diffInSeconds($start);
            // Cap single session estimation to reasonable range, min 30s per visit
            return (int) max($diff, ($this->visits_count ?? 1) * 35);
        }

        return (int) max(45, ($this->visits_count ?? 1) * 30);
    }

    /**
     * Get country flag emoji.
     */
    public function getCountryFlagAttribute(): string
    {
        return GeoLocationService::getFlagEmoji($this->country_code);
    }

    /**
     * Get location formatted string (e.g., "🇰🇪 Nairobi, Kenya").
     */
    public function getLocationStringAttribute(): string
    {
        $flag = $this->country_flag;
        $city = $this->city;
        $country = $this->country;

        if (empty($city) && empty($country)) {
            if ($this->ip_address) {
                // Auto resolve on the fly if not cached
                $geo = GeoLocationService::lookup($this->ip_address);
                if (!empty($geo['country'])) {
                    $this->updateQuietly([
                        'country' => $geo['country'],
                        'country_code' => $geo['country_code'],
                        'city' => $geo['city'],
                        'region' => $geo['region'],
                    ]);
                    $flag = GeoLocationService::getFlagEmoji($geo['country_code']);
                    $city = $geo['city'];
                    $country = $geo['country'];
                }
            }
        }

        if (empty($country) || $country === 'Unknown') {
            return '🌐 Location Unknown';
        }

        $parts = array_filter([$city, $country]);
        return trim("{$flag} " . implode(', ', $parts));
    }

    /**
     * Simplified device and browser parser from user_agent.
     */
    public function getDeviceAttribute(): string
    {
        $ua = $this->user_agent ?? '';

        if (empty($ua)) {
            return 'Desktop / Unknown';
        }

        $device = 'Desktop';
        if (preg_match('/iPhone|iPad|iPod/i', $ua)) {
            $device = 'iOS Device';
        } elseif (preg_match('/Android/i', $ua)) {
            $device = 'Android';
        } elseif (preg_match('/Mobile/i', $ua)) {
            $device = 'Mobile';
        } elseif (preg_match('/Macintosh|Mac OS X/i', $ua)) {
            $device = 'Mac';
        } elseif (preg_match('/Windows/i', $ua)) {
            $device = 'Windows';
        } elseif (preg_match('/Linux/i', $ua)) {
            $device = 'Linux';
        }

        $browser = 'Browser';
        if (preg_match('/Chrome/i', $ua) && !preg_match('/Edg/i', $ua)) {
            $browser = 'Chrome';
        } elseif (preg_match('/Safari/i', $ua) && !preg_match('/Chrome/i', $ua)) {
            $browser = 'Safari';
        } elseif (preg_match('/Firefox/i', $ua)) {
            $browser = 'Firefox';
        } elseif (preg_match('/Edg/i', $ua)) {
            $browser = 'Edge';
        } elseif (preg_match('/Opera|OPR/i', $ua)) {
            $browser = 'Opera';
        }

        return "{$device} • {$browser}";
    }
}

