@props(['url'])
@php
  $appName    = config('app.name', 'Kenyan Baddies Club');
  $setting    = \App\Models\Setting::getSettings();
  $logoPath   = $setting->logo ?? null;
  $logoUrl    = $logoPath ? url('storage/' . $logoPath) : null;
@endphp
<tr>
<td class="header" style="padding: 0;">
  <!-- Top gradient accent bar -->
  <div style="height: 4px; background: linear-gradient(90deg, #ff5c00, #ff8c00, #ffb347, #ff8c00, #ff5c00); width: 100%;"></div>

  <!-- Brand header -->
  <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
  <tr>
    <td align="center" style="padding: 28px 32px 22px; background: linear-gradient(180deg, rgba(255,140,0,0.06) 0%, transparent 100%); border-bottom: 1px solid rgba(255,140,0,0.1);">
      <a href="{{ $url }}" style="display: inline-flex; align-items: center; gap: 12px; text-decoration: none;">

        @if($logoUrl)
          {{-- Use the uploaded site logo --}}
          <img src="{{ $logoUrl }}"
               alt="{{ $appName }}"
               style="max-height: 48px; max-width: 160px; width: auto; object-fit: contain; display: block;">
        @else
          {{-- Fallback: Flame icon + name --}}
          <span style="
            display: inline-flex; align-items: center; justify-content: center;
            width: 42px; height: 42px; border-radius: 10px;
            background: linear-gradient(135deg, #ff8c00, #ff5c00);
            box-shadow: 0 4px 14px rgba(255,140,0,0.4);
            flex-shrink: 0;
          ">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M8.5 14.5A2.5 2.5 0 0 0 11 17c0 1.38-1.12 2.5-2.5 2.5S6 18.38 6 17c0-1.56.77-2.95 2-3.79V6s2.5 1.5 2.5 5"/>
              <path d="M16 15.5c0 2.49-2.01 4.5-4.5 4.5S7 17.99 7 15.5c0-2.04 1.44-3.75 3.38-4.28.36.78.62 1.74.62 2.78"/>
            </svg>
          </span>
          <span style="
            font-family: 'Outfit', -apple-system, BlinkMacSystemFont, Arial, sans-serif;
            font-size: 22px;
            font-weight: 900;
            color: #ffffff;
            letter-spacing: 0.5px;
          ">{{ $appName }}</span>
        @endif

      </a>
    </td>
  </tr>
  </table>
</td>
</tr>
