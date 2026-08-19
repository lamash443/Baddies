{{-- Dynamic preloader from admin settings --}}
@php
    $preloaderUrl = !empty($siteSettings['preloader'])
        ? asset('storage/' . $siteSettings['preloader'])
        : null;
@endphp
@if($preloaderUrl)
<div id="site-preloader" style="
    position:fixed;inset:0;z-index:99999;
    background:#0d0d0d;
    display:flex;align-items:center;justify-content:center;
    transition:opacity 0.5s ease;
">
    <style>
        [data-bs-theme="light"] #site-preloader { background: #ffffff !important; }
    </style>
    <img src="{{ $preloaderUrl }}" alt="Loading..." style="max-width:180px;max-height:180px;object-fit:contain;">
</div>
<script>
    window.addEventListener('load', function() {
        var p = document.getElementById('site-preloader');
        if (p) {
            p.style.opacity = '0';
            setTimeout(function() { p.style.display = 'none'; }, 500);
        }
    });
</script>
@endif
