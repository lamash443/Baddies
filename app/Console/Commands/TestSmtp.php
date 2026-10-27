<?php

namespace App\Console\Commands;

use App\Support\MailHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\SiteSetting;

class TestSmtp extends Command
{
    protected $signature = 'mail:test {email : The email address to send the test to}';
    protected $description = 'Send a test email using the current SMTP configuration to verify delivery';

    public function handle(): int
    {
        $to = $this->argument('email');

        $fromAddress = SiteSetting::get('mail_from_address', config('mail.from.address'));
        $fromName    = SiteSetting::get('mail_from_name', config('mail.from.name'));


        $this->info('─────────────────────────────────────────');
        $this->info('  SMTP Configuration');
        $this->info('─────────────────────────────────────────');
        $this->line('  Host     : ' . SiteSetting::get('mail_host', config('mail.mailers.smtp.host')));
        $this->line('  Port     : ' . SiteSetting::get('mail_port', config('mail.mailers.smtp.port')));
        $this->line('  Username : ' . SiteSetting::get('mail_username', config('mail.mailers.smtp.username')));
        $this->line('  From     : ' . SiteSetting::get('mail_from_address', config('mail.from.address')) . ' (' . SiteSetting::get('mail_from_name', config('mail.from.name')) . ')');
        $this->line('  To       : ' . $to);
        $this->info('─────────────────────────────────────────');

        MailHelper::applySmtpSettings();

        $this->info('Sending test email...');

        try {
            Mail::raw(
                "This is a test email from Kenyan Baddies Club.\n\nSMTP is working correctly.\n\nSent at: " . now()->toDateTimeString(),
                function ($message) use ($to, $fromAddress, $fromName) {
                    $message->to($to)
                            ->from($fromAddress, $fromName)
                            ->subject('SMTP Test - Kenyan Baddies Club');
                }
            );

            $this->info('');
            $this->info('SUCCESS! Test email sent to: ' . $to);
            $this->info('Check your inbox (and spam folder).');
            return self::SUCCESS;

        } catch (\Exception $e) {
            $this->error('');
            $this->error('FAILED: ' . $e->getMessage());
            $this->newLine();
            $this->warn('Common fixes:');
            $this->warn('  1. Check the email password in cPanel / SiteSettings');
            $this->warn('  2. Make sure port 465 (SSL) or 587 (TLS) is not blocked');
            $this->warn('  3. Verify the email account exists in cPanel -> Email Accounts');
            $this->warn('  4. Try port 587 with scheme=tls if 465/ssl fails');
            return self::FAILURE;
        }
    }
}
