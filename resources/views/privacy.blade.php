<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <x-site-favicon />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Privacy Policy - Baddies Club</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing:border-box; }
    html, body { margin:0; padding:0; font-family:"Outfit",sans-serif; background:#0d0d0d; color:#fff; min-height:100vh; }
    
    .page-header { padding:4rem 0 3rem; border-bottom:1px solid rgba(255,140,0,0.12); margin-bottom:3rem; }
    .page-title { font-size:clamp(2rem,5vw,3rem); font-weight:900; letter-spacing:-0.02em; line-height:1.1; margin-bottom:1rem; }
    .page-title span { background:linear-gradient(135deg,#ff8c00,#ffb347); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
    .page-sub { font-size:1.1rem; color:rgba(255,255,255,0.6); font-weight:400; max-width: 600px; margin: 0 auto; }
    
    .content-card {
      background:rgba(17,17,17,0.85); backdrop-filter:blur(15px);
      border:1px solid rgba(255,140,0,0.2); border-radius:24px; padding:3rem;
      box-shadow:0 8px 32px rgba(0,0,0,0.5); margin-bottom: 4rem;
      color: rgba(255,255,255,0.85);
      line-height: 1.7;
    }
    
    .content-card h2 { color: #fff; font-weight: 800; margin-top: 2rem; margin-bottom: 1rem; font-size: 1.5rem; display: flex; align-items: center; gap: 0.5rem; }
    .content-card h2::before { content: ""; display: inline-block; width: 8px; height: 24px; background: orange; border-radius: 4px; }
    .content-card h3 { color: rgba(255,255,255,0.95); font-weight: 700; margin-top: 1.5rem; margin-bottom: 0.8rem; font-size: 1.2rem; }
    .content-card p { margin-bottom: 1.2rem; }
    .content-card ul { margin-bottom: 1.5rem; padding-left: 1.5rem; }
    .content-card li { margin-bottom: 0.5rem; }
    .content-card a { color: orange; text-decoration: none; font-weight: 500; transition: color 0.2s; }
    .content-card a:hover { color: #ffb347; text-decoration: underline; }
    
    /* LIGHT THEME */
    [data-bs-theme="light"] body { background:#f4f6f9; color:#111; }
    [data-bs-theme="light"] .page-header { border-color:rgba(0,0,0,0.08); }
    [data-bs-theme="light"] .page-sub { color:rgba(0,0,0,0.6); }
    [data-bs-theme="light"] .content-card { background:#fff; border-color:rgba(255,140,0,0.3); box-shadow:0 10px 40px rgba(0,0,0,0.05); color: rgba(0,0,0,0.75); }
    [data-bs-theme="light"] .content-card h2 { color: #000; }
    [data-bs-theme="light"] .content-card h3 { color: rgba(0,0,0,0.9); }
  </style>
</head>
<body>
  <x-site-preloader />
  <x-navbar :hideSearch="true" />

  <div class="page-header text-center">
    <div class="container">
      <h1 class="page-title">Privacy <span>Policy</span></h1>
      <p class="page-sub">How we collect, use, and protect your data. Last updated: August 2026.</p>
    </div>
  </div>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10 col-xl-8">
        <div class="content-card">
          {!! $sitePage?->content !!}
          
          <p class="mt-5 small text-center" style="opacity:0.7;">If you have any questions about our privacy practices, please <a href="{{ route('contact') }}">contact our support team</a>.</p>
        </div>
      </div>
    </div>
  </div>

  <x-footer />
  <x-auth-modal />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
