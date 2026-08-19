<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <x-site-favicon />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Search Results for "{{ $q }}" – Kenyan Baddies Club</title>
  <meta name="description" content="Search results for {{ $q }} on Kenyan Baddies Club.">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/listing-card.css') }}">
  <style>
    *, *::before, *::after { box-sizing: border-box; }
    html, body { margin:0; padding:0; font-family:"Outfit",sans-serif; background:#0d0d0d; color:#fff; min-height:100vh; }

    /* PAGE HEADER */
    .sr-header {
      padding: 3.5rem 0 2.5rem;
      border-bottom: 1px solid rgba(255,140,0,0.12);
      background: linear-gradient(180deg, rgba(255,140,0,0.05) 0%, transparent 100%);
    }
    .sr-label {
      font-size: 0.7rem; letter-spacing: 0.14em; text-transform: uppercase;
      color: rgba(255,140,0,0.75); font-weight: 600; margin-bottom: 0.5rem;
      display: flex; align-items: center; gap: 0.5rem;
    }
    .sr-label::before { content: ""; display: block; width: 28px; height: 1.5px; background: rgba(255,140,0,0.5); border-radius: 2px; }
    .sr-title {
      font-size: clamp(1.6rem, 3.5vw, 2.5rem); font-weight: 900;
      letter-spacing: -0.02em; line-height: 1.1; margin-bottom: 0.4rem;
    }
    .sr-title span { background: linear-gradient(135deg, #ff8c00, #ffb347); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    .sr-count { font-size: 0.85rem; color: rgba(255,255,255,0.45); margin-bottom: 1.5rem; }

    /* INLINE SEARCH BAR */
    .sr-search-wrap {
      position: relative; max-width: 540px;
    }
    .sr-search-wrap svg {
      position: absolute; left: 14px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #ff8c00;
    }
    .sr-search-input {
      width: 100%; padding: 0.7rem 1rem 0.7rem 2.75rem;
      background: #1a1a1a; border: 2px solid rgba(255,140,0,0.4); border-radius: 10px;
      color: #fff; font-family: "Outfit", sans-serif; font-size: 0.95rem;
      outline: none; transition: border-color 0.2s;
    }
    .sr-search-input::placeholder { color: rgba(255,255,255,0.3); }
    .sr-search-input:focus { border-color: #ff8c00; }
    .sr-search-btn {
      position: absolute; right: 8px; top: 50%; transform: translateY(-50%);
      background: #ff8c00; border: none; color: #000; border-radius: 7px;
      padding: 0.35rem 1rem; font-family: "Outfit", sans-serif; font-weight: 700;
      font-size: 0.8rem; cursor: pointer; transition: all 0.2s;
    }
    .sr-search-btn:hover { background: #e07a00; }

    /* SECTION HEADINGS */
    .sr-section-title {
      font-size: 1.2rem; font-weight: 800; color: #fff;
      margin: 2.5rem 0 1.25rem; display: flex; align-items: center; gap: 0.75rem;
    }
    .sr-section-title span { color: #ff8c00; }
    .sr-section-title::after { content: ''; flex: 1; height: 1px; background: rgba(255,140,0,0.15); }

    /* PROFILE CARDS GRID */
    .sr-profiles-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
      gap: 1rem; margin-bottom: 2rem;
    }
    @media (min-width: 576px) { .sr-profiles-grid { grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); } }
    @media (min-width: 992px) { .sr-profiles-grid { grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); } }

    /* CLASSIFIED CARDS */
    .sr-classified-card {
      background: #111; border: 1px solid rgba(255,140,0,0.15);
      border-radius: 14px; overflow: hidden; text-decoration: none;
      display: block; transition: all 0.25s ease;
    }
    .sr-classified-card:hover { border-color: rgba(255,140,0,0.45); box-shadow: 0 8px 25px rgba(255,140,0,0.1); transform: translateY(-3px); }
    .sr-classified-card__img { width: 100%; height: 180px; object-fit: cover; display: block; }
    .sr-classified-card__body { padding: 1rem; }
    .sr-classified-card__cat { font-size: 0.65rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: #ff8c00; margin-bottom: 0.4rem; }
    .sr-classified-card__title { font-size: 0.95rem; font-weight: 700; color: #fff; margin-bottom: 0.3rem; line-height: 1.35; }
    .sr-classified-card__meta { font-size: 0.75rem; color: rgba(255,255,255,0.45); display: flex; align-items: center; gap: 0.3rem; margin-bottom: 0.6rem; }
    .sr-classified-card__desc { font-size: 0.82rem; color: rgba(255,255,255,0.55); display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

    /* EMPTY STATE */
    .sr-empty {
      text-align: center; padding: 4rem 1rem;
      color: rgba(255,255,255,0.35);
    }
    .sr-empty__icon { font-size: 3rem; margin-bottom: 1rem; opacity: 0.4; }
    .sr-empty__title { font-size: 1.1rem; font-weight: 700; color: rgba(255,255,255,0.6); margin-bottom: 0.4rem; }

    /* ── LIGHT THEME OVERRIDES ── */
    [data-bs-theme="light"] body { background: #f4f6f9; color: #111; }
    [data-bs-theme="light"] .sr-header { background: linear-gradient(180deg, rgba(255,140,0,0.06) 0%, transparent 100%); border-bottom-color: rgba(0,0,0,0.08); }
    [data-bs-theme="light"] .sr-title { color: #111; }
    [data-bs-theme="light"] .sr-count { color: rgba(0,0,0,0.5); }
    [data-bs-theme="light"] .sr-search-input { background: #ffffff; border-color: rgba(255,140,0,0.4); color: #111; }
    [data-bs-theme="light"] .sr-search-input::placeholder { color: rgba(0,0,0,0.35); }
    [data-bs-theme="light"] .sr-search-input:focus { border-color: #ff8c00; }
    [data-bs-theme="light"] .sr-section-title { color: #111; }
    [data-bs-theme="light"] .sr-section-title::after { background: rgba(0,0,0,0.1); }
    [data-bs-theme="light"] .sr-classified-card { background: #ffffff; border-color: rgba(0,0,0,0.08); }
    [data-bs-theme="light"] .sr-classified-card:hover { border-color: rgba(255,140,0,0.4); box-shadow: 0 8px 25px rgba(0,0,0,0.06); }
    [data-bs-theme="light"] .sr-classified-card__title { color: #111; }
    [data-bs-theme="light"] .sr-classified-card__meta { color: rgba(0,0,0,0.5); }
    [data-bs-theme="light"] .sr-classified-card__desc { color: rgba(0,0,0,0.6); }
    [data-bs-theme="light"] .sr-empty { color: rgba(0,0,0,0.35); }
    [data-bs-theme="light"] .sr-empty__title { color: rgba(0,0,0,0.55); }
  </style>
</head>
<body>
<x-site-preloader />
<x-navbar />

<!-- PAGE HEADER -->
<div class="sr-header">
  <div class="container">
    <div class="sr-label">Search Results</div>
    <h1 class="sr-title">
      @if($q)
        Results for <span>"{{ $q }}"</span>
      @else
        Search <span>Everything</span>
      @endif
    </h1>
    <p class="sr-count">
      @if($q)
        {{ $users->count() + $classifieds->count() }} result{{ ($users->count() + $classifieds->count()) !== 1 ? 's' : '' }} found
      @else
        Enter a search term to get started
      @endif
    </p>
  </div>
</div>

<main class="container pb-5">

  @if($q === '')
    <!-- No query yet -->
    <div class="sr-empty mt-5">
      <div class="sr-empty__icon">🔍</div>
      <div class="sr-empty__title">Start typing to search</div>
      <p>Search for escorts by name, county, location, or subscription tier. Also find classifieds by title or category.</p>
    </div>

  @elseif($users->isEmpty() && $classifieds->isEmpty())
    <!-- No results -->
    @if($isKnownLocation)
      <!-- Known location but no escorts registered there yet -->
      <div class="sr-empty mt-5">
        <div class="sr-empty__icon">📍</div>
        <div class="sr-empty__title">No escorts or call boys in <span style="color:#ff8c00;">{{ ucwords(strtolower($q)) }}</span> yet</div>
        <p style="max-width:480px;margin:0 auto 1.5rem;">
          We recognise <strong>{{ ucwords(strtolower($q)) }}</strong> as a location in Kenya, but no verified escorts or call boys are currently listed there.
          Check back soon — new profiles are added regularly!
        </p>
        <div class="d-flex flex-wrap gap-2 justify-content-center">
          <a href="{{ route('escort-girls') }}" class="btn btn-sm fw-bold" style="background:#ff8c00;color:#000;border:none;padding:0.5rem 1.25rem;border-radius:7px;">Browse All Escort Girls</a>
          <a href="{{ route('call-boys') }}" class="btn btn-sm fw-bold" style="background:transparent;color:#ff8c00;border:2px solid #ff8c00;padding:0.5rem 1.25rem;border-radius:7px;">Browse Call Boys</a>
        </div>
      </div>
    @else
      <!-- Generic no results -->
      <div class="sr-empty mt-5">
        <div class="sr-empty__icon">😔</div>
        <div class="sr-empty__title">No results for "{{ $q }}"</div>
        <p>Try a different keyword — e.g. a county name like "Meru" or "Kisumu", "VIP", "massage", or a person's name.</p>
      </div>
    @endif

  @else

    <!-- PROFILES SECTION -->
    @if($users->isNotEmpty())
    <div class="sr-section-title">
      <span>{{ $users->count() }}</span> Profile{{ $users->count() !== 1 ? 's' : '' }} Found
    </div>
    <div class="sr-profiles-grid">
      @foreach($users as $user)
        @include('partials.user-card', ['user' => $user])
      @endforeach
    </div>
    @endif

    <!-- CLASSIFIEDS SECTION -->
    @if($classifieds->isNotEmpty())
    <div class="sr-section-title">
      <span>{{ $classifieds->count() }}</span> Classified{{ $classifieds->count() !== 1 ? 's' : '' }} Found
    </div>
    <div class="row g-3 mb-5">
      @foreach($classifieds as $classified)
      <div class="col-12 col-sm-6 col-lg-4">
        <a href="{{ route('classifieds.show', $classified->id) }}" class="sr-classified-card">
          @if($classified->image_path)
            <img src="{{ asset('storage/' . $classified->image_path) }}" alt="{{ $classified->title }}" class="sr-classified-card__img">
          @else
            <div class="sr-classified-card__img d-flex align-items-center justify-content-center" style="background:rgba(255,140,0,0.05);">
              <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="rgba(255,140,0,0.4)" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            </div>
          @endif
          <div class="sr-classified-card__body">
            <div class="sr-classified-card__cat">{{ $classified->category }}</div>
            <div class="sr-classified-card__title">{{ $classified->title }}</div>
            @if($classified->city)
            <div class="sr-classified-card__meta">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
              {{ $classified->city }}
            </div>
            @endif
            <div class="sr-classified-card__desc">{{ $classified->description }}</div>
          </div>
        </a>
      </div>
      @endforeach
    </div>
    @endif

  @endif

</main>

<x-footer />
<x-auth-modal />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
