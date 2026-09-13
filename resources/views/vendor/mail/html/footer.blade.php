@php
  $appName   = config('app.name', 'Kenyan Baddies Club');
  $appHost   = parse_url(config('app.url', 'http://127.0.0.1:8000'), PHP_URL_HOST) ?: '127.0.0.1:8000';
  $supportEmail = 'support@' . $appHost;
@endphp
<tr>
<td style="padding-bottom: 6px;">
  <!-- Gradient divider -->
  <div style="height: 1px; background: linear-gradient(90deg, transparent, rgba(255,140,0,0.3), transparent); margin: 0 32px;"></div>

  <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
  <tr>
    <td class="content-cell" align="center" style="padding: 24px 32px 28px;">
      <p style="margin: 0 0 6px; font-size: 12px; color: #71717a;">
        Need help?
        <a href="mailto:{{ $supportEmail }}" style="color: #ff8c00; text-decoration: none;">{{ $supportEmail }}</a>
      </p>
      <p style="margin: 8px 0 4px; font-size: 11px; color: #52525b; letter-spacing: 0.5px; text-transform: uppercase;">
        © {{ date('Y') }} {{ $appName }} &middot; All rights reserved
      </p>
      <p style="margin: 4px 0 0; font-size: 11px; color: #3f3f46;">
        This is an automated message, please do not reply directly to this email.
      </p>
    </td>
  </tr>
  </table>

  <!-- Bottom accent bar -->
  <div style="height: 3px; background: linear-gradient(90deg, #ff5c00, #ff8c00, #ffb347, #ff8c00, #ff5c00); width: 100%;"></div>
</td>
</tr>
