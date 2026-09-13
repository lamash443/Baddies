@props([
    'url',
    'color' => 'primary',
    'align' => 'center',
])
<table class="action" align="{{ $align }}" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="{{ $align }}" style="padding: 10px 0 20px;">
<table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="{{ $align }}">
<table border="0" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td style="border-radius: 8px; overflow: hidden; box-shadow: 0 4px 16px rgba(255, 140, 0, 0.35);">
  <a href="{{ $url }}"
     class="button button-{{ $color }}"
     target="_blank"
     rel="noopener"
     style="
       font-family: 'Outfit', sans-serif;
       font-size: 15px;
       font-weight: 700;
       letter-spacing: 0.05em;
       text-transform: uppercase;
     ">{!! $slot !!}</a>
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
