<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>{{ $emailSubject }}</title>
  <style>
    *, *::before, *::after { box-sizing: border-box; }
    body, table, td, p, a, li { -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; }
    table, td { mso-table-lspace:0pt; mso-table-rspace:0pt; border-collapse:collapse; }
    img { -ms-interpolation-mode:bicubic; border:0; display:block; }

    body {
      margin:0; padding:0;
      background-color:#080808;
      font-family:'Segoe UI',-apple-system,BlinkMacSystemFont,'Helvetica Neue',Arial,sans-serif;
      color:#d4d4d4;
    }

    .email-shell { max-width:620px; margin:0 auto; padding:40px 16px 60px; }

    .card {
      background:#111111;
      border-radius:16px;
      overflow:hidden;
      border:1px solid rgba(255,140,0,0.18);
      box-shadow:0 0 60px rgba(255,140,0,0.05), 0 30px 60px rgba(0,0,0,0.5);
    }

    /* Header */
    .header-band {
      background:linear-gradient(135deg,#181818 0%,#0e0e0e 60%,#1a0d00 100%);
      padding:32px 40px;
      text-align:center;
      border-bottom:2px solid #ff8c00;
    }
    .brand-name { font-size:1.6rem; font-weight:900; letter-spacing:0.04em; line-height:1; }
    .brand-name .accent { color:#ff8c00; }
    .brand-name .dim    { color:#777; font-weight:400; }

    /* Subject bar */
    .subject-bar {
      background:#161616;
      border-bottom:1px solid rgba(255,140,0,0.1);
      padding:14px 40px;
    }
    .subject-label {
      font-size:0.68rem;
      font-weight:700;
      letter-spacing:0.14em;
      text-transform:uppercase;
      color:rgba(255,140,0,0.55);
      margin-bottom:4px;
    }
    .subject-text {
      font-size:1.05rem;
      font-weight:700;
      color:#ffffff;
      line-height:1.35;
    }

    /* Body */
    .body-section { padding:36px 40px 32px; }
    .greeting { font-size:1rem; color:#bbbbbb; margin:0 0 24px; line-height:1.6; }
    .greeting strong { color:#ffffff; font-weight:700; }
    .content { font-size:0.93rem; line-height:1.85; color:#cccccc; }

    /* Footer */
    .footer-band {
      background:#0a0a0a;
      border-top:1px solid rgba(255,140,0,0.08);
      padding:24px 40px;
      text-align:center;
    }
    .footer-brand { font-size:0.95rem; font-weight:800; margin-bottom:8px; color:#555; }
    .footer-brand .o { color:#ff8c00; }
    .footer-copy { font-size:0.69rem; color:#333; line-height:1.75; }

    @media only screen and (max-width:600px) {
      .email-shell { padding:10px 6px 40px; }
      .header-band,
      .subject-bar,
      .body-section,
      .footer-band { padding-left:22px !important; padding-right:22px !important; }
    }
  </style>
</head>
<body>

@php $logo = \App\Models\SiteSetting::get('logo'); @endphp

<div class="email-shell">
<div class="card">

  {{-- HEADER --}}
  <div class="header-band">
    @if($logo && \Illuminate\Support\Facades\Storage::disk('public')->exists($logo))
      <img src="{{ asset('storage/'.$logo) }}" alt="{{ $senderName }}" style="max-height:50px;width:auto;margin:0 auto;display:block;" />
    @else
      <div class="brand-name">
        <span class="accent">Baddies</span><span class="dim">-Club</span>
      </div>
    @endif
  </div>

  {{-- SUBJECT BAR --}}
  <div class="subject-bar">
    <div class="subject-label">Subject</div>
    <div class="subject-text">{{ $emailSubject }}</div>
  </div>

  {{-- BODY --}}
  <div class="body-section">
    @if(!empty($recipientName))
      <p class="greeting">Hi, <strong>{{ $recipientName }}</strong>,</p>
    @else
      <p class="greeting">Hello,</p>
    @endif

    <div class="content">{!! nl2br(e($emailBody)) !!}</div>

    <p style="margin:28px 0 0;font-size:0.82rem;color:#555555;line-height:1.6;">
      This message was sent to you by the {{ $senderName }} team.
    </p>
  </div>

  {{-- FOOTER --}}
  <div class="footer-band">
    <div class="footer-brand">
      <span class="o">{{ $senderName }}</span>
    </div>
    <div class="footer-copy">
      &copy; {{ date('Y') }} {{ $senderName }}. All rights reserved.<br>
      You received this email as a registered member of {{ $senderName }}.
    </div>
  </div>

</div>{{-- /card --}}
</div>{{-- /email-shell --}}

</body>
</html>
