<x-mail::message>
# Support Ticket Reply

Hi **{{ $ticket->name }}**,

{!! nl2br(e($replyMessage)) !!}

Best regards,  
The **{{ config('app.name', 'Kenyan Baddies Club') }}** Team

<x-mail::panel>
**On {{ $ticket->created_at->format('M j, Y \a\t g:i A') }}, you wrote regarding "{{ $ticket->subject }}":**

{!! nl2br(e($ticket->message)) !!}
</x-mail::panel>

<x-mail::subcopy>
Ticket Reference: **#{{ $ticket->id }}** &middot; Status: **Resolved**  
If you have any further questions or if your issue has not been fully resolved, please feel free to reply directly to this email.
</x-mail::subcopy>
</x-mail::message>
