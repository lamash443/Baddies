<?php

namespace App\Mail;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class WelcomeEmail extends Mailable
{
    // All data pre-fetched in the constructor so:
    //  (a) any DB error is caught by the caller's try-catch
    //  (b) no SiteSetting calls run inside Blade or envelope() outside the catch
    public string $subheading;
    public string $bodyText;
    public string $feat1Title;
    public string $feat1Desc;
    public string $feat2Title;
    public string $feat2Desc;
    public string $feat3Title;
    public string $feat3Desc;
    public string $step1Title;
    public string $step1Desc;
    public string $step2Title;
    public string $step2Desc;
    public string $step3Title;
    public string $step3Desc;
    public string $buttonText;
    public string $securityNote;
    public string $emailSubject;

    public function __construct(
        public User   $user,
        public string $verificationUrl,
    ) {
        $this->emailSubject = SiteSetting::get('welcome_email_subject', 'Welcome to Baddies Club – Please Verify Your Email');
        $this->subheading   = SiteSetting::get('welcome_email_subheading', "Your account has been created. You're now part of Kenya's most exclusive companion network.");
        $this->bodyText     = SiteSetting::get('welcome_email_body', "We're thrilled to have you join Kenyan Baddies Club — a premium, members-only platform connecting Kenya's most exclusive companions with discerning clients.\n\nTo activate your account and unlock full access, please verify your email address by clicking the button below. Your verification link expires in 60 minutes.");
        $this->feat1Title   = SiteSetting::get('welcome_email_feat1_title', 'VIP Profiles');
        $this->feat1Desc    = SiteSetting::get('welcome_email_feat1_desc', 'Stand out with premium tier placement');
        $this->feat2Title   = SiteSetting::get('welcome_email_feat2_title', 'Verified Badge');
        $this->feat2Desc    = SiteSetting::get('welcome_email_feat2_desc', 'Build trust with a real photo badge');
        $this->feat3Title   = SiteSetting::get('welcome_email_feat3_title', 'Private Chat');
        $this->feat3Desc    = SiteSetting::get('welcome_email_feat3_desc', 'Message members discreetly & securely');
        $this->step1Title   = SiteSetting::get('welcome_email_step1_title', 'Verify Your Email');
        $this->step1Desc    = SiteSetting::get('welcome_email_step1_desc', 'Click the button below to confirm your address and fully activate your account.');
        $this->step2Title   = SiteSetting::get('welcome_email_step2_title', 'Complete Your Profile');
        $this->step2Desc    = SiteSetting::get('welcome_email_step2_desc', 'Add photos, set your location, list your services, and personalise your listing.');
        $this->step3Title   = SiteSetting::get('welcome_email_step3_title', 'Choose a Membership Plan');
        $this->step3Desc    = SiteSetting::get('welcome_email_step3_desc', 'Go VIP, Prime VIP, or Regular to get featured and start receiving clients.');
        $this->buttonText   = SiteSetting::get('welcome_email_button_text', 'Verify My Email Address');
        $this->securityNote = SiteSetting::get('welcome_email_security_note', 'If you did not create this account, simply ignore this email. Your email address will not be linked to any profile without verification. No further action is needed.');
    }

    public function envelope(): Envelope
    {
        // Use the pre-fetched subject — no DB call here
        return new Envelope(subject: $this->emailSubject);
    }

    public function content(): Content
    {
        return new Content(markdown: 'emails.welcome');
    }

    public function attachments(): array
    {
        return [];
    }
}
