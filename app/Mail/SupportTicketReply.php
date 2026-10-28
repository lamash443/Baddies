<?php

namespace App\Mail;

use App\Models\SiteSetting;
use App\Models\SupportTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SupportTicketReply extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public SupportTicket $ticket,
        public string $replyMessage,
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $fromAddress = trim((string) SiteSetting::get('mail_from_address')) ?: config('mail.from.address', 'noreply@kenyanbaddies.com');
        $fromName    = trim((string) SiteSetting::get('mail_from_name')) ?: config('mail.from.name', 'Kenyan Baddies Club');

        return new Envelope(
            from: new Address($fromAddress, $fromName),
            subject: 'Re: ' . $this->ticket->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.support-ticket-reply',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
