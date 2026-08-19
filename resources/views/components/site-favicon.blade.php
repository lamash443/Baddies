{{-- Dynamic favicon from admin settings --}}
@php
    $faviconUrl = asset('favicon.ico');
    if (!empty($siteSettings['favicon'])) {
        $path = storage_path('app/public/' . $siteSettings['favicon']);
        $version = file_exists($path) ? filemtime($path) : time();
        $faviconUrl = asset('storage/' . $siteSettings['favicon']) . '?v=' . $version;
    }
@endphp
<link rel="icon" type="image/x-icon" href="{{ $faviconUrl }}">
<link rel="shortcut icon" href="{{ $faviconUrl }}">
