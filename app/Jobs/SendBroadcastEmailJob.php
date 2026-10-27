<?php

namespace App\Jobs;

use App\Mail\AdminBroadcastMail;
use App\Models\SiteSetting;
use App\Models\User;
use App\Support\MailHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendBroadcastEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 60;

    public function __construct(
        public readonly User   $user,
        public readonly string $subject,
        public readonly string $body,
        public readonly string $senderName = 'Baddies Club',
    ) {}

    public function handle(): void
    {
        // Apply admin-panel SMTP settings (with .env fallback)
        MailHelper::applySmtpSettings();

        $fromName = SiteSetting::get('mail_from_name', config('mail.from.name', 'Baddies Club'));

        try {
            Mail::to($this->user->email, $this->user->name)
                ->send(new AdminBroadcastMail(
                    emailSubject:  $this->subject,
                    emailBody:     $this->body,
                    recipientName: $this->user->name ?? '',
                    senderName:    $fromName,
                ));

            // Log success
            \App\Models\EmailLog::create([
                'user_id'         => $this->user->id,
                'recipient_email' => $this->user->email,
                'recipient_name'  => $this->user->name,
                'subject'         => $this->subject,
                'type'            => 'broadcast',
                'status'          => 'sent',
            ]);

        } catch (\Exception $e) {
            // Log failure
            \App\Models\EmailLog::create([
                'user_id'         => $this->user->id,
                'recipient_email' => $this->user->email,
                'recipient_name'  => $this->user->name,
                'subject'         => $this->subject,
                'type'            => 'broadcast',
                'status'          => 'failed',
                'error_message'   => $e->getMessage(),
            ]);

            throw $e; // Re-throw so the job retries
        }
    }

}
