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
                    $flag = GeoLocationService::getFlagEmoji($geo['country_code']);
                    $city = $geo['city'];
                    $country = $geo['country'];

                    try {
                        if (\Illuminate\Support\Facades\Schema::hasColumn('visitors', 'country')) {
                            $this->updateQuietly([
                                'country' => $geo['country'],
                                'country_code' => $geo['country_code'],
                                'city' => $geo['city'],
                                'region' => $geo['region'],
                            ]);
                        }
                    } catch (\Throwable $e) {
                        // Ignore if table columns are not yet migrated
                    }
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
     * Check if visitor was active within the last 15 minutes.
     */
    public function getIsOnlineAttribute(): bool
    {
        return $this->last_visit_at && $this->last_visit_at->greaterThanOrEqualTo(now()->subMinutes(15));
    }

    /**
     * Status indicator label.
     */
    public function getStatusLabelAttribute(): string
    {
        if ($this->is_online) {
            return 'Online Now';
        }
        if ($this->last_visit_at && $this->last_visit_at->greaterThanOrEqualTo(now()->startOfDay())) {
            return 'Active Today';
        }
        return 'Offline';
    }

    /**
     * Status color for badges.
     */
    public function getStatusColorAttribute(): string
    {
        if ($this->is_online) {
            return 'success';
        }
        if ($this->last_visit_at && $this->last_visit_at->greaterThanOrEqualTo(now()->startOfDay())) {
            return 'warning';
        }
        return 'gray';
    }

    /**
     * Operating system parser.
     */
    public function getOsNameAttribute(): string
    {
        $ua = $this->user_agent ?? '';
        if (preg_match('/iPhone|iPad|iPod/i', $ua)) return 'iOS';
        if (preg_match('/Android/i', $ua)) return 'Android';
        if (preg_match('/Windows NT 10.0/i', $ua)) return 'Windows 10/11';
        if (preg_match('/Windows NT/i', $ua)) return 'Windows';
        if (preg_match('/Macintosh|Mac OS X/i', $ua)) return 'macOS';
        if (preg_match('/Linux/i', $ua)) return 'Linux';
        return 'Unknown OS';
    }

    /**
     * Browser name parser.
     */
    public function getBrowserNameAttribute(): string
    {
        $ua = $this->user_agent ?? '';
        if (preg_match('/Edg/i', $ua)) return 'Edge';
        if (preg_match('/Opera|OPR/i', $ua)) return 'Opera';
        if (preg_match('/Chrome/i', $ua)) return 'Chrome';
        if (preg_match('/Firefox/i', $ua)) return 'Firefox';
        if (preg_match('/Safari/i', $ua)) return 'Safari';
        return 'Browser';
    }

    /**
     * Simplified device and browser parser from user_agent.
     */
    public function getDeviceAttribute(): string
    {
        $ua = $this->user_agent ?? '';

        if (empty($ua)) {
            return 'Desktop • Unknown';
        }

        $device = 'Desktop';
        if (preg_match('/iPad|Tablet/i', $ua)) {
            $device = 'Tablet';
        } elseif (preg_match('/iPhone|iPod|Android.*Mobile|Mobile/i', $ua)) {
            $device = 'Mobile';
        } elseif (preg_match('/Macintosh|Mac OS X/i', $ua)) {
            $device = 'Mac';
        } elseif (preg_match('/Windows/i', $ua)) {
            $device = 'Windows';
        } elseif (preg_match('/Linux/i', $ua)) {
            $device = 'Linux';
        }

        $browser = $this->browser_name;

        return "{$device} • {$browser}";
    }
}

