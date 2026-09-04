<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <x-site-favicon />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Escort Girls in Kenya - Baddies Club</title>
  <meta name="description" content="Browse verified escort girls and call girls in Kenya on Baddies Club. Find your perfect companion in Nairobi, Mombasa, Kisumu and more.">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/listing-card.css') }}">
@php
  $escortGirlsBg = !empty($siteSettings['escort_girls_header_background']) 
    ? asset('storage/' . $siteSettings['escort_girls_header_background']) 
    : asset('images/coup2.jpg');
@endphp
<style>
    *, *::before, *::after { box-sizing:border-box; }
    html, body { margin:0; padding:0; font-family:"Outfit",sans-serif; background:#0d0d0d; color:#fff; min-height:100vh; }

    /* NAVBAR */
    .nr-navbar { background:linear-gradient(160deg,#0d0d0d 0%,#1a0f00 50%,#0d0d0d 100%) !important; border-bottom:2px solid rgba(255,140,0,0.6); box-shadow:inset 0 -2px 30px rgba(255,140,0,0.06); padding-top:1.25rem !important; padding-bottom:1.25rem !important; }
    .nr-navbar .nav-link { font-weight:500; font-size:0.82rem; color:rgba(255,140,0,0.92) !important; text-decoration:none !important; display:inline-block !important; position:relative !important; padding-bottom:3px !important; box-shadow:none !important; transition:color 0.3s ease !important; }
    .nr-navbar .nav-link::after { content:"" !important; position:absolute !important; left:0 !important; bottom:0 !important; width:100% !important; height:1.5px !important; background:linear-gradient(90deg,rgba(255,255,255,0) 0%,rgba(255,255,255,0.9) 50%,rgba(255,255,255,0) 100%) !important; border-radius:2px !important; transform:scaleX(0) !important; transform-origin:center !important; transition:transform 0.35s cubic-bezier(0.4,0,0.2,1) !important; }
    .nr-navbar .nav-link.active, .nr-navbar .nav-link:hover, .nr-navbar .nav-link:focus { color:#ffffff !important; text-decoration:none !important; box-shadow:none !important; }
    .nr-navbar .nav-link.active::after, .nr-navbar .nav-link:hover::after, .nr-navbar .nav-link:focus::after { transform:scaleX(1) !important; }

    /* PAGE HEADER */
    .cb-page-header { position:relative; overflow:hidden; padding:4.5rem 0 3.5rem; background:linear-gradient(180deg,rgba(0,0,0,0.72) 0%,rgba(13,13,13,0.92) 100%), url('{{ $escortGirlsBg }}') center/cover no-repeat; border-bottom:1px solid rgba(255,140,0,0.25); margin-bottom:0; }
    .cb-page-header::before { content:""; position:absolute; top:-80px; right:-80px; width:400px; height:400px; background:radial-gradient(circle,rgba(255,140,0,0.07) 0%,transparent 65%); pointer-events:none; }
    .cb-header-label { font-size:0.7rem; letter-spacing:0.14em; text-transform:uppercase; color:rgba(255,140,0,0.75); font-weight:600; margin-bottom:0.6rem; display:flex; align-items:center; gap:0.5rem; }
    .cb-header-label::before { content:""; display:block; width:28px; height:1.5px; background:rgba(255,140,0,0.5); border-radius:2px; }
    .cb-page-title { font-size:clamp(2rem,4vw,3rem); font-weight:900; letter-spacing:-0.02em; line-height:1.1; margin-bottom:0.6rem; }
    .cb-page-title span { background:linear-gradient(135deg,#ff8c00,#ffb347); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
    .cb-page-desc { font-size:0.92rem; color:rgba(255,255,255,0.48); font-weight:400; max-width:520px; line-height:1.7; }
    .cb-count-badge { display:inline-flex; align-items:center; gap:0.4rem; background:rgba(255,140,0,0.1); border:1px solid rgba(255,140,0,0.25); border-radius:50px; padding:0.3rem 1rem; font-size:0.75rem; font-weight:600; color:rgba(255,140,0,0.9); margin-bottom:1rem; }
    .cb-count-badge .dot { width:6px; height:6px; background:rgba(255,140,0,0.9); border-radius:50%; animation:pulseDot 1.8s infinite; }
    @keyframes pulseDot { 0%,100%{opacity:1;transform:scale(1);} 50%{opacity:0.4;transform:scale(1.6);} }

    /* FILTER BAR */
    .cb-filter-bar { background:rgba(255,140,0,0.03); border-bottom:1px solid rgba(255,140,0,0.1); padding:1rem 0; margin-bottom:2.5rem; }
    .cb-filters { display:flex; gap:0.6rem; flex-wrap:wrap; align-items:center; }
    .cb-filter-btn { padding:0.4rem 1rem; border-radius:50px; cursor:pointer; font-family:"Outfit",sans-serif; font-size:0.78rem; font-weight:700; border:2px solid orange; background:transparent; color:orange; transition:color 0.3s ease, background-color 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease; letter-spacing:0.02em; }
    .cb-filter-btn:hover { background:#000; border-color:orange; color:orange; box-shadow:0 0 18px rgba(255,165,0,0.55), 0 4px 14px rgba(0,0,0,0.3); transform:translateY(-2px); }
    .cb-filter-btn:active { transform:scale(0.97); }
    .cb-filter-btn.active { background:orange; border-color:orange; color:#000; }
    .cb-filter-btn.active:hover { background:#000; color:orange; box-shadow:0 0 18px rgba(255,165,0,0.55), 0 4px 14px rgba(0,0,0,0.3); transform:translateY(-2px); }
    .cb-filter-select { background:#111; border:1.5px solid rgba(255,140,0,0.28); border-radius:50px; color:#fff; padding:0.4rem 2.2rem 0.4rem 1rem; font-family:"Outfit",sans-serif; font-size:0.78rem; font-weight:500; appearance:none; -webkit-appearance:none; cursor:pointer; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='7' viewBox='0 0 10 7'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%23ff8c00' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 0.75rem center; transition:border-color 0.22s ease; }
    .cb-filter-select:focus { outline:none; border-color:rgba(255,140,0,0.7); }
    .cb-filter-select option { background:#1a1a1a; }

    /* NR Listing Card grid container */
    .nr-card-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(220px,1fr)); gap:1.4rem; padding-bottom:1rem; }

    /* btn-primary orange override for nr-listing-card */
    .nr-listing-card .btn-primary,
    .nr-listing-card .btn-primary:visited {
      background-color: #ff8c00 !important;
      border-color: #ff8c00 !important;
      color: #000 !important;
      font-weight: 700 !important;
      transition: all 0.3s ease !important;
    }
    .nr-listing-card .btn-primary:hover,
    .nr-listing-card .btn-primary:focus {
      background-color: #000 !important;
      border-color: #ff8c00 !important;
      color: #ff8c00 !important;
      box-shadow: 0 0 18px rgba(255,140,0,0.5) !important;
    }
    .nr-listing-card__title a { color: #ff8c00 !important; }
    .nr-listing-card__eyebrow { color: rgba(255,140,0,0.8) !important; }
    .nr-listing-card__value,
    .nr-listing-card__value-text,
    .nr-listing-card__value-icon { color: rgba(255,255,255,0.75) !important; }
    .nr-listing-card {
      background: linear-gradient(180deg,#1a0f00,#111) !important;
      border: 1px solid rgba(255,140,0,0.35) !important;
      box-shadow: 0 0 10px rgba(255,140,0,0.18), 0 0.85rem 1.6rem rgba(0,0,0,0.4) !important;
    }
    .nr-listing-card:hover {
      border-color: rgba(255,140,0,0.75) !important;
      box-shadow: 0 0 20px rgba(255,140,0,0.5), 0 0.85rem 1.6rem rgba(0,0,0,0.5) !important;
    }
    .nr-listing-card__ribbon { background: #ff8c00 !important; color: #000 !important; }

    /* HOME SECTION LAYOUT */
    .home-section { padding: 3rem 0; }
    .home-section-header {
      display: flex; align-items: flex-end;
      justify-content: space-between; flex-wrap: wrap;
      gap: 1rem; margin-bottom: 2rem;
    }
    .home-section-title { font-size: 1.6rem; font-weight: 800; color: #fff; margin: 0; }
    .home-section-title span { color: #ff8c00; }
    .home-section-sub { color: rgba(255,255,255,0.5); font-size: .9rem; margin-top: .3rem; }
    .home-section-line {
      width: 48px; height: 3px;
      background: linear-gradient(90deg, #ff8c00, transparent);
      border-radius: 2px; margin-top: .5rem;
    }
    .home-listing-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 1.25rem;
    }
    
    /* LOCATION SECTION CSS */
    .loc-tag {
      display: inline-block; padding: .35rem .75rem; font-size: .78rem; font-weight: 600;
      color: rgba(255, 255, 255, 0.85); background: #000000; border: 1px solid #ff8c00;
      border-radius: .4rem; text-decoration: none; white-space: nowrap; transition: all 0.3s ease;
      letter-spacing: .02em;
    }
    .loc-tag:hover {
      background-color: #000000; border-color: #ff8c00; color: #ffffff;
      box-shadow: 0 0 12px rgba(255, 140, 0, 0.6); transform: translateY(-1px);
    }
    .loc-section-card {
      background: #0d0d0d; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 6px;
      padding: 1rem 1.25rem; margin-bottom: .75rem;
    }
    .loc-section-title {
      font-size: .78rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em;
      color: #ff8c00; margin-bottom: .65rem; display: flex; align-items: center; gap: .5rem;
    }
    .loc-section-title::after { content: ''; flex: 1; height: 1px; background: rgba(255,140,0,0.2); }
    .loc-tags-wrap { display: flex; flex-wrap: wrap; gap: .3rem; }
    
    /* Accordion override for orange theme */
    #locAccordion .accordion-button {
      background: rgba(255,140,0,0.1); color: #ff8c00; font-weight: 700; font-size: .95rem;
      border: 1px solid rgba(255,140,0,0.35); border-radius: 6px !important;
    }
    #locAccordion .accordion-button:not(.collapsed) {
      background: rgba(255,140,0,0.15); color: #ff8c00; box-shadow: none;
      border-bottom-left-radius: 0 !important; border-bottom-right-radius: 0 !important;
    }
    #locAccordion .accordion-button::after { filter: invert(60%) sepia(80%) saturate(400%) hue-rotate(5deg); }
    #locAccordion .accordion-button:focus { box-shadow: 0 0 0 0.2rem rgba(255,140,0,0.25); }
    #locAccordion .accordion-item { background: transparent; border: 1px solid rgba(255,140,0,0.25); border-radius: 6px; overflow: hidden; margin-bottom:2rem; }
    #locAccordion .accordion-body { background: rgba(10,8,0,0.6); padding: 1.25rem; }

    /* ── LIGHT THEME OVERRIDES ── */
    [data-bs-theme="light"] body { background: #f4f6f9; color: #111; }
    [data-bs-theme="light"] .cb-page-header { background: linear-gradient(180deg, rgba(255,255,255,0.85) 0%, rgba(244,246,249,0.95) 100%), url('{{ $escortGirlsBg }}') center/cover no-repeat !important; border-bottom-color: rgba(0,0,0,0.1) !important; }
    [data-bs-theme="light"] .cb-page-title { color: #111; }
    [data-bs-theme="light"] .cb-page-desc { color: rgba(0,0,0,0.65); }
    
    [data-bs-theme="light"] .loc-tag { background: #ffffff; border-color: rgba(255,140,0,0.5); color: #111; }
    [data-bs-theme="light"] .loc-tag:hover { background: #ff8c00; border-color: #ff8c00; color: #ffffff; box-shadow: 0 4px 12px rgba(255,140,0,0.3); }
    [data-bs-theme="light"] .loc-section-card { background: #ffffff; border-color: rgba(0,0,0,0.08); box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
    [data-bs-theme="light"] #locAccordion .accordion-item { background: #ffffff; border-color: rgba(255,140,0,0.25); }
    [data-bs-theme="light"] #locAccordion .accordion-body { background: #fafafa; }
    
    [data-bs-theme="light"] .home-section-title { color: #111 !important; }
    [data-bs-theme="light"] .home-section-sub { color: rgba(0,0,0,0.65) !important; }
    
    [data-bs-theme="light"] .empty-listing-notice,
    [data-bs-theme="light"] div[style*="color:rgba(255,255,255"],
    [data-bs-theme="light"] p[style*="color:rgba(255,255,255"],
    [data-bs-theme="light"] span[style*="color:rgba(255,255,255"] {
      color: rgba(0,0,0,0.65) !important;
    }
  </style>
</head>
<body>
<x-site-preloader />

<x-navbar :hideSearch="true" />

<!-- PAGE HEADER -->
<div class="cb-page-header">
  <div class="container">
    <h1 class="cb-page-title">Escort Girls in <span>Kenya</span></h1>
    <p class="cb-page-desc">Discover verified, discreet female companions across Nairobi, Mombasa, Kisumu and beyond. Browse profiles, check availability and connect instantly.</p>
  </div>
</div>

<!-- LOCATION FILTER SECTION -->
<div class="container mt-4 mb-2">
  <div class="accordion" id="locAccordion">
    <div class="accordion-item">
      <h2 class="accordion-header" id="locHeading">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#locCollapse" aria-expanded="false" aria-controls="locCollapse">
          Browse by Location — Roads, Nairobi Areas & All Counties
        </button>
      </h2>
      <div id="locCollapse" class="accordion-collapse collapse" aria-labelledby="locHeading">
        <div class="accordion-body">
          @php
            $predefinedRoads = ['James Gichuru Road','Southern Bypass','Gitanga Road','Naivasha Road','Northern Bypass','Eastern Bypass','Manyanja Rd','Waiyaki Way','Kiambu Road','Langata Road','Outering Road','Kangundo Road','Ngong Road','Kamiti Road','Jogoo Road','Mombasa Road','Thika Road'];
            $predefinedAreas = ['Allsops','Banana','Buruburu','Chokaa','Dagoretti','Dandora','Donholm','Eastlands','Eastleigh','Embakasi','Garden City','Githurai 44','Githurai 45','Homeland','Hurlingham','Huruma','Imara Daima','Jamhuri','Joska','Juja','Kabete','Kahawa Sukari','Kahawa Wendani','Kahawa West','Kamulu','Kangemi','Karen','Kariobangi','Kasarani','Kawangware','Kayole','Kenyatta Road','Kibera','Kikuyu','Kileleshwa','Kilimani','Kitengela','Kitisuru','Komarock','Langata','Lavington','Loresho','Madaraka','Makadara','Malaa','Mathare','Milimani','Mlolongo','Muthaiga','Muthangari','Muthurwa','Mwiki','Nairobi Town','Nairobi West','Ndenderu','Ngara','Ngong','Ngumba','Njiru','Pangani','Parklands','Roasters','Ongata Rongai','Roysambu','Ruai','Ruaka','Ruaraka','Ruiru','Runda','Saika','South B','South C','Syokimau','Thogoto','Thome','Umoja','Upper Hill','Utawala','Uthiru','Westlands'];
            $predefinedCounties = ['Mombasa','Nakuru','Kiambu','Kisumu','Machakos','Kajiado','Uasin Gishu','Kilifi','Meru','Nyeri','Embu','Kakamega','Bungoma','Bomet','Kisii','Migori','Homa Bay','Siaya','Vihiga','Trans Nzoia','Nandi','Elgeyo Marakwet','Baringo','Laikipia','Nyandarua','Murang\'a','Kirinyaga','Tharaka Nithi','Isiolo','Garissa','Wajir','Mandera','Marsabit','Samburu','Turkana','West Pokot','Lamu','Taita Taveta','Kwale','Tana River','Narok','Kericho','Nyamira','Rachuonyo'];

            $dbCounties = \App\Models\User::where('is_verified', true)->whereNotNull('county')->where('county', '!=', '')->distinct()->pluck('county')->toArray();
            $dbLocations = \App\Models\User::where('is_verified', true)->whereNotNull('location')->where('location', '!=', '')->distinct()->pluck('location')->toArray();

            $mergedCounties = $predefinedCounties;
            foreach ($dbCounties as $dbCounty) {
                $exists = false;
                foreach ($mergedCounties as $county) {
                    if (strcasecmp($dbCounty, $county) === 0) { $exists = true; break; }
                }
                if (!$exists) $mergedCounties[] = $dbCounty;
            }

            $mergedAreas = $predefinedAreas;
            $mergedRoads = $predefinedRoads;
            foreach ($dbLocations as $dbLocation) {
                $exists = false;
                foreach (array_merge($mergedRoads, $mergedAreas) as $loc) {
                    if (strcasecmp($dbLocation, $loc) === 0) { $exists = true; break; }
                }
                if (!$exists) $mergedAreas[] = $dbLocation;
            }
          @endphp

          {{-- Nairobi Major Roads --}}
          <div class="loc-section-card">
            <div class="loc-section-title">Major Roads in Nairobi</div>
            <div class="loc-tags-wrap">
              @foreach($mergedRoads as $road)
                <a href="{{ route('location.show', ['name' => $road]) }}" class="loc-tag">{{ $road }}</a>
              @endforeach
            </div>
          </div>

          {{-- Nairobi County Areas --}}
          <div class="loc-section-card">
            <div class="loc-section-title">Nairobi County Areas</div>
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

<!-- SECTIONS -->

<section id="vip-escorts" class="home-section" style="padding-top:2rem;">
  <div class="container">
    <div class="home-section-header">
      <div>
        <h2 class="home-section-title"><span>VIP</span> Call Girls</h2>
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

<section id="prime-vip-escorts" class="home-section" style="padding-top:0;">
  <div class="container">
    <div class="home-section-header">
      <div>
        <h2 class="home-section-title"><span>Prime VIP</span> Call Girls</h2>
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

<section id="prime-escorts" class="home-section" style="padding-top:0;">
  <div class="container">
    <div class="home-section-header">
      <div>
        <h2 class="home-section-title"><span>Prime</span> Call Girls</h2>
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

<section id="regular-escorts" class="home-section" style="padding-top:0;">
  <div class="container">
    <div class="home-section-header">
      <div>
        <h2 class="home-section-title"><span>Call</span> Girls</h2>
        <p class="home-section-sub">Verified escorts and call girls across Kenya</p>
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

<x-footer />
<x-auth-modal />

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function setFilter(btn) {
    document.querySelectorAll('.cb-filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
  }
</script>
</body>
</html>


