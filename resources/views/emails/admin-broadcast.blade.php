<x-mail::message>
<x-slot:preheader>Important message from the Kenyan Baddies Club team — open to read.</x-slot:preheader>
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
