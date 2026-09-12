<?php

namespace App\Mail;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly User   $user,
        public readonly string $verificationUrl,
    ) {}

    public function envelope(): Envelope
    {
        $subject = SiteSetting::get(
            'welcome_email_subject',
            'Welcome to Baddies Club – Please Verify Your Email'
        );

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.welcome');
    }

    public function attachments(): array
    {
        return [];
    }
}
