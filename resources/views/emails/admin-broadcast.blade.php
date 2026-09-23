<x-mail::message>
@if(!empty($recipientName))
Hi **{{ $recipientName }}**,
@else
Hello,
@endif

{{ $emailBody }}

<x-mail::subcopy>
This message was sent to you by the **{{ $senderName }}** team as a registered member of our platform.
</x-mail::subcopy>
</x-mail::message>
