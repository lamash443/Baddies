<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Hot Hookups - Baddies Club</title>
  <meta name="description" content="Your soulmate is waiting for you. Join Baddies Club and start your love life today.">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; }
    html, body { margin:0; padding:0; font-family:"Outfit",sans-serif; background:#0d0d0d; color:#fff; min-height:100vh; }

    /* NAVBAR */
    .nr-navbar {
      background: linear-gradient(160deg, #0d0d0d 0%, #1a0f00 50%, #0d0d0d 100%) !important;
      border-bottom: 2px solid rgba(255,140,0,0.6);
      box-shadow: inset 0 -2px 30px rgba(255,140,0,0.06);
      padding-top:1.25rem !important;
      padding-bottom:1.25rem !important;
    }
    .nr-navbar .nav-link {
      font-weight:500; font-size:0.82rem;
      color:rgba(255,140,0,0.92) !important;
      text-decoration:none !important;
      display:inline-block !important;
      position:relative !important;
      padding-bottom:3px !important;
      box-shadow:none !important;
      transition:color 0.3s ease !important;
    }
    .nr-navbar .nav-link::after {
      content:"" !important; position:absolute !important;
      left:0 !important; bottom:0 !important;
      width:100% !important; height:1.5px !important;
      background:linear-gradient(90deg,rgba(255,255,255,0) 0%,rgba(255,255,255,0.9) 50%,rgba(255,255,255,0) 100%) !important;
      border-radius:2px !important;
      transform:scaleX(0) !important; transform-origin:center !important;
      transition:transform 0.35s cubic-bezier(0.4,0,0.2,1) !important;
    }
    .nr-navbar .nav-link.active,
    .nr-navbar .nav-link:hover,
    .nr-navbar .nav-link:focus {
      color:#ffffff !important; text-decoration:none !important; box-shadow:none !important;
    }
    .nr-navbar .nav-link.active::after,
    .nr-navbar .nav-link:hover::after,
    .nr-navbar .nav-link:focus::after { transform:scaleX(1) !important; }

    /* HERO */
    .hh-hero {
      min-height:100vh; display:flex; align-items:center; justify-content:center;
      position:relative; overflow:hidden; padding:6rem 1.5rem 4rem;
    }
    .hh-hero__bg {
      position:absolute; inset:0;
      background-image:url("/hot-hookups-hero.png");
      background-size:cover; background-position:center;
      filter:brightness(0.22) saturate(1.2); z-index:0;
    }
    .hh-hero__overlay {
      position:absolute; inset:0;
      background:radial-gradient(ellipse at center,rgba(255,140,0,0.08) 0%,transparent 70%),
                 linear-gradient(180deg,rgba(13,13,13,0.3) 0%,rgba(26,15,0,0.55) 50%,rgba(13,13,13,0.9) 100%);
      z-index:1;
    }
    .hh-hearts { position:absolute; inset:0; z-index:1; pointer-events:none; overflow:hidden; }
    .hh-heart {
      position:absolute; opacity:0;
      animation:floatHeart linear infinite;
      filter:drop-shadow(0 0 6px rgba(255,140,0,0.6));
    }
    @keyframes floatHeart {
      0%   { transform:translateY(100vh) scale(0.5) rotate(-15deg); opacity:0; }
      10%  { opacity:0.7; }
      90%  { opacity:0.4; }
      100% { transform:translateY(-10vh) scale(1.2) rotate(15deg); opacity:0; }
    }

    /* HERO SPLIT LAYOUT */
    .hh-hero__inner {
      position:relative; z-index:2; width:100%; max-width:1280px; margin:0 auto;
      padding:0 1.5rem;
      display:grid;
      grid-template-columns:1fr 1fr;
      gap:3rem;
      align-items:center;
    }
    @media(max-width:991px){
      .hh-hero__inner {
        grid-template-columns:1fr;
        text-align:center;
      }
      .hh-hero__left { display:flex; flex-direction:column; align-items:center; }
      .hh-body { margin-left:auto !important; margin-right:auto !important; }
    }
    .hh-hero__content { position:relative; z-index:2; max-width:780px; margin:0 auto; }

    /* MATCH FINDER CARD */
    .hh-finder-card {
      background:rgba(10,10,10,0.82);
      backdrop-filter:blur(20px) saturate(1.4);
      -webkit-backdrop-filter:blur(20px) saturate(1.4);
      border:1px solid rgba(255,140,0,0.28);
      border-radius:20px;
      padding:2.4rem 2rem;
      box-shadow:0 8px 48px rgba(0,0,0,0.55), 0 0 0 1px rgba(255,140,0,0.08) inset;
      animation:fadeInUp 0.7s ease 0.5s both;
      position:relative;
      overflow:hidden;
    }
    .hh-finder-card::before {
      content:""; position:absolute; top:-60px; right:-60px;
      width:200px; height:200px;
      background:radial-gradient(circle, rgba(255,140,0,0.12) 0%, transparent 70%);
      pointer-events:none;
    }
    .hh-finder-card__title {
      font-size:1.55rem; font-weight:800; letter-spacing:-0.02em;
      background:linear-gradient(135deg,#ff8c00,#ffb347);
      -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
      margin-bottom:0.4rem;
    }
    .hh-finder-card__sub {
      font-size:0.82rem; font-weight:400; color:rgba(255,255,255,0.52);
      line-height:1.6; margin-bottom:1.8rem;
    }
    .hh-finder-divider {
      height:1px; background:linear-gradient(90deg,transparent,rgba(255,140,0,0.35),transparent);
      margin-bottom:1.6rem;
    }
    .hh-field { margin-bottom:1.2rem; }
    .hh-field label {
      display:block; font-size:0.72rem; font-weight:600; letter-spacing:0.1em;
      text-transform:uppercase; color:rgba(255,140,0,0.85); margin-bottom:0.45rem;
    }
    .hh-select {
      width:100%; background:#111;
      border:1.5px solid rgba(255,140,0,0.3);
      border-radius:10px; color:#fff;
      padding:0.7rem 1rem;
      font-family:"Outfit",sans-serif; font-size:0.92rem; font-weight:500;
      appearance:none; -webkit-appearance:none;
      background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23ff8c00' stroke-width='2' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
      background-repeat:no-repeat;
      background-position:right 1rem center;
      transition:border-color 0.25s ease, box-shadow 0.25s ease;
      cursor:pointer;
    }
    .hh-select:focus {
      outline:none;
      border-color:rgba(255,140,0,0.8);
      box-shadow:0 0 0 3px rgba(255,140,0,0.12);
    }
    .hh-select option { background:#1a1a1a; color:#fff; }
    .hh-age-row { display:grid; grid-template-columns:1fr 1fr; gap:0.75rem; }
    .hh-search-btn {
      width:100%; margin-top:0.5rem;
      padding:0.85rem 1rem;
      background-color:orange;
      border:2px solid orange;
      border-radius:0.4rem;
      font-family:"Outfit",sans-serif; font-size:1rem; font-weight:700;
      color:#000; letter-spacing:0.04em;
      cursor:pointer; position:relative; overflow:hidden;
      transition:color 0.3s ease, background-color 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease;
      display:flex; align-items:center; justify-content:center; gap:0.5rem;
    }
    .hh-search-btn::before {
      content:""; position:absolute; inset:0;
      background:radial-gradient(circle at center, rgba(255,255,255,0.35) 0%, transparent 70%);
      opacity:0; transition:opacity 0.3s ease;
    }
    .hh-search-btn:hover {
      background-color:#000;
      border-color:orange;
      color:orange;
      box-shadow:0 0 18px rgba(255,165,0,0.65), 0 4px 14px rgba(0,0,0,0.35);
      transform:translateY(-2px) scale(1.03);
    }
    .hh-search-btn:hover::before { opacity:1; }
    .hh-search-btn:active { transform:translateY(0) scale(0.98); box-shadow:0 0 10px rgba(255,165,0,0.4); }
    .hh-search-btn svg { flex-shrink:0; position:relative; z-index:1; }
    .hh-search-btn span { position:relative; z-index:1; }
    .hh-finder-note {
      text-align:center; margin-top:1rem;
      font-size:0.72rem; color:rgba(255,255,255,0.3);
    }
    .hh-finder-note span { color:rgba(255,140,0,0.7); }

    .hh-hero__left { text-align:left; }
    @media(max-width:991px){ .hh-hero__left { text-align:center; } }

    .hh-badge {
      display:inline-flex; align-items:center; gap:0.5rem;
      background:rgba(255,140,0,0.12); border:1px solid rgba(255,140,0,0.4);
      border-radius:50px; padding:0.4rem 1.2rem;
      font-size:0.78rem; font-weight:600; letter-spacing:0.08em; text-transform:uppercase;
      color:rgba(255,140,0,0.92); margin-bottom:2rem;
      backdrop-filter:blur(8px); animation:fadeInDown 0.6s ease both;
    }
    .hh-badge .dot {
      width:6px; height:6px; background:rgba(255,140,0,0.92); border-radius:50%;
      animation:pulseDot 1.8s infinite;
    }
    @keyframes pulseDot { 0%,100%{opacity:1;transform:scale(1);} 50%{opacity:0.5;transform:scale(1.5);} }

    .hh-heading {
      font-size:clamp(2.4rem,6vw,5rem); font-weight:900;
      line-height:1.1; letter-spacing:-0.02em; margin-bottom:1.8rem;
      animation:fadeInUp 0.7s ease 0.15s both;
    }
    .hh-heading span {
      background:linear-gradient(135deg,#ff8c00,#ffb347,#ff6b35);
      -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
    }
    .hh-body {
      font-size:clamp(0.95rem,1.8vw,1.1rem); font-weight:300; line-height:1.85;
      color:rgba(255,255,255,0.78); margin-bottom:2.8rem;
      max-width:520px;
      animation:fadeInUp 0.7s ease 0.3s both;
    }
    .hh-body strong { color:rgba(255,180,60,0.95); font-weight:600; }

    .hh-btn-wrap { animation:fadeInUp 0.7s ease 0.45s both; }
    .hh-cta {
      display:inline-flex; align-items:center; gap:0.6rem;
      padding:0.5rem 1.5rem;
      font-family:"Outfit",sans-serif; font-size:0.95rem; font-weight:700; letter-spacing:0.03em;
      color:#000 !important;
      background-color:orange;
      border:2px solid orange;
      border-radius:0.4rem; cursor:pointer; text-decoration:none;
      position:relative; overflow:hidden;
      transition:color 0.3s ease, background-color 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease;
    }
    .hh-cta::before {
      content:""; position:absolute; inset:0;
      background:radial-gradient(circle at center, rgba(255,255,255,0.35) 0%, transparent 70%);
      opacity:0; transition:opacity 0.3s ease;
    }
    .hh-cta:hover { background-color:#000; border-color:orange; color:orange !important; box-shadow:0 0 18px rgba(255,165,0,0.65),0 4px 14px rgba(0,0,0,0.35); transform:translateY(-2px) scale(1.03); text-decoration:none; }
    .hh-cta:hover::before { opacity:1; }
    .hh-cta:active { transform:translateY(0) scale(0.98); box-shadow:0 0 10px rgba(255,165,0,0.4); }
    .hh-cta .btn-text, .hh-cta svg { position:relative; z-index:1; }
    .hh-cta svg { transition:transform 0.25s ease; }
    .hh-cta:hover svg { transform:translateX(4px); }

    .hh-stats {
      position:relative; z-index:2;
      display:flex; justify-content:center; gap:3rem; margin-top:4rem; flex-wrap:wrap;
      animation:fadeInUp 0.7s ease 0.6s both;
    }
    .hh-stat { text-align:center; }
    .hh-stat__number {
      font-size:1.8rem; font-weight:800;
      background:linear-gradient(135deg,#ff8c00,#ffb347);
      -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
      line-height:1;
    }
    .hh-stat__label {
      font-size:0.72rem; font-weight:400; color:rgba(255,255,255,0.45);
      letter-spacing:0.07em; text-transform:uppercase; margin-top:0.3rem;
    }
    .hh-scroll {
      position:absolute; bottom:2rem; left:50%; transform:translateX(-50%);
      z-index:2; display:flex; flex-direction:column; align-items:center; gap:0.4rem;
      color:rgba(255,255,255,0.3); font-size:0.65rem; letter-spacing:0.1em; text-transform:uppercase;
      animation:fadeIn 1s ease 1s both;
    }
    .hh-scroll__line {
      width:1px; height:40px;
      background:linear-gradient(180deg,rgba(255,140,0,0.6),transparent);
      animation:scrollLine 1.8s ease-in-out infinite;
    }
    @keyframes scrollLine { 0%,100%{transform:scaleY(1);opacity:1;} 50%{transform:scaleY(0.4);opacity:0.3;} }
    @keyframes fadeInDown { from{opacity:0;transform:translateY(-20px);} to{opacity:1;transform:translateY(0);} }
    @keyframes fadeInUp   { from{opacity:0;transform:translateY(30px);}  to{opacity:1;transform:translateY(0);} }
    @keyframes fadeIn     { from{opacity:0;} to{opacity:1;} }

    /* AUTH MODAL */
    .auth-input { background-color:#1a1a1a; border:1px solid #444; color:white; padding:12px; border-radius:8px; width:100%; }
    .auth-input:focus { background-color:#1a1a1a; border-color:orange; color:white; box-shadow:0 0 0 0.25rem rgba(255,165,0,0.25); outline:none; }
    .auth-btn { background-color:orange; color:black; font-weight:bold; padding:12px; border-radius:8px; border:1px solid orange; transition:0.3s; text-transform:uppercase; letter-spacing:1px; width:100%; }
    .auth-btn:hover { background-color:#e69500; color:black; box-shadow:0 4px 15px rgba(255,165,0,0.4); }
    #authTabs .nav-link.active { background-color:orange !important; color:black !important; }
    #authTabs .nav-link:hover:not(.active) { background-color:rgba(255,165,0,0.2); }
    .form-label { margin-bottom:0.3rem; }


    /* LIGHT THEME OVERRIDES */
    [data-bs-theme="light"] body { background:#fdfdfd; color:#111; }
    [data-bs-theme="light"] .hh-hero__overlay {
      background:radial-gradient(ellipse at center,rgba(255,140,0,0.1) 0%,transparent 70%),
                 linear-gradient(180deg,rgba(255,255,255,0.7) 0%,rgba(255,245,230,0.9) 50%,rgba(255,255,255,0.98) 100%);
    }
    [data-bs-theme="light"] .hh-finder-card {
      background:rgba(255,255,255,0.9);
      box-shadow:0 8px 48px rgba(0,0,0,0.1), 0 0 0 1px rgba(255,140,0,0.3) inset;
    }
    [data-bs-theme="light"] .hh-finder-card__sub { color:rgba(0,0,0,0.7); }
    [data-bs-theme="light"] .hh-select { background:#fff; color:#000; border-color:rgba(255,140,0,0.5); }
    [data-bs-theme="light"] .hh-select option { background:#fff; color:#000; }
    [data-bs-theme="light"] .hh-field label { color:rgba(255,140,0,0.9); }
    [data-bs-theme="light"] .hh-finder-note { color:rgba(0,0,0,0.6); }
    [data-bs-theme="light"] .hh-body { color:rgba(0,0,0,0.8); }
    [data-bs-theme="light"] .hh-stat__label { color:rgba(0,0,0,0.6); }
    [data-bs-theme="light"] .hh-scroll { color:rgba(0,0,0,0.6); }
    [data-bs-theme="light"] .hh-age-row label { color:rgba(0,0,0,0.6) !important; }
    
    [data-bs-theme="light"] .auth-input { background-color:#fff; border:1px solid #ccc; color:#000; }
    [data-bs-theme="light"] .auth-input:focus { background-color:#fff; border-color:orange; color:#000; }
  </style>
</head>
<body>

<!-- NAVBAR -->
<x-navbar :hideSearch="true" />

<!-- HERO SECTION -->
<section class="hh-hero" id="hh-hero">
  <div class="hh-hero__bg"></div>
  <div class="hh-hero__overlay"></div>
  <div class="hh-hearts" aria-hidden="true">
    <span class="hh-heart" style="left:8%;animation-duration:9s;animation-delay:0s;font-size:1rem;">&#128155;</span>
    <span class="hh-heart" style="left:18%;animation-duration:12s;animation-delay:1.5s;font-size:0.8rem;">&#128154;</span>
    <span class="hh-heart" style="left:30%;animation-duration:8s;animation-delay:0.8s;font-size:1.4rem;">&#128155;</span>
    <span class="hh-heart" style="left:45%;animation-duration:11s;animation-delay:2.2s;font-size:0.9rem;">&#128154;</span>
    <span class="hh-heart" style="left:60%;animation-duration:10s;animation-delay:0.4s;font-size:1.1rem;">&#128155;</span>
    <span class="hh-heart" style="left:73%;animation-duration:13s;animation-delay:1s;font-size:0.75rem;">&#128154;</span>
    <span class="hh-heart" style="left:85%;animation-duration:9.5s;animation-delay:3s;font-size:1.3rem;">&#128155;</span>
    <span class="hh-heart" style="left:93%;animation-duration:7.5s;animation-delay:1.8s;font-size:0.85rem;">&#128154;</span>
  </div>
  <div class="hh-hero__inner">

    <!-- LEFT: Text & CTA -->
    <div class="hh-hero__left">
      <h1 class="hh-heading">
        Your Soulmate is<br>
        <span>Waiting for You</span>
      </h1>
      <p class="hh-body">
        Tired of being single? <strong>Baddies-Club</strong> is the answer to your prayers.
        We have a wide variety of members to choose from, so you&rsquo;re sure to find
        someone who is <strong>perfect for you</strong>. Join and start your love life today!
      </p>
      <div class="hh-btn-wrap">
        <button type="button" class="hh-cta" id="hh-get-started-btn"
          data-bs-toggle="modal" data-bs-target="#authModal" data-auth-tab="register">
          <span class="btn-text">Get Started</span>
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 12h14M12 5l7 7-7 7"/>
          </svg>
        </button>
      </div>
      <div class="hh-stats">
        <div class="hh-stat">
          <div class="hh-stat__number">10K+</div>
          <div class="hh-stat__label">Active Members</div>
        </div>
        <div class="hh-stat">
          <div class="hh-stat__number">98%</div>
          <div class="hh-stat__label">Match Rate</div>
        </div>
        <div class="hh-stat">
          <div class="hh-stat__number">24/7</div>
          <div class="hh-stat__label">Online Support</div>
        </div>
      </div>
    </div>

    <!-- RIGHT: Find Match Card -->
    <div class="hh-finder-card" role="complementary" aria-label="Find a Match">
      <div class="hh-finder-card__title">Find Match Now!</div>
      <p class="hh-finder-card__sub">Where Connections Blossom! Your perfect match is just a click away.</p>
      <div class="hh-finder-divider"></div>

      <form id="hh-finder-form" onsubmit="hhFinderSearch(event)">
        <!-- Looking For -->
        <div class="hh-field">
          <label for="hh-looking-for">Looking For</label>
          <select class="hh-select" id="hh-looking-for" name="looking_for">
            <option value="all">All</option>
            <option value="female">Female</option>
            <option value="male">Male</option>
            <option value="secret">Secret</option>
          </select>
        </div>

        <!-- Age Range -->
        <div class="hh-field">
          <label>Age Range</label>
          <div class="hh-age-row">
            <div>
              <label for="hh-age-from" style="font-size:0.68rem;color:rgba(255,255,255,0.4);text-transform:none;letter-spacing:0;margin-bottom:0.3rem;">From</label>
              <select class="hh-select" id="hh-age-from" name="age_from">
                @for($a = 18; $a <= 65; $a++)
                  <option value="{{ $a }}" {{ $a === 18 ? 'selected' : '' }}>{{ $a }}</option>
                @endfor
              </select>
            </div>
            <div>
              <label for="hh-age-to" style="font-size:0.68rem;color:rgba(255,255,255,0.4);text-transform:none;letter-spacing:0;margin-bottom:0.3rem;">To</label>
              <select class="hh-select" id="hh-age-to" name="age_to">
                @for($a = 18; $a <= 65; $a++)
                  <option value="{{ $a }}" {{ $a === 50 ? 'selected' : '' }}>{{ $a }}</option>
                @endfor
              </select>
            </div>
          </div>
        </div>

        <!-- Search Button -->
        <button type="submit" class="hh-search-btn" id="hh-search-btn">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
          </svg>
          Search Matches
        </button>
      </form>

      <p class="hh-finder-note"><span>100% Private &amp; Secure</span> &mdash; No credit card required</p>
    </div>

  </div>
  <div class="hh-scroll" aria-hidden="true">
    <div class="hh-scroll__line"></div>
    <span>Scroll</span>
  </div>
</section>

<!-- AUTH MODAL -->
<div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true" style="backdrop-filter:blur(5px);">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background-color:#000;border:1px solid #333;border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,0.5);">
      <div class="modal-header border-bottom-0 pb-0 mt-2 mx-2">
        <div class="w-100 d-flex justify-content-between align-items-center">
          <h5 class="modal-title fw-bold fs-3" id="authModalLabel" style="color:orange;text-transform:uppercase;letter-spacing:1px;">Kenyan Baddies Club</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
      </div>
      <div class="modal-body pt-0 px-4 pb-4">
        <ul class="nav nav-pills nav-justified mb-4 mt-4" id="authTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active rounded-pill fw-bold" id="tab-login"
              data-bs-toggle="pill" data-bs-target="#content-login"
              type="button" role="tab" style="color:white;border:1px solid orange;">Login</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link rounded-pill fw-bold ms-2" id="tab-register"
              data-bs-toggle="pill" data-bs-target="#content-register"
              type="button" role="tab" style="color:white;border:1px solid orange;">Sign Up</button>
          </li>
        </ul>

        <div class="tab-content" id="authTabsContent">

          <!-- LOGIN TAB -->
          <div class="tab-pane fade show active" id="content-login" role="tabpanel">
            <div class="text-center mb-4">
              <h4 class="text-light fw-bold">Member Log In</h4>
              <p class="text-secondary small fw-bold">Access your Baddies Club account</p>
            </div>
            <!-- Step 1 -->
            <div id="login-step-1">
              <a href="#" class="btn btn-outline-light w-100 mb-3 d-flex align-items-center justify-content-center" style="border-radius:8px;border-color:orange;">
                <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z"/>
                </svg>
                Log in with Google SSO
              </a>
              <div class="d-flex align-items-center mb-3">
                <hr class="flex-grow-1" style="border-color:#444;">
                <span class="mx-3 text-secondary small">Or</span>
                <hr class="flex-grow-1" style="border-color:#444;">
              </div>
              <button type="button" class="btn btn-outline-light w-100 mb-4 fw-bold" style="border-radius:8px;border-color:orange;"
                onclick="document.getElementById('login-step-1').classList.add('d-none');document.getElementById('login-step-2').classList.remove('d-none');">
                Log in with email and password
              </button>
              <div class="text-center mb-3">
                <a href="#" class="text-decoration-none small fw-bold" style="color:orange;"
                  onclick="document.getElementById('tab-register').click();return false;">
                  Don&rsquo;t have an account yet? Sign Up here
                </a>
              </div>
            </div>
            <!-- Step 2 -->
            <div id="login-step-2" class="d-none">
              <button type="button" class="btn btn-link text-secondary p-0 mb-3 text-decoration-none d-flex align-items-center"
                onclick="document.getElementById('login-step-2').classList.add('d-none');document.getElementById('login-step-1').classList.remove('d-none');">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                </svg>
                Back
              </button>
              <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                  <label for="login-email" class="form-label text-light small fw-bold">Email Address</label>
                  <input type="email" class="form-control auth-input" id="login-email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                  <label for="login-password" class="form-label text-light small fw-bold">Password</label>
                  <input type="password" class="form-control auth-input" id="login-password" name="password" required>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="hh-remember-me" style="border-color:orange;accent-color:orange;cursor:pointer;">
                    <label class="form-check-label text-light small user-select-none" for="hh-remember-me" style="cursor:pointer;">Remember me</label>
                  </div>
                  @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-decoration-none small" style="color:orange;">Forgot Password?</a>
                  @endif
                </div>
                <button type="submit" class="auth-btn">Login</button>
              </form>
            </div>
          </div>

          <!-- REGISTER TAB -->
          <div class="tab-pane fade" id="content-register" role="tabpanel">
            <div class="text-center mb-4">
              <h4 class="text-light fw-bold">Sign Up for Free</h4>
            </div>
            <!-- Step 1 -->
            <div id="register-step-1">
              <a href="#" class="btn btn-outline-light w-100 mb-3 d-flex align-items-center justify-content-center" style="border-radius:8px;border-color:orange;">
                <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z"/>
                </svg>
                Sign up with Google SSO
              </a>
              <div class="d-flex align-items-center mb-3">
                <hr class="flex-grow-1" style="border-color:#444;">
                <span class="mx-3 text-secondary small">or</span>
                <hr class="flex-grow-1" style="border-color:#444;">
              </div>
              <button type="button" class="btn btn-outline-light w-100 mb-4 fw-bold" style="border-radius:8px;border-color:orange;"
                onclick="document.getElementById('register-step-1').classList.add('d-none');document.getElementById('register-step-2').classList.remove('d-none');">
                Sign up with email and password
              </button>
              <div class="text-center mb-3">
                <a href="#" class="text-decoration-none small fw-bold" style="color:orange;"
                  onclick="document.getElementById('tab-login').click();return false;">
                  Already have an account? Login here
                </a>
              </div>
              <div class="text-center mt-4">
                <p class="text-secondary mb-0" style="font-size:0.70rem;line-height:1.4;">
                  By signing up, you agree to the Terms and Conditions and Privacy Notice, including Cookie Use.
                </p>
              </div>
            </div>
            <!-- Step 2 -->
            <div id="register-step-2" class="d-none">
              <button type="button" class="btn btn-link text-secondary p-0 mb-3 text-decoration-none d-flex align-items-center"
                onclick="document.getElementById('register-step-2').classList.add('d-none');document.getElementById('register-step-1').classList.remove('d-none');">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                </svg>
                Back
              </button>
              <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                  <label for="reg-name" class="form-label text-light small fw-bold">Full Name</label>
                  <input type="text" class="form-control auth-input" id="reg-name" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="mb-3">
                  <label for="reg-email" class="form-label text-light small fw-bold">Email Address</label>
                  <input type="email" class="form-control auth-input" id="reg-email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                  <label for="reg-password" class="form-label text-light small fw-bold">Password</label>
                  <input type="password" class="form-control auth-input" id="reg-password" name="password" required>
                </div>
                <div class="mb-4">
                  <label for="reg-password-confirm" class="form-label text-light small fw-bold">Confirm Password</label>
                  <input type="password" class="form-control auth-input" id="reg-password-confirm" name="password_confirmation" required>
                </div>
                @if($errors->any() && old('name'))
                  <div class="alert alert-danger p-2 mb-3" style="background-color:rgba(220,53,69,0.1);border-left:4px solid #dc3545;color:#ff8a93;border-radius:4px;">
                    <ul class="mb-0 ps-3">
                      @foreach($errors->all() as $error)
                        <li><small>{{ $error }}</small></li>
                      @endforeach
                    </ul>
                  </div>
                @endif
                <button type="submit" class="auth-btn mb-3">Create Account</button>
              </form>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<x-footer />

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Open correct tab based on data-auth-tab attribute
  document.addEventListener('DOMContentLoaded', function () {
    var authModalEl = document.getElementById('authModal');
    if (!authModalEl) return;

    authModalEl.addEventListener('show.bs.modal', function (event) {
      var btn = event.relatedTarget;
      var tab = btn ? btn.getAttribute('data-auth-tab') : null;

      if (tab === 'register') {
        var el = document.getElementById('tab-register');
        if (el) new bootstrap.Tab(el).show();
      } else {
        var el = document.getElementById('tab-login');
        if (el) new bootstrap.Tab(el).show();
      }

      // Reset step views on open
      ['login-step-1','login-step-2','register-step-1','register-step-2'].forEach(function(id){
        var el = document.getElementById(id);
        if (!el) return;
        if (id === 'login-step-1' || id === 'register-step-1') {
          el.classList.remove('d-none');
        } else {
          el.classList.add('d-none');
        }
      });
    });

    // Show errors: re-open on validation failure
    @if($errors->any())
      var modal = new bootstrap.Modal(authModalEl);
      modal.show();
      @if(old('name') || $errors->has('name'))
        var regTab = document.getElementById('tab-register');
        if (regTab) new bootstrap.Tab(regTab).show();
        var s1 = document.getElementById('register-step-1');
        var s2 = document.getElementById('register-step-2');
        if (s1) s1.classList.add('d-none');
        if (s2) s2.classList.remove('d-none');
      @else
        var s1 = document.getElementById('login-step-1');
        var s2 = document.getElementById('login-step-2');
        if (s1) s1.classList.add('d-none');
        if (s2) s2.classList.remove('d-none');
      @endif
    @endif
  });

  // Finder form: age validation + open register modal
  function hhFinderSearch(e) {
    e.preventDefault();
    var ageFrom = parseInt(document.getElementById('hh-age-from').value, 10);
    var ageTo   = parseInt(document.getElementById('hh-age-to').value,   10);
    if (ageTo < ageFrom) {
      // swap silently
      document.getElementById('hh-age-to').value = ageFrom;
      document.getElementById('hh-age-from').value = ageTo;
    }
    // Prompt user to register/login then search
    var modalEl = document.getElementById('authModal');
    if (modalEl) {
      var regTab = document.getElementById('tab-register');
      var modal  = new bootstrap.Modal(modalEl);
      modal.show();
      if (regTab) setTimeout(function(){ new bootstrap.Tab(regTab).show(); }, 150);
    }
  }
</script>

<!-- -- AUTH MODAL -- -->
<x-auth-modal />
</body>
</html>

