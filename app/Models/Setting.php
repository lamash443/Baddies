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
    ];

    protected $casts = [
        'unlock_banner_enabled' => 'boolean',
        'profile_banner_enabled' => 'boolean',
    ];

    /**
     * Get settings row or create a default one.
     */
    public static function getSettings()
    {
        return self::firstOrCreate([], [
            'unlock_banner_enabled' => true,
            'unlock_banner_title' => 'Unlock Exclusive Account',
            'unlock_banner_description' => 'Please verify your account first. Complete the verification process to unlock an Exclusive Account with priority visibility.',
            'unlock_banner_button_text' => 'Verify Account',
            'profile_banner_enabled' => true,
            'profile_banner_title' => 'Complete Your Profile',
            'profile_banner_description' => 'Your profile is incomplete. Add your phone number, gender, age, nationality and location so clients can find you.',
            'profile_banner_button_text' => 'Update Profile',
        ]);
    }
}
