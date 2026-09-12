<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>{{ \App\Models\SiteSetting::get('welcome_email_subject', 'Welcome to Kenyan Baddies Club') }}</title>
  <!--[if mso]><noscript><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml></noscript><![endif]-->
  <style>
    /* Reset */
    *, *::before, *::after { box-sizing: border-box; }
    body, table, td, p, a, li, blockquote { -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; }
    table, td { mso-table-lspace:0pt; mso-table-rspace:0pt; border-collapse:collapse; }
    img { -ms-interpolation-mode:bicubic; border:0; display:block; }
    a { color:inherit; }

    /* Base */
    body {
      margin:0; padding:0;
      background-color:#080808;
      font-family:'Segoe UI',-apple-system,BlinkMacSystemFont,'Helvetica Neue',Arial,sans-serif;
      color:#d4d4d4;
    }

    /* Shell */
    .email-shell { max-width:620px; margin:0 auto; padding:40px 16px 60px; }

    /* Card */
    .card {
      background:#111111;
      border-radius:20px;
      overflow:hidden;
      border:1px solid rgba(255,140,0,0.18);
      box-shadow:0 0 60px rgba(255,140,0,0.06), 0 30px 60px rgba(0,0,0,0.6);
    }

    /* Header */
    .header-band {
      background:linear-gradient(135deg,#181818 0%,#0e0e0e 60%,#1a0d00 100%);
      padding:36px 40px 32px;
      text-align:center;
      border-bottom:1px solid rgba(255,140,0,0.15);
      position:relative;
    }
    .header-band::after {
      content:'';
      display:block;
      height:3px;
      background:linear-gradient(90deg,transparent,#ff8c00 30%,#ffb347 50%,#ff8c00 70%,transparent);
      position:absolute;
      bottom:0; left:0; right:0;
    }
    .brand-name { font-size:1.9rem; font-weight:900; letter-spacing:0.04em; line-height:1; }
    .brand-name .accent { color:#ff8c00; }
    .brand-name .dim    { color:#777; font-weight:400; }
    .brand-tagline {
      margin-top:7px;
      font-size:0.69rem;
      letter-spacing:0.22em;
      text-transform:uppercase;
      color:rgba(255,140,0,0.5);
      font-weight:600;
    }

    /* Hero */
    .hero {
      padding:44px 40px 32px;
      text-align:center;
      background:linear-gradient(180deg,#141414 0%,#111111 100%);
    }
    .hero-badge {
      display:inline-block;
      background:rgba(255,140,0,0.1);
      border:1px solid rgba(255,140,0,0.3);
      border-radius:50px;
      padding:6px 18px;
      font-size:0.72rem;
      letter-spacing:0.14em;
      text-transform:uppercase;
      color:#ff8c00;
      font-weight:700;
      margin-bottom:22px;
    }
    .hero-title {
      font-size:2rem;
      font-weight:900;
      color:#ffffff;
      line-height:1.2;
      margin:0 0 14px;
    }
    .hero-title .orange { color:#ff8c00; }
    .hero-subtitle {
      font-size:0.95rem;
      color:rgba(255,255,255,0.45);
      line-height:1.7;
      max-width:440px;
      margin:0 auto;
    }

    /* Body */
    .body-section { padding:8px 40px 36px; }
    .divider {
      height:1px;
      background:linear-gradient(90deg,transparent,rgba(255,140,0,0.12) 30%,rgba(255,140,0,0.12) 70%,transparent);
      margin:26px 0;
    }
    .greeting { font-size:1.05rem; color:#cccccc; line-height:1.6; margin-bottom:14px; }
    .greeting strong { color:#ffffff; font-weight:700; }
    .body-text { font-size:0.92rem; line-height:1.85; color:#aaaaaa; }

    /* Steps */
    .steps-section { margin:0 40px 32px; }
    .steps-label {
      font-size:0.7rem;
      letter-spacing:0.16em;
      text-transform:uppercase;
      color:rgba(255,255,255,0.28);
      margin-bottom:16px;
      font-weight:600;
    }
    .step { margin-bottom:16px; display:flex; align-items:flex-start; gap:14px; }
    .step-num {
      flex-shrink:0;
      width:28px; height:28px;
      border-radius:50%;
      background:linear-gradient(135deg,#ff8c00,#cc6e00);
      color:#000;
      font-size:0.75rem;
      font-weight:900;
      text-align:center;
      line-height:28px;
    }
    .step-title { font-size:0.85rem; font-weight:700; color:#ffffff; margin-bottom:2px; }
    .step-desc  { font-size:0.77rem; color:rgba(255,255,255,0.4); line-height:1.55; }

    /* CTA */
    .cta-section { text-align:center; padding:0 40px 36px; }
    .cta-eyebrow {
      font-size:0.7rem;
      letter-spacing:0.16em;
      text-transform:uppercase;
      color:rgba(255,255,255,0.28);
      margin-bottom:18px;
      font-weight:600;
    }
    .cta-btn {
      display:inline-block;
      background:linear-gradient(135deg,#ff8c00,#ffb347);
      color:#000000 !important;
      font-size:1rem;
      font-weight:800;
      padding:16px 48px;
      border-radius:12px;
      text-decoration:none !important;
      letter-spacing:0.04em;
      box-shadow:0 8px 32px rgba(255,140,0,0.38);
    }
    .cta-note {
      margin-top:16px;
      font-size:0.74rem;
      color:rgba(255,255,255,0.25);
      line-height:1.6;
    }
    .cta-link-box {
      margin-top:14px;
      padding:12px 16px;
      background:rgba(255,255,255,0.03);
      border-radius:8px;
      border:1px solid rgba(255,255,255,0.06);
    }
    .cta-link-box a {
      font-size:0.69rem;
      color:#ff8c00 !important;
      text-decoration:none;
      word-break:break-all;
      line-height:1.6;
    }

    /* Security notice */
    .info-notice {
      margin:0 40px 36px;
      padding:16px 20px;
      background:rgba(255,140,0,0.05);
      border:1px solid rgba(255,140,0,0.15);
      border-left:3px solid #ff8c00;
      border-radius:10px;
      font-size:0.8rem;
      color:rgba(255,255,255,0.5);
      line-height:1.7;
    }
    .info-notice strong { color:#ff8c00; }

    /* Footer */
    .footer-band {
      background:#0a0a0a;
      border-top:1px solid rgba(255,140,0,0.08);
      padding:28px 40px 26px;
      text-align:center;
    }
    .footer-brand { font-size:1rem; font-weight:800; margin-bottom:10px; color:#666; }
    .footer-brand .o { color:#ff8c00; }
    .footer-links { margin-bottom:14px; }
    .footer-links a {
      font-size:0.73rem;
      color:#444 !important;
      text-decoration:none;
      margin:0 8px;
    }
    .footer-copy { font-size:0.69rem; color:#333; line-height:1.75; }

    /* Mobile */
    @media only screen and (max-width:600px) {
      .email-shell { padding:12px 6px 40px; }
      .header-band,
      .hero,
      .body-section,
      .cta-section,
      .footer-band { padding-left:22px !important; padding-right:22px !important; }
      .info-notice,
      .steps-section { margin-left:22px !important; margin-right:22px !important; }
      .hero-title { font-size:1.55rem !important; }
      .brand-name { font-size:1.45rem !important; }
      .step { flex-direction:column; gap:6px; }
    }
  </style>
</head>
<body>

@php
  // Pull all admin-controlled values with sensible defaults
  $subject       = \App\Models\SiteSetting::get('welcome_email_subject',       'Welcome to Kenyan Baddies Club – Please Verify Your Email');
  $subheading    = \App\Models\SiteSetting::get('welcome_email_subheading',    "Your account has been created. You're now part of Kenya's most exclusive companion network.");
  $body          = \App\Models\SiteSetting::get('welcome_email_body',          "We're thrilled to have you join Kenyan Baddies Club — a premium, members-only platform connecting Kenya's most exclusive companions with discerning clients.\n\nTo activate your account and unlock full access, please verify your email address by clicking the button below. Your verification link expires in 60 minutes.");
  $btnText       = \App\Models\SiteSetting::get('welcome_email_button_text',   '&#x2705; Verify My Email Address');
  $brandTagline  = \App\Models\SiteSetting::get('welcome_email_brand_tagline', "Kenya's Premier Companion Network");

  $feat1Title    = \App\Models\SiteSetting::get('welcome_email_feat1_title', 'VIP Profiles');
  $feat1Desc     = \App\Models\SiteSetting::get('welcome_email_feat1_desc',  'Stand out with premium tier placement');
  $feat2Title    = \App\Models\SiteSetting::get('welcome_email_feat2_title', 'Verified Badge');
  $feat2Desc     = \App\Models\SiteSetting::get('welcome_email_feat2_desc',  'Build trust with a real photo badge');
  $feat3Title    = \App\Models\SiteSetting::get('welcome_email_feat3_title', 'Private Chat');
  $feat3Desc     = \App\Models\SiteSetting::get('welcome_email_feat3_desc',  'Message members discreetly & securely');

  $step1Title    = \App\Models\SiteSetting::get('welcome_email_step1_title', 'Verify Your Email');
  $step1Desc     = \App\Models\SiteSetting::get('welcome_email_step1_desc',  'Click the button below to confirm your address and fully activate your account.');
  $step2Title    = \App\Models\SiteSetting::get('welcome_email_step2_title', 'Complete Your Profile');
  $step2Desc     = \App\Models\SiteSetting::get('welcome_email_step2_desc',  'Add photos, set your location, list your services, and personalise your listing.');
  $step3Title    = \App\Models\SiteSetting::get('welcome_email_step3_title', 'Choose a Membership Plan');
  $step3Desc     = \App\Models\SiteSetting::get('welcome_email_step3_desc',  'Go VIP, Prime VIP, or Regular to get featured and start receiving clients.');

  $securityNote  = \App\Models\SiteSetting::get('welcome_email_security_note', 'If you did not create this account, simply ignore this email. Your email address will not be linked to any profile without verification. No further action is needed.');

  $logo = \App\Models\SiteSetting::get('logo');
@endphp

<div class="email-shell">
<div class="card">

  {{-- HEADER --}}
  <div class="header-band">
    @if($logo && \Illuminate\Support\Facades\Storage::disk('public')->exists($logo))
      <img src="{{ asset('storage/'.$logo) }}" alt="Kenyan Baddies Club" style="max-height:50px;width:auto;margin:0 auto 10px;" />
    @else
      <div class="brand-name">
        <span class="accent">KENYAN</span>&nbsp;<span style="color:#fff;">BADDIES</span>&nbsp;<span class="dim">CLUB</span>
      </div>
    @endif
    <div class="brand-tagline">{{ $brandTagline }}</div>
  </div>

  {{-- HERO --}}
  <div class="hero">
    <div class="hero-badge">&#x1F525; New Member</div>
    <h1 class="hero-title">
      Welcome to the<br><span class="orange">Inner Circle</span>
    </h1>
    <p class="hero-subtitle">{{ $subheading }}</p>
  </div>

  {{-- BODY --}}
  <div class="body-section">
    <p class="greeting">Hi, <strong>{{ $user->name }}</strong> &#x1F44B; welcome aboard.</p>
    <div class="divider"></div>
    <p class="body-text">{!! nl2br(e($body)) !!}</p>
  </div>

  {{-- FEATURE HIGHLIGHTS --}}
  <div style="padding:0 40px;margin-bottom:36px;">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
      <tr>
        <td width="33%" style="padding:14px 8px;text-align:center;vertical-align:top;">
          <div style="width:46px;height:46px;border-radius:12px;background:rgba(255,140,0,0.1);border:1px solid rgba(255,140,0,0.2);margin:0 auto 10px;line-height:46px;font-size:1.3rem;">&#x1F48E;</div>
          <div style="font-size:0.78rem;font-weight:700;color:#fff;margin-bottom:4px;">{{ $feat1Title }}</div>
          <div style="font-size:0.69rem;color:rgba(255,255,255,0.38);line-height:1.5;">{{ $feat1Desc }}</div>
        </td>
        <td width="33%" style="padding:14px 8px;text-align:center;vertical-align:top;">
          <div style="width:46px;height:46px;border-radius:12px;background:rgba(255,140,0,0.1);border:1px solid rgba(255,140,0,0.2);margin:0 auto 10px;line-height:46px;font-size:1.3rem;">&#x2705;</div>
          <div style="font-size:0.78rem;font-weight:700;color:#fff;margin-bottom:4px;">{{ $feat2Title }}</div>
          <div style="font-size:0.69rem;color:rgba(255,255,255,0.38);line-height:1.5;">{{ $feat2Desc }}</div>
        </td>
        <td width="33%" style="padding:14px 8px;text-align:center;vertical-align:top;">
          <div style="width:46px;height:46px;border-radius:12px;background:rgba(255,140,0,0.1);border:1px solid rgba(255,140,0,0.2);margin:0 auto 10px;line-height:46px;font-size:1.3rem;">&#x1F4AC;</div>
          <div style="font-size:0.78rem;font-weight:700;color:#fff;margin-bottom:4px;">{{ $feat3Title }}</div>
          <div style="font-size:0.69rem;color:rgba(255,255,255,0.38);line-height:1.5;">{{ $feat3Desc }}</div>
        </td>
      </tr>
    </table>
  </div>

  {{-- 3-STEP GUIDE --}}
  <div class="steps-section">
    <div class="steps-label">Get started in 3 steps</div>

    <div class="step">
      <div class="step-num">1</div>
      <div>
        <div class="step-title">{{ $step1Title }}</div>
        <div class="step-desc">{{ $step1Desc }}</div>
      </div>
    </div>

    <div class="step">
      <div class="step-num">2</div>
      <div>
        <div class="step-title">{{ $step2Title }}</div>
        <div class="step-desc">{{ $step2Desc }}</div>
      </div>
    </div>

    <div class="step">
      <div class="step-num">3</div>
      <div>
        <div class="step-title">{{ $step3Title }}</div>
        <div class="step-desc">{{ $step3Desc }}</div>
      </div>
    </div>
  </div>

  <div style="height:1px;background:linear-gradient(90deg,transparent,rgba(255,140,0,0.12) 30%,rgba(255,140,0,0.12) 70%,transparent);margin:4px 40px 36px;"></div>

  {{-- CTA --}}
  <div class="cta-section">
    <div class="cta-eyebrow">Action Required</div>
    <a href="{{ $verificationUrl }}" class="cta-btn">{!! $btnText !!}</a>
    <p class="cta-note">
      This link expires in <strong style="color:rgba(255,255,255,0.45);">60 minutes</strong>.
      If expired, you can request a new one from your profile page.
    </p>
    <div class="cta-link-box">
      <span style="font-size:0.67rem;color:#3a3a3a;display:block;margin-bottom:5px;">Or copy &amp; paste this link into your browser:</span>
      <a href="{{ $verificationUrl }}">{{ $verificationUrl }}</a>
    </div>
  </div>

  {{-- SECURITY NOTICE --}}
  <div class="info-notice">
    <strong>&#x1F512; Security Notice:</strong>
    {{ $securityNote }}
  </div>

  {{-- FOOTER --}}
  <div class="footer-band">
    <div class="footer-brand">
      <span class="o">Kenyan</span> Baddies Club
    </div>
    <div class="footer-links">
      <a href="{{ url('/') }}">Visit Site</a>
      <span style="color:#222;">&nbsp;|&nbsp;</span>
      <a href="{{ url('/profile') }}">My Profile</a>
      <span style="color:#222;">&nbsp;|&nbsp;</span>
      <a href="{{ url('/contact') }}">Support</a>
      <span style="color:#222;">&nbsp;|&nbsp;</span>
      <a href="{{ url('/privacy') }}">Privacy</a>
    </div>
    <div class="footer-copy">
      &copy; {{ date('Y') }} Kenyan Baddies Club. All rights reserved.<br>
      You received this email because you registered an account on our platform.<br>
      This is an automated message &mdash; please do not reply directly to this email.
    </div>
  </div>

</div>{{-- /card --}}
</div>{{-- /email-shell --}}

</body>
</html>
