<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class BlockedIp extends Model
{
    protected $fillable = [
        'ip_address',
        'reason',
        'blocked_by',
        'blocked_at',
    ];

    protected $casts = [
        'blocked_at' => 'datetime',
    ];

    /**
     * The admin user who blocked this IP.
     */
    public function blocker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'blocked_by');
    }

    /**
     * Check if a given IP is blocked.
     */
    public static function isBlocked(?string $ip): bool
    {
        if (empty($ip)) {
            return false;
        }

        $trimmed = trim($ip);

        // Never block localhost/loopback to prevent lockouts
        if ($trimmed === '127.0.0.1' || $trimmed === '::1' || $trimmed === 'localhost') {
            return false;
        }

        try {
            return Cache::remember('blocked_ip_' . md5($trimmed), now()->addMinutes(10), function () use ($trimmed) {
                return static::where('ip_address', $trimmed)->exists();
            });
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Block an IP address.
     */
    public static function blockIp(string $ip, ?string $reason = null, ?int $userId = null): self
    {
        $trimmed = trim($ip);

        $blocked = static::updateOrCreate(
            ['ip_address' => $trimmed],
            [
                'reason' => $reason,
                'blocked_by' => $userId,
                'blocked_at' => now(),
            ]
        );

        Cache::forget('blocked_ip_' . md5($trimmed));
        Cache::forget('blocked_ips_count');

        return $blocked;
    }

    /**
     * Unblock an IP address.
     */
    public static function unblockIp(string $ip): bool
    {
        $trimmed = trim($ip);
        $deleted = static::where('ip_address', $trimmed)->delete();

        Cache::forget('blocked_ip_' . md5($trimmed));
        Cache::forget('blocked_ips_count');

        return $deleted > 0;
    }
}
