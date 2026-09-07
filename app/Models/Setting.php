<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'unlock_banner_enabled',
        'unlock_banner_title',
        'unlock_banner_description',
        'unlock_banner_button_text',
        'profile_banner_enabled',
        'profile_banner_title',
        'profile_banner_description',
        'profile_banner_button_text',
        // Online Status Controls
        'online_toast_enabled',
        'online_toast_message',
        'online_toast_duration',
        'online_toast_position',
        'online_toast_sound',
        'show_online_status_in_chat',
        'online_threshold_minutes',
        // Email Verification
        'verification_toast_message',
        // Referral
        'referral_commission_rate',
    ];

    protected $casts = [
        'unlock_banner_enabled'     => 'boolean',
        'profile_banner_enabled'    => 'boolean',
        'online_toast_enabled'      => 'boolean',
        'show_online_status_in_chat'=> 'boolean',
        'online_toast_duration'     => 'integer',
        'online_threshold_minutes'  => 'integer',
        'referral_commission_rate'  => 'decimal:2',
    ];

    /**
     * Get settings row or create a default one.
     */
    public static function getSettings()
    {
        return self::firstOrCreate([], [
            'unlock_banner_enabled'      => true,
            'unlock_banner_title'        => 'Unlock Exclusive Account',
            'unlock_banner_description'  => 'Please verify your account first. Complete the verification process to unlock an Exclusive Account with priority visibility.',
            'unlock_banner_button_text'  => 'Verify Account',
            'profile_banner_enabled'     => true,
            'profile_banner_title'       => 'Complete Your Profile',
            'profile_banner_description' => 'Your profile is incomplete. Add your phone number, gender, age, nationality and location so clients can find you.',
            'profile_banner_button_text' => 'Update Profile',
            // Online defaults
            'online_toast_enabled'       => true,
            'online_toast_message'       => '💚 {name} is now online!',
            'online_toast_duration'      => 4000,
            'online_toast_position'      => 'bottom-right',
            'online_toast_sound'         => 'none',
            'show_online_status_in_chat' => true,
            'online_threshold_minutes'   => 5,
            'verification_toast_message' => 'A new verification link has been sent to your email address.',
            'referral_commission_rate'   => 10.00,
        ]);
    }
}
