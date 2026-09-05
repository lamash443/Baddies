<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Page Not Found - Kenyan Baddies Club</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; }
    html, body { 
        margin:0; padding:0; 
        font-family: "Outfit", sans-serif; 
        background-color: #0d0d0d; 
        color: #fff; 
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        overflow: hidden;
    }
    
    .bg-grid {
        position: absolute; inset: 0; z-index: -1;
        background-size: 40px 40px;
        background-image: 
            linear-gradient(to right, rgba(255,140,0,0.05) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(255,140,0,0.05) 1px, transparent 1px);
        mask-image: radial-gradient(circle at center, black 30%, transparent 80%);
        -webkit-mask-image: radial-gradient(circle at center, black 30%, transparent 80%);
    }

    .error-container {
        position: relative;
        z-index: 1;
        padding: 3rem;
        max-width: 600px;
        background: rgba(17,17,17,0.7);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255,140,0,0.2);
        border-radius: 24px;
        box-shadow: 0 24px 64px rgba(0,0,0,0.8), 0 0 0 1px rgba(255,255,255,0.03), inset 0 0 40px rgba(255,140,0,0.05);
        animation: slideUpFade 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    }

    @keyframes slideUpFade {
        from { opacity: 0; transform: translateY(40px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .error-code {
        font-size: clamp(4rem, 10vw, 7rem);
        font-weight: 900;
        line-height: 1;
        letter-spacing: -0.04em;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, #ff8c00, #ffb347);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        filter: drop-shadow(0 10px 20px rgba(255,140,0,0.3));
    }

    .error-title {
        font-size: 1.75rem;
        font-weight: 800;
        margin-bottom: 1rem;
        color: #fff;
    }

    .error-note {
        font-size: 1.05rem;
        color: rgba(255,255,255,0.7);
        line-height: 1.6;
        margin-bottom: 2rem;
        padding: 0 1rem;
    }

    .btn-return {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        background: #ff8c00;
        color: #000;
        font-weight: 700;
        padding: 0.9rem 2rem;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 2px solid #ff8c00;
        letter-spacing: 0.02em;
    }

    .btn-return:hover {
        background: #000;
        color: #ff8c00;
        box-shadow: 0 10px 25px rgba(255,140,0,0.4);
        transform: translateY(-2px);
    }

    /* Light Theme Override */
    [data-bs-theme="light"] body { background-color: #f4f6f9; color: #111; }
    [data-bs-theme="light"] .bg-grid { background-image: linear-gradient(to right, rgba(255,140,0,0.1) 1px, transparent 1px), linear-gradient(to bottom, rgba(255,140,0,0.1) 1px, transparent 1px); }
    [data-bs-theme="light"] .error-container { background: #ffffff; border-color: rgba(255,140,0,0.3); box-shadow: 0 15px 40px rgba(0,0,0,0.08); }
    [data-bs-theme="light"] .error-title { color: #111; }
    [data-bs-theme="light"] .error-note { color: rgba(0,0,0,0.6); }
    [data-bs-theme="light"] .btn-return:hover { background: #ffffff; color: #ff8c00; }
  </style>
</head>
<body>
@php
  $siteLogo = \App\Models\SiteSetting::get('logo');
@endphp

  <div class="bg-grid"></div>

  <div class="error-container">
    <div class="mb-4">
        <a href="{{ url('/') }}" style="text-decoration: none; display: inline-block;">
            @if(!empty($siteLogo))
                <img src="{{ asset('storage/' . $siteLogo) }}" alt="Kenyan Baddies Club" style="max-height: 56px; width: auto; object-fit: contain;">
            @else
                <span style="font-size: 1.35rem; font-weight: 800; text-transform: uppercase; letter-spacing: 2px;"><span style="color: #ff8c00;">Baddies-</span><span style="color: #fff;">Club</span></span>
            @endif
        </a>
    </div>

    <div class="error-title" style="font-size: 2.2rem;">Welcome!</div>
    
    <div class="error-note" style="margin-bottom: 1rem; font-size: 1.15rem; font-weight: 500;">
        Seems like this page does not exist
    </div>
    
    <div class="error-note" style="margin-bottom: 2rem;">
        You can proceed to one of the website sections or follow either of the links below:
    </div>

    <a href="{{ url('/') }}" class="btn-return">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
            <polyline points="9 22 9 12 15 12 15 22"/>
        </svg>
        Home Page
    </a>
  </div>

</body>
</html>
