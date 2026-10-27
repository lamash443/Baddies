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
        $port = (int) (trim((string) SiteSetting::get('mail_port')) ?: config('mail.mailers.smtp.port', 465));

        $rawEncryption = trim((string) SiteSetting::get('mail_encryption')) ?: config('mail.mailers.smtp.scheme', 'ssl');

        $scheme = match (strtolower(trim((string) $rawEncryption))) {
            'ssl', 'smtps' => 'smtps',
            'tls', 'starttls', 'smtp' => 'smtp',
            default => ($port === 465 ? 'smtps' : 'smtp'),
        };

        $host        = trim((string) SiteSetting::get('mail_host')) ?: config('mail.mailers.smtp.host');
        $username    = trim((string) SiteSetting::get('mail_username')) ?: config('mail.mailers.smtp.username');
        $password    = SiteSetting::get('mail_password') ?: config('mail.mailers.smtp.password');
        $fromAddress = trim((string) SiteSetting::get('mail_from_address')) ?: config('mail.from.address');
        $fromName    = trim((string) SiteSetting::get('mail_from_name')) ?: config('mail.from.name', 'Kenyan Baddies Club');
        $mailer      = trim((string) SiteSetting::get('mail_mailer')) ?: config('mail.default', 'smtp');

        config([
            'mail.default'                => $mailer,
            'mail.mailers.smtp.host'      => $host,
            'mail.mailers.smtp.port'      => $port,
            'mail.mailers.smtp.scheme'    => $scheme,
            'mail.mailers.smtp.username'  => $username,
            'mail.mailers.smtp.password'  => $password,
            'mail.mailers.smtp.from'      => ['address' => $fromAddress, 'name' => $fromName],
            'mail.from'                   => ['address' => $fromAddress, 'name' => $fromName],
            'mail.from.address'           => $fromAddress,
            'mail.from.name'              => $fromName,
        ]);

        // Purge cached mailers so new settings are picked up immediately
        app('mail.manager')->purge();
        app('mail.manager')->purge('smtp');
    }
}
