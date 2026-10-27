<?php

namespace App\Console\Commands;

use App\Support\MailHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\SiteSetting;

class TestSmtp extends Command
{
    protected $signature = 'mail:test {email : The email address to send the test to} {--welcome : Send the actual WelcomeEmail mailable instead of raw text}';
    protected $description = 'Send a test email using the current SMTP configuration to verify delivery';

    public function handle(): int
    {
        $to = $this->argument('email');
        $sendWelcome = (bool) $this->option('welcome');

        $fromAddress = trim((string) SiteSetting::get('mail_from_address')) ?: config('mail.from.address');
        $fromName    = trim((string) SiteSetting::get('mail_from_name')) ?: config('mail.from.name', 'Kenyan Baddies Club');

        $this->info('─────────────────────────────────────────');
        $this->info('  SMTP Configuration');
        $this->info('─────────────────────────────────────────');
        $this->line('  Host     : ' . (trim((string) SiteSetting::get('mail_host')) ?: config('mail.mailers.smtp.host')));
        $this->line('  Port     : ' . (trim((string) SiteSetting::get('mail_port')) ?: config('mail.mailers.smtp.port')));
        $this->line('  Username : ' . (trim((string) SiteSetting::get('mail_username')) ?: config('mail.mailers.smtp.username')));
        $this->line('  From     : ' . $fromAddress . ' (' . $fromName . ')');
        $this->line('  To       : ' . $to);
        $this->line('  Mode     : ' . ($sendWelcome ? 'Welcome Email (Full HTML Template + Verification URL)' : 'Raw Text Test'));
        $this->info('─────────────────────────────────────────');

        MailHelper::applySmtpSettings();

        $this->info('Sending ' . ($sendWelcome ? 'welcome email' : 'test email') . '...');

        try {
            if ($sendWelcome) {
                $testUser = new \App\Models\User();
                $testUser->id = 1;
                $testUser->name = 'Test Member';
                $testUser->email = $to;

                $verificationUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
                    'verification.verify',
                    now()->addMinutes(60),
                    ['id' => $testUser->id, 'hash' => sha1($testUser->email)]
                );

                $mailable = new \App\Mail\WelcomeEmail($testUser, $verificationUrl);
                Mail::to($to, $testUser->name)->send($mailable);
            } else {
                Mail::raw(
                    "This is a test email from Kenyan Baddies Club.\n\nSMTP is working correctly.\n\nSent at: " . now()->toDateTimeString(),
                    function ($message) use ($to, $fromAddress, $fromName) {
                        $message->to($to)
                                ->from($fromAddress, $fromName)
                                ->subject('SMTP Test - Kenyan Baddies Club');
                    }
                );
            }

            $this->info('');
            $this->info('SUCCESS! Test email sent to: ' . $to);
            $this->info('Check your inbox (and spam folder).');
            return self::SUCCESS;

        } catch (\Throwable $e) {
            $this->error('');
            $this->error('FAILED: ' . $e->getMessage() . ' at ' . basename($e->getFile()) . ':' . $e->getLine());
            $this->newLine();
            $this->warn('Common fixes:');
            $this->warn('  1. Check the email password in cPanel / SiteSettings');
            $this->warn('  2. Make sure port 465 (SSL/smtps) or 587 (TLS/smtp) is not blocked');
            $this->warn('  3. Verify the email account exists in cPanel -> Email Accounts');
            $this->warn('  4. Try port 587 with scheme=tls if 465/ssl fails');
            return self::FAILURE;
        }
    }
}
