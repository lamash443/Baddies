<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="color-scheme" content="dark"/>
  <meta name="supported-color-schemes" content="dark"/>
  <title>Reset Your Password · <?php echo e($appName); ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;900&display=swap" rel="stylesheet"/>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Outfit', -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
      background-color: #0d0d0f;
      color: #d4d4d8;
      -webkit-text-size-adjust: none;
      width: 100%;
      margin: 0;
      padding: 0;
    }
    .email-wrapper {
      width: 100%;
      background-color: #0d0d0f;
      padding: 40px 16px;
    }
    .email-container {
      max-width: 580px;
      margin: 0 auto;
      background: #16161a;
      border-radius: 16px;
      border: 1px solid #27272a;
      overflow: hidden;
      box-shadow: 0 20px 60px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,140,0,0.05);
    }
    /* Top gradient bar */
    .accent-bar {
      height: 4px;
      background: linear-gradient(90deg, #ff5c00, #ff8c00, #ffb347, #ff8c00, #ff5c00);
    }
    /* Header */
    .header {
      padding: 32px 40px 24px;
      text-align: center;
      background: linear-gradient(180deg, rgba(255,140,0,0.06) 0%, transparent 100%);
      border-bottom: 1px solid rgba(255,140,0,0.1);
    }
    .brand {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
    }
    .brand-icon {
      width: 42px; height: 42px;
      border-radius: 10px;
      background: linear-gradient(135deg, #ff8c00, #ff5c00);
      display: inline-flex; align-items: center; justify-content: center;
      box-shadow: 0 4px 14px rgba(255,140,0,0.4);
      flex-shrink: 0;
    }
    .brand-name {
      font-size: 22px;
      font-weight: 900;
      color: #ffffff;
      letter-spacing: 0.5px;
    }
    /* Body */
    .body {
      padding: 36px 40px 32px;
    }
    .icon-wrap {
      width: 64px; height: 64px;
      border-radius: 50%;
      background: rgba(255,140,0,0.08);
      border: 1.5px solid rgba(255,140,0,0.25);
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 24px;
    }
    .email-title {
      font-size: 22px;
      font-weight: 800;
      color: #ffffff;
      text-align: center;
      margin-bottom: 10px;
      letter-spacing: -0.3px;
    }
    .email-subtitle {
      font-size: 14px;
      color: #71717a;
      text-align: center;
      margin-bottom: 28px;
      line-height: 1.6;
    }
    .divider {
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(255,140,0,0.2), transparent);
      margin: 28px 0;
    }
    .email-body-text {
      font-size: 15px;
      color: #a1a1aa;
      line-height: 1.7;
      margin-bottom: 16px;
    }
    .email-body-text strong {
      color: #e4e4e7;
    }
    /* CTA Button */
    .btn-wrap {
      text-align: center;
      margin: 30px 0 28px;
    }
    .cta-button {
      display: inline-block;
      background: linear-gradient(135deg, #ff8c00, #ff5c00);
      color: #ffffff !important;
      text-decoration: none;
      font-size: 15px;
      font-weight: 800;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      padding: 14px 36px;
      border-radius: 10px;
      box-shadow: 0 6px 20px rgba(255,140,0,0.35);
    }
    /* Info box */
    .info-box {
      background: rgba(255,140,0,0.05);
      border: 1px solid rgba(255,140,0,0.18);
      border-left: 3px solid #ff8c00;
      border-radius: 8px;
      padding: 14px 18px;
      margin-bottom: 24px;
    }
    .info-box p {
      font-size: 13px;
      color: #a1a1aa;
      line-height: 1.6;
      margin: 0;
    }
    .info-box strong {
      color: #ffb347;
    }
    /* URL fallback */
    .url-fallback {
      background: #111113;
      border: 1px solid #27272a;
      border-radius: 8px;
      padding: 14px 16px;
      margin-top: 8px;
    }
    .url-fallback p {
      font-size: 12px;
      color: #71717a;
      margin-bottom: 6px;
    }
    .url-fallback a {
      font-size: 11px;
      color: #ff8c00;
      word-break: break-all;
      text-decoration: none;
    }
    /* Footer */
    .footer {
      padding: 20px 40px 28px;
      text-align: center;
      border-top: 1px solid rgba(255,140,0,0.08);
    }
    .footer p {
      font-size: 12px;
      color: #3f3f46;
      line-height: 1.7;
      margin: 4px 0;
    }
    .footer a {
      color: #52525b;
      text-decoration: underline;
    }
    .footer-brand {
      font-size: 11px;
      color: #27272a;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      margin-top: 12px;
    }
    /* Bottom bar */
    .bottom-bar {
      height: 3px;
      background: linear-gradient(90deg, #ff5c00, #ff8c00, #ffb347, #ff8c00, #ff5c00);
    }
    @media only screen and (max-width: 600px) {
      .email-wrapper { padding: 0 !important; }
      .email-container { border-radius: 0 !important; border-left: none !important; border-right: none !important; }
      .header { padding: 24px 24px 20px !important; }
      .body { padding: 28px 24px 24px !important; }
      .footer { padding: 18px 24px 24px !important; }
      .cta-button { display: block !important; text-align: center !important; }
    }
  </style>
</head>
<body>
  <div class="email-wrapper">
    <div class="email-container">

      <!-- Top accent -->
      <div class="accent-bar"></div>

      <!-- Header / Brand -->
      <?php
        $setting  = \App\Models\Setting::getSettings();
        $logoPath = $setting->logo ?? null;
        $logoUrl  = $logoPath ? url('storage/' . $logoPath) : null;
      ?>
      <div class="header">
        <a href="<?php echo e($appUrl); ?>" class="brand">
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($logoUrl): ?>
            <img src="<?php echo e($logoUrl); ?>" alt="<?php echo e($appName); ?>" style="max-height: 48px; max-width: 160px; width: auto; object-fit: contain; display: block;">
          <?php else: ?>
            <span class="brand-icon">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M8.5 14.5A2.5 2.5 0 0 0 11 17c0 1.38-1.12 2.5-2.5 2.5S6 18.38 6 17c0-1.56.77-2.95 2-3.79V6s2.5 1.5 2.5 5"/>
                <path d="M16 15.5c0 2.49-2.01 4.5-4.5 4.5S7 17.99 7 15.5c0-2.04 1.44-3.75 3.38-4.28.36.78.62 1.74.62 2.78"/>
              </svg>
            </span>
            <span class="brand-name"><?php echo e($appName); ?></span>
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </a>
      </div>

      <!-- Body -->
      <div class="body">

        <!-- Lock icon -->
        <div style="text-align:center;">
          <div class="icon-wrap" style="display:inline-flex;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ff8c00" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
              <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
          </div>
        </div>

        <div style="height:20px;"></div>

        <p class="email-title">Reset Your Password</p>
        <p class="email-subtitle">
          Hi<?php echo e($user->name ? ', ' . $user->name : ''); ?> 👋<br>
          We received a request to reset the password for your account.
        </p>

        <div class="divider"></div>

        <p class="email-body-text">
          Click the button below to set a new password. This link is valid for
          <strong><?php echo e($expireTime); ?> minutes</strong> and can only be used once.
        </p>

        <!-- CTA -->
        <div class="btn-wrap">
          <a href="<?php echo e($url); ?>" class="cta-button" target="_blank">Reset Password</a>
        </div>

        <!-- Warning box -->
        <div class="info-box">
          <p>
            <strong>⚠ Didn't request this?</strong><br>
            If you did not request a password reset, you can safely ignore this email.
            Your password will <strong>not</strong> change unless you click the link above.
          </p>
        </div>

        <!-- URL fallback -->
        <div class="url-fallback">
          <p>If the button doesn't work, copy and paste this link into your browser:</p>
          <a href="<?php echo e($url); ?>"><?php echo e($url); ?></a>
        </div>

      </div>

      <!-- Footer -->
      <div class="footer">
        <p>© <?php echo e(date('Y')); ?> <strong style="color:#52525b;"><?php echo e($appName); ?></strong> · All rights reserved.</p>
        <p>
          Need help?
          <a href="mailto:support{{ parse_url($appUrl, PHP_URL_HOST) }}">support{{ parse_url($appUrl, PHP_URL_HOST) }}</a>
        </p>
        <p class="footer-brand">This is an automated email — please do not reply directly.</p>
      </div>

      <!-- Bottom accent -->
      <div class="bottom-bar"></div>

    </div>
  </div>
</body>
</html>
<?php /**PATH C:\Users\willi\Desktop\Kenyan Baddies Club\resources\views\emails\auth\reset-password.blade.php ENDPATH**/ ?>