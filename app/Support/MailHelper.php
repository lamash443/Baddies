<?php

namespace App\Support;

use App\Models\SiteSetting;

class MailHelper
{
    /**
     * Apply admin-panel SMTP settings at runtime and purge the cached mailer.
     * Falls back to .env values when a SiteSetting key is not stored in the DB.
     */
    public static function applySmtpSettings(): void
    {
        $port = (int) SiteSetting::get('mail_port', config('mail.mailers.smtp.port', 465));

        $rawEncryption = SiteSetting::get('mail_encryption', config('mail.mailers.smtp.scheme', 'ssl'));

        $scheme = match (strtolower(trim((string) $rawEncryption))) {
            'ssl', 'smtps' => 'smtps',
            'tls', 'starttls', 'smtp' => 'smtp',
            default => ($port === 465 ? 'smtps' : 'smtp'),
        };

        config([
            'mail.default'                => SiteSetting::get('mail_mailer', config('mail.default', 'smtp')),
            'mail.mailers.smtp.host'      => SiteSetting::get('mail_host', config('mail.mailers.smtp.host')),
            'mail.mailers.smtp.port'      => $port,
            'mail.mailers.smtp.scheme'    => $scheme,
            'mail.mailers.smtp.username'  => SiteSetting::get('mail_username', config('mail.mailers.smtp.username')),
            'mail.mailers.smtp.password'  => SiteSetting::get('mail_password', config('mail.mailers.smtp.password')),
            'mail.from.address'           => SiteSetting::get('mail_from_address', config('mail.from.address')),
            'mail.from.name'              => SiteSetting::get('mail_from_name', config('mail.from.name', 'Baddies Club')),
        ]);

        // Purge cached mailer so new settings are picked up immediately
        app('mail.manager')->purge('smtp');
    }
}
