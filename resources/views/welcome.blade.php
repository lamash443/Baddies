<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <x-site-favicon />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <script>
    if (window.location.hash === '#vip-escorts') {
      window.location.replace("{{ route('escort-girls') }}");
    }
  </script>
  <title>Kenyan Baddies Club – VIP Escorts & Call Girls in Nairobi</title>
  <meta name="description" content="Browse VIP escorts, call girls and hookups in Nairobi and across Kenya. Join Kenyan Baddies Club – discreet, trusted and always online.">
  <meta name="robots" content="index,follow">
  <meta property="og:type" content="website">
  <meta property="og:title" content="Kenyan Baddies Club – VIP Escorts & Call Girls in Kenya">
  <meta property="og:description" content="Browse VIP escorts, call girls and hookups in Nairobi and across Kenya.">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/css/listing-card.css">

  <style>
    *, *::before, *::after { box-sizing: border-box; }
    html, body {
      margin: 0; padding: 0;
      font-family: "Outfit", sans-serif;
      background: #000000;
      color: #fff;
      min-height: 100vh;
      overflow-x: hidden !important;
      max-width: 100vw;
    }

    /* ── HERO ── */
    .home-hero {
      position: relative;
      min-height: 92vh;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      padding: 7rem 1.5rem 5rem;
    }
    @media (max-width: 767.98px) {
      .home-hero {
        min-height: auto;
        padding: 2.5rem 1.25rem 3rem;
      }
    }
    .home-hero__bg {
      position: absolute; inset: 0;
      background: linear-gradient(160deg, #000000 0%, #1a0f00 40%, #000000 100%);
      z-index: 0;
    }
    .home-hero__particles {
      position: absolute; inset: 0; z-index: 1; pointer-events: none; overflow: hidden;
    }
    .hh-heart {
      position: absolute; opacity: 0;
      animation: floatHeart linear infinite;
      filter: drop-shadow(0 0 6px rgba(255,140,0,0.6));
    }
    @keyframes floatHeart {
      0%   { transform: translateY(100vh) scale(0.5) rotate(-15deg); opacity: 0; }
      10%  { opacity: 0.7; }
      90%  { opacity: 0.4; }
      100% { transform: translateY(-10vh) scale(1.2) rotate(15deg); opacity: 0; }
    }
    .home-hero__inner {
      position: relative; z-index: 2;
      max-width: 860px; margin: 0 auto; text-align: center;
    }
    .home-hero__eyebrow {
      display: inline-flex; align-items: center; gap: .5rem;
      background: rgba(255,140,0,0.1);
      border: 1px solid rgba(255,140,0,0.3);
      border-radius: 999px;
      padding: .35rem 1rem;
      font-size: .8rem; font-weight: 700; letter-spacing: .08em;
      color: rgba(255,140,0,0.9);
      text-transform: uppercase; margin-bottom: 1.5rem;
    }
    .home-hero__title {
      font-size: clamp(2.2rem, 6vw, 4.2rem);
      font-weight: 900; line-height: 1.08;
      margin-bottom: 1.25rem;
    }
    .home-hero__title span { color: #ff8c00; }
    .home-hero__sub {
      font-size: 1.1rem; color: rgba(255,255,255,0.65);
      max-width: 620px; margin: 0 auto 2.5rem;
      line-height: 1.7;
    }
    .home-hero__cta-group {
      display: flex; flex-wrap: wrap; gap: 1rem;
      justify-content: center;
    }
    .btn-orange {
      background: #ff8c00; border: 2px solid #ff8c00;
      color: #000; font-weight: 700; font-size: 1rem;
      padding: .7rem 2rem; border-radius: .5rem;
      transition: all .3s ease; letter-spacing: .02em;
      text-decoration: none !important;
    }
    .btn-orange:hover {
      background-color: #000000 !important;
      border-color: #ff8c00 !important;
      color: #ffffff !important;
      box-shadow: 0 4px 15px rgba(255, 140, 0, 0.4) !important;
      transform: translateY(-1px);
    }
    .btn-outline-orange {
      background: transparent; border: 2px solid rgba(255,140,0,0.5);
      color: rgba(255,140,0,0.85); font-weight: 600;
      padding: .7rem 2rem; border-radius: .5rem;
      transition: all .3s ease;
      text-decoration: none !important;
    }
    .btn-outline-orange:hover {
      background-color: #000000 !important;
      border-color: #ff8c00 !important;
      color: #ffffff !important;
      box-shadow: 0 4px 15px rgba(255, 140, 0, 0.4) !important;
      transform: translateY(-1px);
    }

    /* ── SECTION LAYOUT ── */
    .home-section { padding: 4rem 0; }
    .home-section-header {
      display: flex; align-items: flex-end;
      justify-content: space-between; flex-wrap: wrap;
      gap: 1rem; margin-bottom: 2rem;
    }
    .home-section-title {
      font-size: 1.6rem; font-weight: 800; color: #fff;
      margin: 0;
    }
    .home-section-title span { color: #ff8c00; }
    .home-section-sub {
      color: rgba(255,255,255,0.5); font-size: .9rem; margin-top: .3rem;
    }
    .home-section-line {
      width: 48px; height: 3px;
      background: linear-gradient(90deg, #ff8c00, transparent);
      border-radius: 2px; margin-top: .5rem;
    }

    /* ── LISTING GRID ── */
    .home-listing-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 1.25rem;
    }

    /* ── CATEGORY CARDS ── */
    .cat-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
      gap: 1rem;
    }
    @media (min-width: 768px) {
      .cat-grid {
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
      }
    }
    .cat-card {
      background: linear-gradient(145deg, #1a1200, #111);
      border: 1px solid rgba(255,140,0,0.3);
      border-radius: 1rem;
      padding: 1.75rem 1rem;
      text-align: center;
      text-decoration: none;
      color: #fff;
      transition: all .3s ease;
      display: block;
    }
    .cat-card:hover {
      border-color: rgba(255,140,0,0.8);
      box-shadow: 0 0 20px rgba(255,140,0,0.35);
      color: #ff8c00;
      transform: translateY(-3px);
    }
    .cat-card__icon {
      font-size: 2.4rem; margin-bottom: .75rem; display: block;
    }
    .cat-card__name {
      font-weight: 700; font-size: .95rem;
    }
    .cat-card__count {
      font-size: .78rem; color: rgba(255,140,0,0.7); margin-top: .25rem;
    }

    /* ── HOW IT WORKS ── */
    .hiw-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 1.5rem;
    }
    .hiw-card {
      background: linear-gradient(145deg, #1a1200, #0d0d0d);
      border: 1px solid rgba(255,140,0,0.25);
      border-radius: 1rem;
      padding: 2rem 1.5rem;
      position: relative;
    }
    .hiw-card__num {
      position: absolute; top: 1rem; right: 1.25rem;
      font-size: 3.5rem; font-weight: 900;
      color: rgba(255,140,0,0.08); line-height: 1;
    }
    .hiw-card__icon {
      width: 48px; height: 48px;
      background: rgba(255,140,0,0.12);
      border: 1px solid rgba(255,140,0,0.25);
      border-radius: .75rem;
      display: flex; align-items: center; justify-content: center;
      margin-bottom: 1rem;
      color: #ff8c00;
    }
    .hiw-card__title {
      font-weight: 700; font-size: 1.05rem; color: #fff; margin-bottom: .5rem;
    }
    .hiw-card__body {
      font-size: .88rem; color: rgba(255,255,255,0.55); line-height: 1.65;
    }

    /* ── JOIN BANNER ── */
    .join-banner {
      background: linear-gradient(135deg, #1a0f00 0%, #0d0d0d 50%, #1a0f00 100%);
      border: 1px solid rgba(255,140,0,0.3);
      border-radius: 1.5rem;
      padding: 4rem 2rem;
      text-align: center;
      position: relative;
      overflow: hidden;
    }
    .join-banner::before {
      content: '';
      position: absolute; inset: 0;
      background: radial-gradient(ellipse at 50% -20%, rgba(255,140,0,0.12) 0%, transparent 70%);
    }
    .join-banner__title {
      font-size: clamp(1.8rem, 4vw, 2.6rem);
      font-weight: 900; color: #fff; margin-bottom: 1rem;
      position: relative;
    }
    .join-banner__title span { color: #ff8c00; }
    .join-banner__body {
      color: rgba(255,255,255,0.6); max-width: 520px; margin: 0 auto 2rem;
      font-size: 1rem; line-height: 1.7; position: relative;
    }

    /* ── LIGHT THEME OVERRIDES ── */
    [data-bs-theme="light"] body { background: #f4f6f9; color: #111; }
    [data-bs-theme="light"] .home-hero__bg { background: linear-gradient(160deg, #f4f6f9 0%, #fff4e6 40%, #f4f6f9 100%); }
    [data-bs-theme="light"] .home-hero__title { color: #111; }
    [data-bs-theme="light"] .home-hero__sub { color: rgba(0,0,0,0.65); }
    [data-bs-theme="light"] .home-section-title { color: #111; }
    [data-bs-theme="light"] .home-section-sub { color: rgba(0,0,0,0.6); }
    
    [data-bs-theme="light"] .cat-card { background: linear-gradient(145deg, #ffffff, #fdfdfd); border-color: rgba(255,140,0,0.25); color: #111; box-shadow: 0 4px 15px rgba(0,0,0,0.04); }
    [data-bs-theme="light"] .cat-card:hover { border-color: rgba(255,140,0,0.6); box-shadow: 0 8px 25px rgba(255,140,0,0.15); color: #ff8c00; }
    
    [data-bs-theme="light"] .hiw-card { background: #ffffff; border-color: rgba(255,140,0,0.25); box-shadow: 0 4px 15px rgba(0,0,0,0.04); }
    [data-bs-theme="light"] .hiw-card__num { color: rgba(255,140,0,0.15); }
    [data-bs-theme="light"] .hiw-card__title { color: #111; }
    [data-bs-theme="light"] .hiw-card__body { color: rgba(0,0,0,0.65); }
    
    [data-bs-theme="light"] .join-banner { background: linear-gradient(135deg, #fff9f0 0%, #ffffff 50%, #fff9f0 100%); border-color: rgba(255,140,0,0.3); box-shadow: 0 10px 30px rgba(255,140,0,0.08); }
    [data-bs-theme="light"] .join-banner__title { color: #111; }
    [data-bs-theme="light"] .join-banner__body { color: rgba(0,0,0,0.65); }

    [data-bs-theme="light"] .loc-tag { background: #ffffff; border-color: rgba(255,140,0,0.5); color: #111; }
    [data-bs-theme="light"] .loc-tag:hover { background: #ff8c00; border-color: #ff8c00; color: #ffffff; box-shadow: 0 4px 12px rgba(255,140,0,0.3); }
    [data-bs-theme="light"] .loc-section-card { background: #ffffff; border-color: rgba(0,0,0,0.08); box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
    [data-bs-theme="light"] #locAccordion .accordion-item { background: #ffffff; border-color: rgba(255,140,0,0.25); }
    [data-bs-theme="light"] #locAccordion .accordion-body { background: #fafafa; }
    
    [data-bs-theme="light"] .baddies-editorial { background: #ffffff; border-color: rgba(255,140,0,0.25); box-shadow: 0 8px 30px rgba(0,0,0,0.04); }
    [data-bs-theme="light"] .baddies-editorial h2.ed-heading { color: #111; }
    [data-bs-theme="light"] .baddies-editorial p.ed-body, 
    [data-bs-theme="light"] .baddies-editorial ul.ed-list li { color: rgba(0,0,0,0.7); }
    
    [data-bs-theme="light"] .del-toast { background: #ffffff; border-color: rgba(220,53,69,0.3); box-shadow: 0 10px 40px rgba(0,0,0,0.08); }
    [data-bs-theme="light"] .del-toast__title { color: #dc3545; }
    [data-bs-theme="light"] .del-toast__msg { color: rgba(0,0,0,0.7); }
    [data-bs-theme="light"] .del-toast__close { background: rgba(0,0,0,0.04); border-color: rgba(0,0,0,0.08); color: rgba(0,0,0,0.5); }
    [data-bs-theme="light"] .del-toast__close:hover { background: rgba(220,53,69,0.1); color: #dc3545; border-color: rgba(220,53,69,0.2); }
    [data-bs-theme="light"] .home-hero__bg-img,
    [data-bs-theme="light"] .home-hero__overlay {
      display: none !important;
    }
  </style>
</head>
<body>
<x-site-preloader />

<x-navbar />

<!-- Floating hearts -->
<div class="home-hero__particles" aria-hidden="true">
  <span class="hh-heart" style="left:5%;animation-duration:9s;animation-delay:0s;font-size:1rem;">&#128155;</span>
  <span class="hh-heart" style="left:15%;animation-duration:12s;animation-delay:1.5s;font-size:0.8rem;">&#128154;</span>
  <span class="hh-heart" style="left:28%;animation-duration:8s;animation-delay:0.8s;font-size:1.4rem;">&#128155;</span>
  <span class="hh-heart" style="left:45%;animation-duration:11s;animation-delay:2.2s;font-size:0.9rem;">&#128154;</span>
  <span class="hh-heart" style="left:62%;animation-duration:10s;animation-delay:0.4s;font-size:1.1rem;">&#128155;</span>
  <span class="hh-heart" style="left:75%;animation-duration:13s;animation-delay:1s;font-size:0.75rem;">&#128154;</span>
  <span class="hh-heart" style="left:88%;animation-duration:9.5s;animation-delay:3s;font-size:1.3rem;">&#128155;</span>
</div>

<!-- ══ HERO ══ -->
<section class="home-hero">
  <div class="home-hero__bg">
    <img src="{{ !empty($siteSettings['hero_background']) ? asset('storage/' . $siteSettings['hero_background']) : asset('images/header-image.jpg') }}" alt="" aria-hidden="true" class="home-hero__bg-img"
         style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:center; z-index:0; pointer-events:none; display:block;">
    <div class="home-hero__overlay" style="position:absolute; inset:0; background:linear-gradient(160deg, rgba(0,0,0,0.5) 0%, rgba(26,15,0,0.6) 40%, rgba(0,0,0,0.5) 100%); z-index:1;"></div>
  </div>
  <div class="home-hero__inner">

    <h1 class="home-hero__title">
      {!! $siteSettings['hero_title'] ?? 'Meet Beautiful <span>Kenyan Baddies</span><br>Near You Tonight' !!}
    </h1>
    <p class="home-hero__sub">
      {{ $siteSettings['hero_subtitle'] ?? 'Browse verified VIP escorts, call girls, and adult classifieds across Nairobi and all of Kenya. Discreet, safe, and always online.' }}
    </p>
    <div class="home-hero__cta-group">
      <a href="{{ route('escort-girls') }}" class="btn-orange">Browse VIP Escorts</a>
      @guest
      <a href="#" class="btn-outline-orange" data-bs-toggle="modal" data-bs-target="#authModal" data-auth-tab="register">Join Free</a>
      @endguest
      @auth
      <a href="{{ route('profile.edit') }}" class="btn-outline-orange">My Profile</a>
      @endauth
    </div>
  </div>
</section>

<!-- ══ CATEGORIES ══ -->
<section class="home-section">
  <div class="container">
    <div class="home-section-header">
      <div>
        <h2 class="home-section-title">Explore <span>Categories</span></h2>
        <p class="home-section-sub">Find exactly what you're looking for</p>
        <div class="home-section-line"></div>
      </div>
    </div>
    <div class="cat-grid">
      <a href="{{ route('escort-girls') }}" class="cat-card">
        <div class="cat-card__name">Escort Girls</div>
        <div class="cat-card__count">VIP & Featured</div>
      </a>
      <a href="/category/call-boys" class="cat-card">
        <div class="cat-card__name">Call Boys</div>
        <div class="cat-card__count">Verified Males</div>
      </a>
      <a href="/classifieds" class="cat-card">
        <div class="cat-card__name">Adult Classifieds</div>
        <div class="cat-card__count">Personals & Ads</div>
      </a>
      <a href="/videos" class="cat-card">
        <div class="cat-card__name">Videos</div>
        <div class="cat-card__count">Adult Content</div>
      </a>
    </div>
  </div>
</section>

<!-- ══ BROWSE BY COUNTY / LOCATION ══ -->
<section id="locations" class="home-section" style="padding-top:0;">
  <div class="container">
    <div class="home-section-header">
      <div>
        <h2 class="home-section-title">Browse By <span>Location</span></h2>
        <p class="home-section-sub">Find escorts and call girls near you across Kenya</p>
        <div class="home-section-line"></div>
      </div>
    </div>

    <style>
      .loc-tag {
        display: inline-block;
        padding: .35rem .75rem;
        font-size: .78rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.85);
        background: #000000;
        border: 1px solid #ff8c00;
        border-radius: .4rem;
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.3s ease;
        letter-spacing: .02em;
      }
      .loc-tag:hover {
        background-color: #000000;
        border-color: #ff8c00;
        color: #ffffff;
        box-shadow: 0 0 12px rgba(255, 140, 0, 0.6);
        transform: translateY(-1px);
      }
      .loc-section-card {
        background: #0d0d0d;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 6px;
        padding: 1rem 1.25rem;
        margin-bottom: .75rem;
      }
      .loc-section-title {
        font-size: .78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #ff8c00;
        margin-bottom: .65rem;
        display: flex;
        align-items: center;
        gap: .5rem;
      }
      .loc-section-title::after {
        content: '';
        flex: 1;
        height: 1px;
        background: rgba(255,140,0,0.2);
      }
      .loc-tags-wrap {
        display: flex;
        flex-wrap: wrap;
        gap: .3rem;
      }
      /* Accordion override for orange theme */
      #locAccordion .accordion-button {
        background: rgba(255,140,0,0.1);
        color: #ff8c00;
        font-weight: 700;
        font-size: .95rem;
        border: 1px solid rgba(255,140,0,0.35);
        border-radius: 6px !important;
      }
      #locAccordion .accordion-button:not(.collapsed) {
        background: rgba(255,140,0,0.15);
        color: #ff8c00;
        box-shadow: none;
        border-bottom-left-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
      }
      #locAccordion .accordion-button::after {
        filter: invert(60%) sepia(80%) saturate(400%) hue-rotate(5deg);
      }
      #locAccordion .accordion-button:focus {
        box-shadow: 0 0 0 0.2rem rgba(255,140,0,0.25);
      }
      #locAccordion .accordion-item {
        background: transparent;
        border: 1px solid rgba(255,140,0,0.25);
        border-radius: 6px;
        overflow: hidden;
      }
      #locAccordion .accordion-body {
        background: rgba(10,8,0,0.6);
        padding: 1.25rem;
      }
    </style>

    <div class="accordion" id="locAccordion">
      <div class="accordion-item">
        <h2 class="accordion-header" id="locHeading">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#locCollapse" aria-expanded="true" aria-controls="locCollapse">
            Kenya Locations — Roads, Nairobi Areas & All Counties
          </button>
        </h2>
        <div id="locCollapse" class="accordion-collapse collapse show" aria-labelledby="locHeading">
          <div class="accordion-body">

            @php
              $predefinedRoads = \App\Models\Location::where('is_active', true)->where('type', 'road')->pluck('name')->toArray();
              
              $predefinedAreas = \App\Models\Location::where('is_active', true)->where('type', 'area')->pluck('name')->toArray();
              
              $predefinedCounties = \App\Models\Location::where('is_active', true)->where('type', 'county')->pluck('name')->toArray();

              // Retrieve distinct custom locations and counties from database
              $dbCounties = \App\Models\User::where('is_verified', true)
                  ->whereNotNull('county')
                  ->where('county', '!=', '')
                  ->distinct()
                  ->pluck('county')
                  ->toArray();

              $dbLocations = \App\Models\User::where('is_verified', true)
                  ->whereNotNull('location')
                  ->where('location', '!=', '')
                  ->distinct()
                  ->pluck('location')
                  ->toArray();

              // Merge lists case-insensitively to prevent duplicates
              $mergedCounties = $predefinedCounties;
              foreach ($dbCounties as $dbCounty) {
                  $exists = false;
                  foreach ($mergedCounties as $county) {
                      if (strcasecmp($dbCounty, $county) === 0) {
                          $exists = true;
                          break;
                      }
                  }
                  if (!$exists) {
                      $mergedCounties[] = $dbCounty;
                  }
              }

              $mergedAreas = $predefinedAreas;
              $mergedRoads = $predefinedRoads;
              foreach ($dbLocations as $dbLocation) {
                  $exists = false;
                  foreach (array_merge($mergedRoads, $mergedAreas) as $loc) {
                      if (strcasecmp($dbLocation, $loc) === 0) {
                          $exists = true;
                          break;
                      }
                  }
                  if (!$exists) {
                      $mergedAreas[] = $dbLocation;
                  }
              }
            @endphp

            {{-- Nairobi Major Roads --}}
            <div class="loc-section-card">
              <div class="loc-section-title">Major Roads in Nairobi — Where to Find Escorts & Call Girls</div>
              <div class="loc-tags-wrap">
                @foreach($mergedRoads as $road)
                  <a href="{{ route('location.show', ['name' => $road]) }}" class="loc-tag">{{ $road }}</a>
                @endforeach
              </div>
            </div>

            {{-- Nairobi County Areas --}}
            <div class="loc-section-card">
              <div class="loc-section-title">Escorts Near You — Nairobi County</div>
              <div class="loc-tags-wrap">
                @foreach($mergedAreas as $area)
                  <a href="{{ route('location.show', ['name' => $area]) }}" class="loc-tag">{{ $area }}</a>
                @endforeach
              </div>
            </div>

            {{-- Other Counties --}}
            <div class="loc-section-card mb-0">
              <div class="loc-section-title">Other Counties</div>
              <div class="loc-tags-wrap">
                @foreach($mergedCounties as $county)
                  <a href="{{ route('location.show', ['name' => $county]) }}" class="loc-tag">{{ $county }}</a>
                @endforeach
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- ══ VIP CALL GIRLS ══ -->
<section id="vip-escorts" class="home-section" style="padding-top:0;">
  <div class="container">
    <div class="home-section-header">
      <div>
        <h2 class="home-section-title">
          <span>VIP</span> Call Girls
        </h2>
        <p class="home-section-sub">Premium verified escorts on our VIP package</p>
        <div class="home-section-line"></div>
      </div>
    </div>
    <div class="home-listing-grid">
      @forelse($vipGirls as $user)
        @include('partials.user-card', ['user' => $user])
      @empty
        <div class="col-12 text-center py-4" style="color:rgba(255,255,255,0.35); font-size:.9rem;">
          No VIP girls listed yet. <a href="#" data-bs-toggle="modal" data-bs-target="#authModal" data-auth-tab="register" style="color:#ff8c00;">Subscribe to VIP</a> to appear here.
        </div>
      @endforelse
    </div>
  </div>
</section>

<!-- ══ PRIME VIP CALL GIRLS ══ -->
<section id="prime-vip-escorts" class="home-section" style="padding-top:0;">
  <div class="container">
    <div class="home-section-header">
      <div>
        <h2 class="home-section-title">
          <span>Prime VIP</span> Call Girls
        </h2>
        <p class="home-section-sub">Our most exclusive and top-tier verified providers</p>
        <div class="home-section-line"></div>
      </div>
    </div>
    <div class="home-listing-grid">
      @forelse($primeVipGirls as $user)
        @include('partials.user-card', ['user' => $user])
      @empty
        <div class="col-12 text-center py-4" style="color:rgba(255,255,255,0.35); font-size:.9rem;">
          No Prime VIP girls listed yet. <a href="#" data-bs-toggle="modal" data-bs-target="#authModal" data-auth-tab="register" style="color:#ff8c00;">Subscribe to Prime VIP</a> to appear here.
        </div>
      @endforelse
    </div>
  </div>
</section>

<!-- ══ PRIME CALL GIRLS ══ -->
<section id="prime-escorts" class="home-section" style="padding-top:0;">
  <div class="container">
    <div class="home-section-header">
      <div>
        <h2 class="home-section-title">
          <span>Prime</span> Call Girls
        </h2>
        <p class="home-section-sub">Verified escorts on our Prime subscription package</p>
        <div class="home-section-line"></div>
      </div>
    </div>
    <div class="home-listing-grid">
      @forelse($primeGirls as $user)
        @include('partials.user-card', ['user' => $user])
      @empty
        <div class="col-12 text-center py-4" style="color:rgba(255,255,255,0.35); font-size:.9rem;">
          No Prime girls listed yet. <a href="#" data-bs-toggle="modal" data-bs-target="#authModal" data-auth-tab="register" style="color:#ff8c00;">Subscribe to Prime</a> to appear here.
        </div>
      @endforelse
    </div>
  </div>
</section>

<!-- ══ REGULAR CALL GIRLS ══ -->
<section id="regular-escorts" class="home-section" style="padding-top:0;">
  <div class="container">
    <div class="home-section-header">
      <div>
        <h2 class="home-section-title">
          <span>Call</span> Girls
        </h2>
        <p class="home-section-sub">{{ \App\Models\SiteSetting::get('call_girls_subtitle', 'Verified escorts and call girls across Kenya') }}</p>
        <div class="home-section-line"></div>
      </div>
    </div>
    <div class="home-listing-grid">
      @forelse($regularGirls as $user)
        @include('partials.user-card', ['user' => $user])
      @empty
        <div class="col-12 text-center py-4" style="color:rgba(255,255,255,0.35); font-size:.9rem;">
          No profiles listed yet. <a href="#" data-bs-toggle="modal" data-bs-target="#authModal" data-auth-tab="register" style="color:#ff8c00;">Create a free account</a> to get listed.
        </div>
      @endforelse
    </div>
  </div>
</section>

<!-- ══ CLASSIFIEDS ══ -->
<section id="classifieds" class="home-section" style="padding-top:0;">
  <div class="container">
    <div class="home-section-header">
      <div>
        <h2 class="home-section-title"><span>Adult</span> Classifieds</h2>
        <p class="home-section-sub">{{ \App\Models\SiteSetting::get('classifieds_subtitle', 'Personals, jobs, and adult services') }}</p>
        <div class="home-section-line"></div>
      </div>
      <a href="/classifieds" class="btn-outline-orange" style="font-size:.85rem; padding:.5rem 1.25rem;">View All</a>
    </div>
    <div class="cat-grid">
      <a href="/classifieds?category=personals" class="cat-card py-4">
        <div class="cat-card__name">Personals</div>
        <div class="cat-card__count">Seeking Arrangements</div>
      </a>
      <a href="/classifieds?category=massage" class="cat-card py-4">
        <div class="cat-card__name">Massage</div>
        <div class="cat-card__count">Erotic & Sensual</div>
      </a>
      <a href="/classifieds?category=jobs" class="cat-card py-4">
        <div class="cat-card__name">Jobs</div>
        <div class="cat-card__count">Adult Industry Jobs</div>
      </a>
      <a href="/classifieds?category=events" class="cat-card py-4">
        <div class="cat-card__name">Events</div>
        <div class="cat-card__count">Private Parties</div>
      </a>
    </div>
  </div>
</section>

<!-- ══ HOW IT WORKS ══ -->
<section class="home-section">
  <div class="container">
    <div class="home-section-header">
      <div>
        <h2 class="home-section-title">How It <span>Works</span></h2>
        <p class="home-section-sub">{{ \App\Models\SiteSetting::get('hiw_subtitle', 'Find your perfect match in 3 simple steps') }}</p>
        <div class="home-section-line"></div>
      </div>
    </div>
    <div class="hiw-grid">
      <div class="hiw-card">
        <div class="hiw-card__num">1</div>
        <div class="hiw-card__icon">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </div>
        <div class="hiw-card__title">{{ \App\Models\SiteSetting::get('hiw_step1_title', 'Browse Profiles') }}</div>
        <div class="hiw-card__body">{{ \App\Models\SiteSetting::get('hiw_step1_body', 'Browse hundreds of verified escorts and call girls near you. Filter by location, price, or category.') }}</div>
      </div>
      <div class="hiw-card">
        <div class="hiw-card__num">2</div>
        <div class="hiw-card__icon">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </div>
        <div class="hiw-card__title">{{ \App\Models\SiteSetting::get('hiw_step2_title', 'View Profile') }}</div>
        <div class="hiw-card__body">{{ \App\Models\SiteSetting::get('hiw_step2_body', 'See full details — photos, rates, services, and location. Everything you need to make the right choice.') }}</div>
      </div>
      <div class="hiw-card">
        <div class="hiw-card__num">3</div>
        <div class="hiw-card__icon">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.27h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.37a16 16 0 0 0 6 6l1.27-.95a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        </div>
        <div class="hiw-card__title">{{ \App\Models\SiteSetting::get('hiw_step3_title', 'Connect Directly') }}</div>
        <div class="hiw-card__body">{{ \App\Models\SiteSetting::get('hiw_step3_body', 'Reach out directly via the profile contact details. No middlemen, no delays — just direct connection.') }}</div>
      </div>
      <div class="hiw-card">
        <div class="hiw-card__num">4</div>
        <div class="hiw-card__icon">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        </div>
        <div class="hiw-card__title">{{ \App\Models\SiteSetting::get('hiw_step4_title', 'Enjoy VIP Perks') }}</div>
        <div class="hiw-card__body">{{ \App\Models\SiteSetting::get('hiw_step4_body', 'Upgrade to VIP to unlock priority visibility, more photos, videos, and exclusive features.') }}</div>
      </div>
    </div>
  </div>
</section>

<!-- ══ EDITORIAL ABOUT SECTION ══ -->
<section class="home-section" style="padding-top:0;">
  <div class="container">
    <div class="baddies-editorial">

      <style>
        .baddies-editorial {
          background: #000;
          border: 1px solid rgba(255,140,0,0.25);
          border-radius: 1rem;
          padding: 2.5rem 2rem;
          position: relative;
          overflow: hidden;
        }
        .baddies-editorial::before {
          content: '';
          position: absolute;
          top: -60px; right: -60px;
          width: 300px; height: 300px;
          background: radial-gradient(circle, rgba(255,140,0,0.08) 0%, transparent 70%);
          pointer-events: none;
        }
        .baddies-editorial h2.ed-heading {
          font-size: clamp(1.4rem, 3vw, 1.9rem);
          font-weight: 900;
          color: #fff;
          margin-bottom: 1rem;
          line-height: 1.2;
        }
        .baddies-editorial h2.ed-heading span { color: #ff8c00; }
        .baddies-editorial h3.ed-subheading {
          font-size: 1.05rem;
          font-weight: 700;
          color: #ff8c00;
          margin-top: 1.75rem;
          margin-bottom: 0.5rem;
          letter-spacing: .02em;
        }
        .baddies-editorial p.ed-body {
          font-size: 0.92rem;
          color: rgba(255,255,255,0.68);
          line-height: 1.85;
          margin-bottom: 0;
        }
        .baddies-editorial ul.ed-list {
          margin: 0.6rem 0 0 0;
          padding-left: 0;
          list-style: none;
        }
        .baddies-editorial ul.ed-list li {
          font-size: 0.9rem;
          color: rgba(255,255,255,0.68);
          line-height: 1.8;
          padding-left: 1.4rem;
          position: relative;
        }
        .baddies-editorial ul.ed-list li::before {
          content: '›';
          position: absolute;
          left: 0;
          color: #ff8c00;
          font-weight: 700;
          font-size: 1rem;
        }
        .baddies-editorial .ed-divider {
          height: 1px;
          background: rgba(255,140,0,0.15);
          margin: 1.75rem 0;
        }
        @media(min-width: 992px) {
          .baddies-editorial { padding: 3rem 3.5rem; }
        }
      </style>

      @php
        /**
         * Helper: parse a body string into paragraphs and bullet lists.
         * Lines starting with "- " become <li> items (grouped into <ul class="ed-list">).
         * Blank lines separate paragraphs.
         */
        if (!function_exists('renderEditorialBody')) {
            function renderEditorialBody(string $text): string {
          $lines = explode("\n", str_replace("\r\n", "\n", $text));
          $html  = '';
          $bullets = [];
          $paragraphLines = [];

          $flushParagraph = function() use (&$paragraphLines, &$html) {
            if ($paragraphLines) {
              $html .= '<p class="ed-body" style="margin-top:.75rem;">' . e(implode(' ', $paragraphLines)) . '</p>';
              $paragraphLines = [];
            }
          };
          $flushBullets = function() use (&$bullets, &$html) {
            if ($bullets) {
              $html .= '<ul class="ed-list" style="margin-top:.75rem;">';
              foreach ($bullets as $b) { $html .= '<li>' . e($b) . '</li>'; }
              $html .= '</ul>';
              $bullets = [];
            }
          };

          foreach ($lines as $line) {
            $trimmed = rtrim($line);
            if ($trimmed === '') {
              $flushParagraph();
              $flushBullets();
            } elseif (str_starts_with($trimmed, '- ')) {
              $flushParagraph();
              $bullets[] = ltrim(substr($trimmed, 2));
            } else {
              $flushBullets();
              $paragraphLines[] = $trimmed;
            }
          }
          $flushParagraph();
          $flushBullets();
          return $html;
        }
        }


        $edHeading       = \App\Models\SiteSetting::get('editorial_heading',
          'If you are in Kenya and looking for a way to <span>spice up your day or night</span>, you are lucky to have landed in Baddies‑Club.');
        $edIntro         = \App\Models\SiteSetting::get('editorial_intro',
          "We are a Kenyan escort agency that crafts pleasurable moments for men and women across the country. What pleasure means is totally up to you. Committed to creating authentic Raha vibes, our escort girls are up to anything you can envision in companionship, relaxation, and sexual terms. It's time to spend a day you'll never forget!");
        $edLocalTitle    = \App\Models\SiteSetting::get('editorial_local_title', 'Local Escorts and Call Girls in Kenya');
        $edLocalBody     = \App\Models\SiteSetting::get('editorial_local_body',
          "You may be enjoying Kenyan national parks and African flavors a lot, but it is the local female beauties that make the country one to remember. Most of our girls are Kenyans who are well aware of the real meaning behind Raha and who can do it all for your contentment and sexual delight.\n\nSpend your time while accompanied by passionate Kenya sex escorts and indulge in their pristine beauty. Let them arrange a VIP experience just for you at any place of your choice, as long as they cover the selected area.\n\nBesides Kenyan girls, you are in good company with Eritrean, Egyptian, Ethiopian, Ugandan, and Tanzanian escorts. You can meet them all directly on this website.");
        $edServicesTitle = \App\Models\SiteSetting::get('editorial_services_title', 'A Wide Range of Escort Services in Kenya');
        $edServicesBody  = \App\Models\SiteSetting::get('editorial_services_body',
          "Your wish is our escort girls' command. Whether you are bored, want to blow off some steam, or are thirsty for extraordinary sexual experiences, you only need to find the right lady to accompany you.\n\nHere's a glimpse at the Kenya escort services you can receive with Baddies‑Club:\n- Massage services that get as erotic as you can imagine\n- Luxury and VIP companionship (events or private)\n- Erotic dancing that will leave you speechless\n- Video calls and remote ways of satisfying your desires\n- Incall and outcall sex services\n\nEnjoy time with your escort in a way you're comfortable with. Whether you want her to come over to your place or get away from the usual surroundings, we are at your service.");
        $edMeetTitle     = \App\Models\SiteSetting::get('editorial_meet_title', "Know Whom You're Going to Meet");
        $edMeetBody      = \App\Models\SiteSetting::get('editorial_meet_body',
          "Our escorts in Kenya are hot, but you don't have to take our word for it. The portfolio of every service provider on Baddies‑Club is complete with appearance details and photos, so you can let your eyes choose. These are verified to minimize the risk of unexpected encounters and unwanted surprises on the meeting day.\n\nAs you get familiar with a call girl's portfolio, you'll also discover:\n- Everything she is ready (and isn't ready) to do for you\n- The list of areas covered\n- The fees she would charge for her escort services\n- Contact information");
      @endphp

      <h2 class="ed-heading">{!! $edHeading !!}</h2>

      <p class="ed-body">{{ $edIntro }}</p>

      <div class="ed-divider"></div>

      <h3 class="ed-subheading">{{ $edLocalTitle }}</h3>
      {!! renderEditorialBody($edLocalBody) !!}

      <div class="ed-divider"></div>

      <h3 class="ed-subheading">{{ $edServicesTitle }}</h3>
      {!! renderEditorialBody($edServicesBody) !!}

      <div class="ed-divider"></div>

      <h3 class="ed-subheading">{{ $edMeetTitle }}</h3>
      {!! renderEditorialBody($edMeetBody) !!}

      @guest
      <div class="home-hero__cta-group" style="margin-top:2rem;">
        <a href="#" class="btn-orange" data-bs-toggle="modal" data-bs-target="#authModal" data-auth-tab="register">Create Free Account</a>
        <a href="#" class="btn-outline-orange" data-bs-toggle="modal" data-bs-target="#authModal" data-auth-tab="login">Already have an account?</a>
      </div>
      @endguest

    </div>
  </div>
</section>

<x-footer />

<!-- ══ AUTH MODAL ══ -->
<x-auth-modal />

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


@if(request('deletion_pending'))
<style>
  .del-toast {
    position: fixed; top: 5.5rem; right: 2rem; z-index: 99999;
    display: flex; align-items: flex-start; gap: 0.85rem;
    background: #0d0d0d;
    border: 1px solid rgba(220,53,69,0.45);
    border-left: 4px solid #dc3545;
    border-radius: 14px;
    padding: 1rem 1.25rem;
    max-width: 360px; width: calc(100vw - 4rem);
    box-shadow: 0 20px 60px rgba(0,0,0,0.8), 0 0 0 1px rgba(255,255,255,0.04);
    font-family: "Outfit", ui-sans-serif, sans-serif;
    animation: delToastIn 0.45s cubic-bezier(0.34,1.56,0.64,1) both;
    overflow: hidden;
  }
  @keyframes delToastIn {
    from { opacity:0; transform: translateY(-20px) scale(0.93); }
    to   { opacity:1; transform: translateY(0) scale(1); }
  }
  .del-toast__icon {
    flex-shrink:0; margin-top:2px;
    width:38px; height:38px; border-radius:11px;
    background:rgba(220,53,69,0.12); border:1px solid rgba(220,53,69,0.3);
    display:flex; align-items:center; justify-content:center; color:#ff4d4d;
  }
  .del-toast__body { flex:1; min-width:0; }
  .del-toast__title { font-size:.88rem; font-weight:700; color:#ff4d4d; margin:0 0 .2rem; line-height:1.2; }
  .del-toast__msg   { font-size:.8rem;  color:rgba(255,255,255,.6); margin:0; line-height:1.5; }
  .del-toast__close {
    flex-shrink:0; align-self:flex-start;
    background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.1);
    border-radius:7px; width:26px; height:26px;
    display:flex; align-items:center; justify-content:center;
    color:rgba(255,255,255,.45); cursor:pointer; padding:0; transition:all .2s;
  }
  .del-toast__close:hover { background:rgba(220,53,69,.15); border-color:rgba(220,53,69,.35); color:#ff4d4d; }
  .del-toast__bar {
    position:absolute; bottom:0; left:0; height:3px;
    background:linear-gradient(90deg,#dc3545,rgba(220,53,69,.1));
    border-radius:0 0 0 14px;
    animation:delToastBar 6s linear both;
  }
  @keyframes delToastBar { from{width:100%} to{width:0%} }
</style>
<div class="del-toast" id="delToast" role="alert" aria-live="assertive">
  <div class="del-toast__icon">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
      <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
      <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
    </svg>
  </div>
  <div class="del-toast__body">
    <p class="del-toast__title">Deletion Request Pending</p>
    <p class="del-toast__msg">Your account deletion request is pending admin approval.</p>
  </div>
  <button class="del-toast__close" onclick="document.getElementById('delToast').remove();" aria-label="Dismiss">
    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
      <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
    </svg>
  </button>
  <div class="del-toast__bar"></div>
</div>
<script>setTimeout(()=>{const t=document.getElementById('delToast');if(t)t.remove();},6000);</script>
@endif

</body>
</html>
