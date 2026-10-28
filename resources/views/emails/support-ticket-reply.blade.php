@php
  $appHost = parse_url(config('app.url', 'https://kenyanbaddies.com'), PHP_URL_HOST) ?: 'kenyanbaddies.com';
  if ($appHost === '127.0.0.1' || $appHost === 'localhost') {
      $appHost = 'kenyanbaddies.com';
  }
  $supportEmail = \App\Models\SiteSetting::get('support_email') ?: ('support@' . $appHost);

  $baseUrl = config('app.url', 'https://kenyanbaddies.com');
  if (str_contains($baseUrl, '127.0.0.1') || str_contains($baseUrl, 'localhost')) {
      $baseUrl = 'https://kenyanbaddies.com';
  }
  $baseUrl = rtrim($baseUrl, '/');

  $replyParams = http_build_query([
      'ticket_ref' => $ticket->reference,
      'subject'    => 'Re: ' . $ticket->subject,
      'name'       => $ticket->name,
      'email'      => $ticket->email,
  ]);
  $replyUrl = $baseUrl . '/contact?' . $replyParams;
@endphp

<x-mail::message>
<x-slot:preheader>You have received a reply to your support ticket — tap to read the full response.</x-slot:preheader>
# Support Ticket Reply

Hi **{{ $ticket->name }}**,

{!! nl2br(e($replyMessage)) !!}

Best regards,  
The **{{ config('app.name', 'Kenyan Baddies Club') }}** Team

<x-mail::panel>
**On {{ $ticket->created_at->format('M j, Y \a\t g:i A') }}, you wrote regarding "{{ $ticket->subject }}":**

{!! nl2br(e($ticket->message)) !!}
</x-mail::panel>

<x-mail::button :url="$replyUrl" color="primary">
Reply to this Ticket
</x-mail::button>

<x-mail::subcopy>
Ticket Reference: **#{{ $ticket->reference }}** &middot; Status: **Resolved**  
Need to follow up or have more questions? Click [{{ $supportEmail }}]({{ $replyUrl }}) or tap the button above to send a reply directly into our admin support system.
</x-mail::subcopy>
</x-mail::message>
