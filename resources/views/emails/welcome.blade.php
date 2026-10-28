<x-mail::message>
<x-slot:preheader>Welcome to Kenyan Baddies Club — verify your email to activate your account.</x-slot:preheader>
# {{ $subheading }}

Hi **{{ $user->name }}**, welcome aboard.

{{ $bodyText }}

<x-mail::panel>
**{{ $feat1Title }}**<br>
{{ $feat1Desc }}

**{{ $feat2Title }}**<br>
{{ $feat2Desc }}

**{{ $feat3Title }}**<br>
{{ $feat3Desc }}
</x-mail::panel>

### Get started in 3 steps
1. **{{ $step1Title }}**: {{ $step1Desc }}
2. **{{ $step2Title }}**: {{ $step2Desc }}
3. **{{ $step3Title }}**: {{ $step3Desc }}

<x-mail::button :url="$verificationUrl" color="primary">
{{ $buttonText }}
</x-mail::button>

<x-mail::subcopy>
This link expires in **60 minutes**. If expired, you can request a new one from your profile page.
</x-mail::subcopy>

**Security Notice:**<br>
{{ $securityNote }}
</x-mail::message>
