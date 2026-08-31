<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'is_verified', 'subscription_plan', 'wallet_balance'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'is_blocked',
        'is_verified',
        'profile_photo',
        'phone_number',
        'gender',
        'sexual_orientation',
        'age',
        'nationality',
        'county',
        'city_town',
        'location',
        'area',
        'nearby_places',
        'services',
        'other_services',
        'incalls_rate',
        'outcalls_rate',
        'other_cities',
        'subscription_plan',
        'subscription_expires_at',
        'chat_plan',
        'chat_expires_at',
        'wallet_balance',
        'photo_limit',
        'video_limit',
        'profile_views',
        'phone_calls',
        'deletion_requested_at',
        'favorites_visibility',
        'photos_visibility',
        'email_notifications',
        'last_seen_at',
        'online_toast_enabled',
        'show_online_status_in_chat',
        'force_online',
        'online_toast_message',
        'online_toast_position',
        'online_toast_duration',
        'online_toast_sound',
        'online_threshold_minutes',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at'        => 'datetime',
            'password'                 => 'hashed',
            'is_admin'                 => 'boolean',
            'is_blocked'               => 'boolean',
            'is_verified'              => 'boolean',
            'services'                 => 'array',
            'subscription_expires_at'  => 'datetime',
            'chat_expires_at'          => 'datetime',
            'wallet_balance'           => 'decimal:2',
            'deletion_requested_at'    => 'datetime',
            'last_seen_at'             => 'datetime',
            'online_toast_enabled'       => 'boolean',
            'show_online_status_in_chat' => 'boolean',
            'force_online'               => 'boolean',
            'online_toast_duration'      => 'integer',
            'online_threshold_minutes'   => 'integer',
        ];
    }

    /**
     * Returns true if the user was active within the admin-configured threshold, or forced online.
     */
    public function isOnline(): bool
    {
        if ($this->force_online) return true;
        if (!$this->last_seen_at) return false;
        $minutes = \App\Models\Setting::getSettings()->online_threshold_minutes ?? 5;
        return $this->last_seen_at->gt(now()->subMinutes($minutes));
    }

    /**
     * Returns true if the user has an active subscription (plan set and not expired).
     */
    public function hasActiveSubscription(): bool
    {
        if (!$this->subscription_plan) {
            return false;
        }
        if ($this->subscription_expires_at && $this->subscription_expires_at->isPast()) {
            return false;
        }
        return true;
    }

    /**
     * Returns true if the user has an active chat subscription (plan set and not expired).
     */
    public function hasActiveChatSubscription(): bool
    {
        if (!$this->chat_plan) {
            return false;
        }
        if ($this->chat_expires_at && $this->chat_expires_at->isPast()) {
            return false;
        }
        return true;
    }

    /**
     * Get the maximum number of photos the user can upload based on their plan.
     */
    public function getPhotoLimitAttribute(): int
    {
        if (!$this->hasActiveSubscription()) {
            return 0;
        }

        return match ($this->subscription_plan) {
            'regular' => 4,
            'prime' => 5,
            'vip', 'prime_vip' => 10,
            default => 0,
        };
    }

    /**
     * Get the maximum number of videos the user can upload based on their plan.
     */
    public function getVideoLimitAttribute(): int
    {
        if (!$this->hasActiveSubscription()) {
            return 0;
        }

        return match ($this->subscription_plan) {
            'regular' => 2,
            'prime' => 3,
            'vip', 'prime_vip' => 5,
            default => 0,
        };
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_admin;
    }

    public function photos(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\UserPhoto::class);
    }

    public function videos(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\UserVideo::class);
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function verificationSubmission(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(\App\Models\VerificationSubmission::class);
    }

    public function classifieds(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Classified::class);
    }

    public function messagesSent(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Message::class, 'sender_id');
    }

    public function messagesReceived(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Message::class, 'receiver_id');
    }
}