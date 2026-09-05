<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Adult Classifieds - Baddies Club</title>
  <meta name="description" content="Adult Classifieds: Personals, Massage, Jobs, and Events in Kenya.">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; }
    html, body { margin:0; padding:0; font-family:"Outfit",sans-serif; background:#0d0d0d; color:#fff; min-height:100vh; }
    
    /* HEADER / HERO */
    .hero {
      position: relative;
      padding: 6rem 0 4rem;
      text-align: center;
      background: linear-gradient(180deg, rgba(255,140,0,0.05) 0%, #0d0d0d 100%);
      border-bottom: 1px solid rgba(255,140,0,0.1);
    }
    .hero-title {
      font-size: clamp(2.5rem, 5vw, 4rem);
      font-weight: 900;
      letter-spacing: -0.02em;
      margin-bottom: 1rem;
    }
    .hero-title span {
      background: linear-gradient(135deg, #ff8c00, #ffb347);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .hero-subtitle {
      font-size: 1.15rem;
      color: rgba(255,255,255,0.7);
      max-width: 600px;
      margin: 0 auto;
    }

    /* GRID & CARDS */
    .class-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1.5rem;
      padding: 3rem 0;
    }
    @media (max-width: 991px) {
      .class-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }
    @media (max-width: 576px) {
      .class-grid {
        grid-template-columns: 1fr;
      }
    }
    .class-card {
      background: linear-gradient(145deg, rgba(255,140,0,0.05) 0%, rgba(17,17,17,0.7) 100%);
      border: 1px solid rgba(255,140,0,0.15);
      border-radius: 16px;
      padding: 2.5rem 1.5rem;
      text-align: center;
      text-decoration: none;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      position: relative;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }
    .class-card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: radial-gradient(circle at center, rgba(255,140,0,0.15) 0%, transparent 70%);
      opacity: 0;
      transition: opacity 0.4s ease;
    }
    .class-card:hover {
      transform: translateY(-8px);
      border-color: rgba(255,140,0,0.5);
      box-shadow: 0 15px 40px rgba(255,140,0,0.15);
    }
    .class-card:hover::before {
      opacity: 1;
    }
    .class-icon {
      width: 72px; height: 72px;
      background: rgba(255,140,0,0.1);
      border: 1px solid rgba(255,140,0,0.3);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      color: orange;
      margin-bottom: 1.5rem;
      position: relative;
      z-index: 1;
      transition: transform 0.4s ease, background 0.4s ease;
    }
    .class-card:hover .class-icon {
      transform: scale(1.1);
      background: orange;
      color: #000;
    }
    .class-title {
      font-size: 1.6rem;
      font-weight: 800;
      color: #fff;
      margin-bottom: 0.5rem;
      position: relative;
      z-index: 1;
    }
    .class-desc {
      font-size: 0.95rem;
      color: rgba(255,255,255,0.6);
      position: relative;
      z-index: 1;
      margin: 0;
    }
    .btn-create-classified {
      background-color: #ff8c00;
      border: 2px solid #ff8c00;
      color: #fff;
      border-radius: 6px;
      transition: all 0.3s ease;
    }
    .btn-create-classified:hover {
      background-color: #111;
      color: #ff8c00;
      box-shadow: 0 0 15px rgba(255,140,0,0.6);
      border-color: #ff8c00;
    }

    /* ── LIGHT THEME OVERRIDES ── */
    [data-bs-theme="light"] body { background: #f4f6f9; color: #111; }

    [data-bs-theme="light"] .hero {
      background: linear-gradient(180deg, rgba(255,140,0,0.06) 0%, #f4f6f9 100%);
      border-bottom-color: rgba(0,0,0,0.08);
    }
    [data-bs-theme="light"] .hero-title { color: #111; }
    [data-bs-theme="light"] .hero-subtitle { color: rgba(0,0,0,0.65); }

    [data-bs-theme="light"] .class-card {
      background: linear-gradient(145deg, rgba(255,140,0,0.04) 0%, #ffffff 100%);
      border-color: rgba(255,140,0,0.2);
      box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }
    [data-bs-theme="light"] .class-card:hover {
      border-color: rgba(255,140,0,0.5);
      box-shadow: 0 15px 40px rgba(255,140,0,0.1);
    }
    [data-bs-theme="light"] .class-title { color: #111; }
    [data-bs-theme="light"] .class-desc { color: rgba(0,0,0,0.6); }
    [data-bs-theme="light"] .class-icon { background: rgba(255,140,0,0.08); border-color: rgba(255,140,0,0.25); }

    [data-bs-theme="light"] h4.text-light { color: #111 !important; }
    [data-bs-theme="light"] .text-secondary { color: rgba(0,0,0,0.55) !important; }
    [data-bs-theme="light"] .btn-create-classified:hover { background-color: #ffffff; }

  </style>
</head>
<body>
  <x-navbar :hideSearch="true" />

  <section class="hero">
    <div class="container">
      <h1 class="hero-title">Adult <span>Classifieds</span></h1>
      <p class="hero-subtitle">Browse discrete personals, erotic massage services, adult industry jobs, and private exclusive events.</p>
      <div class="mt-4">
        <a href="{{ route('profile.edit') }}#tab-classifieds" class="btn btn-create-classified fw-bold px-4 py-2">
          + Create Classified
        </a>
      </div>
    </div>
  </section>

  <div class="container">
    <div class="class-grid">
      <!-- Personals -->
      <a href="{{ route('classifieds', ['category' => 'personals']) }}" class="class-card">
        <div class="class-icon">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.42 4.58a5.4 5.4 0 0 0-7.65 0l-.77.78-.77-.78a5.4 5.4 0 0 0-7.65 0C1.46 6.7 1.33 10.28 4 13l8 8 8-8c2.67-2.72 2.54-6.3.42-8.42z"/></svg>
        </div>
        <div class="class-title">Personals</div>
        <p class="class-desc">Seeking Arrangements</p>
      </a>

      <!-- Massage -->
      <a href="{{ route('classifieds', ['category' => 'massage']) }}" class="class-card">
        <div class="class-icon">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
        </div>
        <div class="class-title">Massage</div>
        <p class="class-desc">Erotic & Sensual</p>
      </a>

      <!-- Jobs -->
      <a href="{{ route('classifieds', ['category' => 'jobs']) }}" class="class-card">
        <div class="class-icon">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
        </div>
        <div class="class-title">Jobs</div>
        <p class="class-desc">Adult Industry Jobs</p>
      </a>

      <!-- Events -->
      <a href="{{ route('classifieds', ['category' => 'events']) }}" class="class-card">
        <div class="class-icon">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
        <div class="class-title">Events</div>
        <p class="class-desc">Private Parties</p>
      </a>
    </div>
  </div>

  <div class="container mb-5 mt-4">
    <h2 class="hero-title" style="font-size:2rem; margin-bottom:1.5rem;">Recent <span>Listings</span></h2>
    @if($classifieds->isEmpty())
      <p class="text-secondary text-center py-5">No classifieds available at the moment.</p>
    @else
      <div class="row g-4">
        @foreach($classifieds as $classified)
          <div class="col-12 col-md-6 col-lg-4">
            <a href="{{ route('classifieds.show', $classified->id) }}" class="class-card" style="padding:1rem; align-items:flex-start; text-align:left; display:block; text-decoration:none;">
               @if($classified->image_path)
               <img src="{{ asset('storage/' . $classified->image_path) }}" alt="{{ $classified->title }}" style="width:100%; height:200px; object-fit:cover; border-radius:12px; margin-bottom:1rem;">
               @endif
               <span class="badge bg-warning text-dark mb-2 text-uppercase">{{ $classified->category }}</span>
               <h4 class="text-light fw-bold mb-1">{{ $classified->title }}</h4>
               <p class="small text-secondary mb-2"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:4px;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>{{ $classified->city ?? 'N/A' }}</p>
               <p class="text-secondary" style="font-size:0.9rem; display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden;">{{ $classified->description }}</p>
               <div class="btn btn-outline-warning w-100 mt-2" style="display:block; text-align:center;">View Details</div>
            </a>
          </div>
        @endforeach
      </div>
    @endif
  </div>

  <x-footer />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <x-auth-modal />
</body>
</html>
