<x-mail::message>
# {{ \App\Models\SiteSetting::get('welcome_email_subheading', "Your account has been created. You're now part of Kenya's most exclusive companion network.") }}

Hi **{{ $user->name }}**, welcome aboard.

{{ \App\Models\SiteSetting::get('welcome_email_body', "We're thrilled to have you join Kenyan Baddies Club — a premium, members-only platform connecting Kenya's most exclusive companions with discerning clients.\n\nTo activate your account and unlock full access, please verify your email address by clicking the button below. Your verification link expires in 60 minutes.") }}

<x-mail::panel>
**{{ \App\Models\SiteSetting::get('welcome_email_feat1_title', 'VIP Profiles') }}**<br>
{{ \App\Models\SiteSetting::get('welcome_email_feat1_desc', 'Stand out with premium tier placement') }}

**{{ \App\Models\SiteSetting::get('welcome_email_feat2_title', 'Verified Badge') }}**<br>
{{ \App\Models\SiteSetting::get('welcome_email_feat2_desc', 'Build trust with a real photo badge') }}

**{{ \App\Models\SiteSetting::get('welcome_email_feat3_title', 'Private Chat') }}**<br>
{{ \App\Models\SiteSetting::get('welcome_email_feat3_desc', 'Message members discreetly & securely') }}
</x-mail::panel>

### Get started in 3 steps
1. **{{ \App\Models\SiteSetting::get('welcome_email_step1_title', 'Verify Your Email') }}**: {{ \App\Models\SiteSetting::get('welcome_email_step1_desc', 'Click the button below to confirm your address and fully activate your account.') }}
2. **{{ \App\Models\SiteSetting::get('welcome_email_step2_title', 'Complete Your Profile') }}**: {{ \App\Models\SiteSetting::get('welcome_email_step2_desc', 'Add photos, set your location, list your services, and personalise your listing.') }}
3. **{{ \App\Models\SiteSetting::get('welcome_email_step3_title', 'Choose a Membership Plan') }}**: {{ \App\Models\SiteSetting::get('welcome_email_step3_desc', 'Go VIP, Prime VIP, or Regular to get featured and start receiving clients.') }}

<x-mail::button :url="$verificationUrl" color="primary">
{{ \App\Models\SiteSetting::get('welcome_email_button_text', 'Verify My Email Address') }}
</x-mail::button>

<x-mail::subcopy>
This link expires in **60 minutes**. If expired, you can request a new one from your profile page.
</x-mail::subcopy>

**Security Notice:**<br>
{{ \App\Models\SiteSetting::get('welcome_email_security_note', 'If you did not create this account, simply ignore this email. Your email address will not be linked to any profile without verification. No further action is needed.') }}
</x-mail::message>
