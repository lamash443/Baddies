<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $emailSubject }}</title>
  <style>
    body { margin:0; padding:0; background:#0d0d0d; font-family:'Segoe UI',Arial,sans-serif; color:#e0e0e0; }
    .wrapper { max-width:600px; margin:40px auto; background:#141414; border:1px solid rgba(255,140,0,0.25); border-radius:12px; overflow:hidden; }
    .header { background:linear-gradient(135deg,#1a1a1a 0%,#0d0d0d 100%); border-bottom:2px solid #ff8c00; padding:28px 36px; text-align:center; }
    .header-logo { font-size:1.6rem; font-weight:900; letter-spacing:0.03em; }
    .header-logo .accent { color:#ff8c00; }
    .header-logo .white { color:#ffffff; }
    .body-wrap { padding:36px 36px 28px; }
    .greeting { font-size:1rem; color:#bbbbbb; margin-bottom:20px; }
    .greeting strong { color:#ffffff; }
    .divider { height:1px; background:rgba(255,140,0,0.15); margin:20px 0; }
    .content { font-size:0.95rem; line-height:1.75; color:#cccccc; }
    .footer { background:#0d0d0d; border-top:1px solid rgba(255,140,0,0.12); padding:20px 36px; text-align:center; }
    .footer-text { font-size:0.78rem; color:#555555; line-height:1.6; }
    .badge { display:inline-block; background:rgba(255,140,0,0.12); border:1px solid rgba(255,140,0,0.35); color:#ff8c00; font-size:0.7rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; padding:3px 10px; border-radius:20px; margin-bottom:12px; }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="header">
      @php $logo = \App\Models\SiteSetting::get('logo'); @endphp
      @if($logo && \Illuminate\Support\Facades\Storage::disk('public')->exists($logo))
        <img src="{{ asset('storage/'.$logo) }}" alt="Logo" style="max-height:42px;width:auto;margin-bottom:4px;">
      @else
        <div class="header-logo">
          <span class="accent">Baddies</span><span class="white">-Club</span>
        </div>
      @endif
    </div>

    <div class="body-wrap">
      <div class="badge">Message from Admin</div>

      @if(!empty($recipientName))
        <div class="greeting">Hi, <strong>{{ $recipientName }}</strong> 👋</div>
      @else
        <div class="greeting">Hello there 👋</div>
      @endif

      <div class="divider"></div>

      <div class="content">{!! nl2br(e($emailBody)) !!}</div>

      <div class="divider"></div>

      <p style="font-size:0.82rem;color:#666666;margin:0;">
        This message was sent to you by the {{ $senderName }} team.
      </p>
    </div>

    <div class="footer">
      <div class="footer-text">
        &copy; {{ date('Y') }} {{ $senderName }}. All rights reserved.<br>
        You received this email as a registered member of {{ $senderName }}.
      </div>
    </div>
  </div>
</body>
</html>
