<style>
  /* Global anti-FOUC link color overrides */
  :root, [data-bs-theme="dark"], [data-bs-theme="light"] {
    --bs-link-color: rgba(255, 255, 255, 0.8) !important;
    --bs-link-hover-color: #ff8c00 !important;
    --bs-link-color-rgb: 255, 255, 255 !important;
    --bs-link-hover-color-rgb: 255, 140, 0 !important;
  }
  [data-bs-theme="light"] {
    --bs-link-color: rgba(0, 0, 0, 0.8) !important;
    --bs-link-hover-color: #ff8c00 !important;
    --bs-link-color-rgb: 0, 0, 0 !important;
  }
  a, a:link, a:visited, a:hover, a:active, a:focus {
    color: inherit;
    text-decoration: none;
    -webkit-tap-highlight-color: transparent;
  }

  /* Prevent scroll when modal is open on phone */
  body.modal-open {
    overflow: hidden !important;
    touch-action: none !important;
  }
  body.modal-open .modal {
    touch-action: auto !important;
  }

  /* ── Search inputs: light theme fix ── */
  [data-bs-theme="light"] .nr-navbar-search-input {
    background: rgba(255,255,255,0.9) !important;
    color: #111 !important;
    border-color: rgba(255,140,0,0.5) !important;
  }
  [data-bs-theme="light"] .nr-navbar-search-input::placeholder {
    color: rgba(0,0,0,0.4) !important;
  }
  [data-bs-theme="light"] .nr-navbar-search-input:focus {
    border-color: #ff8c00 !important;
    background: #ffffff !important;
  }

  /* ── Search dropdown panel (anchored below icon, no layout shift) ── */
  .nr-search-wrap {
    position: relative;
  }
  .nr-search-panel {
    display: none;
    position: absolute;
    top: calc(100% + 10px);
    right: 0;
    width: 280px;
    background: #111;
    border: 1.5px solid rgba(255,140,0,0.7);
    border-radius: 10px;
    padding: 0.5rem 0.6rem;
    z-index: 2000;
    box-shadow: 0 8px 32px rgba(0,0,0,0.7), 0 0 14px rgba(255,140,0,0.15);
  }
  .nr-search-panel.is-open {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    animation: searchPanelIn 0.18s ease;
  }
  @keyframes searchPanelIn {
    from { opacity:0; transform: translateY(-6px); }
    to   { opacity:1; transform: translateY(0); }
  }
  .nr-search-panel .nr-search-icon-inner {
    color: orange;
    flex-shrink: 0;
    display: flex;
    align-items: center;
  }
  .nr-search-panel input {
    flex: 1;
    background: transparent;
    border: none;
    outline: none;
    color: #fff;
    font-family: 'Outfit', sans-serif;
    font-size: 0.84rem;
    padding: 0.3rem 0;
  }
  .nr-search-panel input::placeholder { color: rgba(255,255,255,0.38); }
  .nr-search-panel button[type=submit] {
    background: orange;
    border: none;
    border-radius: 6px;
    color: #000;
    font-weight: 800;
    font-size: 0.72rem;
    padding: 0.26rem 0.65rem;
    cursor: pointer;
    transition: background 0.2s;
    letter-spacing: 0.03em;
    white-space: nowrap;
  }
  .nr-search-panel button[type=submit]:hover { background: #e07a00; }

  /* NAVBAR STYLES */
  body {
    padding-top: 85px; /* Account for fixed navbar */
  }
  @media (max-width: 1199.98px) { 
    body { padding-top: 75px; } 
  }
  @media (max-width: 767.98px) {
    body { padding-top: 72px; }
  }
  
  .nr-topbar.fixed-top {
    position: fixed !important;
    top: 0 !important;
    z-index: 1040 !important;
    width: 100%;
  }

  .nr-navbar { 
    background: linear-gradient(160deg, #0d0d0d 0%, #1a0f00 50%, #0d0d0d 100%) !important; 
    border-bottom: 2px solid rgba(255,140,0,0.6); 
    box-shadow: inset 0 -2px 30px rgba(255,140,0,0.06); 
    padding-top: 1.25rem !important; 
    padding-bottom: 1.25rem !important; 
  }
  
  .sidebar-icon-link {
    color: white;
    text-decoration: none;
    transition: color 0.3s;
  }
  .sidebar-icon-link:hover, .sidebar-icon-link:active {
    color: orange !important;
    background-color: transparent !important;
  }
  /* Light theme: dropdown card link colors */
  [data-bs-theme="light"] .nr-auth-dropdown-card .sidebar-icon-link {
    color: #111111 !important;
  }
  [data-bs-theme="light"] .nr-auth-dropdown-card .sidebar-icon-link:hover {
    color: #ff8c00 !important;
    background: rgba(255,140,0,0.08) !important;
  }
  [data-bs-theme="light"] .nr-auth-dropdown-card .card-title-text,
  [data-bs-theme="light"] .nr-auth-dropdown-card [style*="color:#fff"],
  [data-bs-theme="light"] .nr-auth-dropdown-card [style*="color: #fff"] {
    color: #111111 !important;
  }
  [data-bs-theme="light"] .nr-auth-dropdown-card .card-sub-text,
  [data-bs-theme="light"] .nr-auth-dropdown-card [style*="color: rgba(255,255,255"] {
    color: rgba(0,0,0,0.55) !important;
  }
  [data-bs-theme="light"] .nr-auth-dropdown-card {
    background: #ffffff !important;
    border-color: rgba(255,140,0,0.45) !important;
    box-shadow: 0 14px 40px rgba(0,0,0,0.12), 0 0 20px rgba(255,140,0,0.15) !important;
  }
  [data-bs-theme="light"] .nr-auth-dropdown-card .border-secondary {
    border-color: rgba(0,0,0,0.1) !important;
  }

  /* Original Link Styles */
  .custom-orange-link {
    color: rgba(255, 140, 0, 0.92) !important;
    text-decoration: none !important;
    transition: color 0.3s ease;
    font-size: 0.82rem;
    font-weight: 500;
  }
  .custom-orange-link:hover {
    color: white !important;
    text-shadow: 0 0 8px rgba(255, 140, 0, 0.6);
  }
  .nav-link.active.custom-orange-link {
    color: #ffffff !important;
    text-shadow: 0 0 8px rgba(255, 140, 0, 0.6);
  }
  
  .mobile-icon-hover {
    transition: transform 0.2s ease;
  }
  .mobile-icon-hover svg {
    transition: stroke 0.3s ease;
  }
  .mobile-icon-hover:hover svg {
    stroke: white !important;
  }
  
  @media (max-width: 1199.98px) {
    #publicNavbar {
      background-color: #111;
      border-radius: 0 0 1.25rem 1.25rem;
      padding: 1rem;
      margin-top: 0;
      box-shadow: 0 10px 30px rgba(0,0,0,0.5);
      border-bottom: 1px solid rgba(255, 165, 0, 0.2);
      border-left: 1px solid rgba(255, 165, 0, 0.2);
      border-right: 1px solid rgba(255, 165, 0, 0.2);
      border-top: none;
    }
    #mainNavbar {
      padding-top: 1.2rem;
      padding-bottom: 1.2rem;
    }
  }
  @media (max-width: 767.98px) {
    .nr-navbar {
      padding-top: 0.9rem !important;
      padding-bottom: 0.9rem !important;
    }
    #mainNavbar {
      padding-top: 0.9rem;
      padding-bottom: 0.9rem;
    }
  }
  
  @media (min-width: 1200px) {
    .navbar-nav > .nav-item > .custom-orange-link:not(.dropdown-toggle) {
      position: relative !important;
      display: inline-block !important;
      padding-bottom: 3px !important;
    }
    .navbar-nav > .nav-item > .custom-orange-link:not(.dropdown-toggle)::after {
      content: '' !important;
      position: absolute !important;
      left: 0 !important;
      bottom: 0 !important;
      width: 100% !important;
      height: 1.5px !important;
      background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.9) 50%, rgba(255,255,255,0) 100%) !important;
      border-radius: 2px !important;
      transform: scaleX(0) !important;
      transform-origin: center !important;
      transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    .navbar-nav > .nav-item > .custom-orange-link:not(.dropdown-toggle):hover::after,
    .navbar-nav > .nav-item > .custom-orange-link.active::after {
      transform: scaleX(1) !important;
    }
    .navbar-nav > .nav-item > .custom-orange-link.active {
      color: white !important;
    }
  }

  /* ── User Icon Button with Glowing Border ── */
  .nr-user-btn {
    width: 42px;
    height: 42px;
    border-radius: 50% !important;
    border: 2px solid #ff8c00 !important;
    background-color: transparent !important;
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    overflow: hidden;
    padding: 0 !important;
    position: relative;
    cursor: pointer;
    box-shadow: 0 0 12px rgba(255, 140, 0, 0.35);
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
  }
  .nr-user-btn.is-logged-in {
    background-color: #ff8c00 !important;
  }
  .nr-user-btn::after {
    display: none !important;
  }
  .nr-user-btn:hover,
  .nr-user-btn:focus,
  .nr-user-btn[aria-expanded="true"] {
    border-color: #ffaa33 !important;
    box-shadow: 0 0 20px rgba(255, 140, 0, 0.8), 0 0 35px rgba(255, 140, 0, 0.35) !important;
    transform: translateY(-1px) scale(1.06);
  }
  .nr-user-btn svg {
    color: #ff8c00;
    transition: transform 0.25s ease, stroke 0.25s ease;
  }
  .nr-user-btn:hover svg {
    stroke: #ffffff;
    transform: scale(1.08);
  }

  /* ── Professional Auth Dropdown Card with Glowing Borders ── */
  .nr-auth-dropdown-card {
    min-width: 220px;
    max-width: 240px;
    background: #0d0d0d !important;
    border: 1.5px solid rgba(255, 140, 0, 0.6) !important;
    border-radius: 14px !important;
    box-shadow: 0 14px 40px rgba(0,0,0,0.9), 0 0 25px rgba(255, 140, 0, 0.28), inset 0 0 10px rgba(255, 140, 0, 0.04) !important;
    overflow: hidden;
    animation: authDropdownCardIn 0.22s cubic-bezier(0.34, 1.4, 0.64, 1) both;
    margin-top: 0.5rem !important;
  }
  @keyframes authDropdownCardIn {
    from { opacity: 0; transform: translateY(8px) scale(0.96); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
  }
  .nr-auth-glow-line {
    height: 2px;
    background: linear-gradient(90deg, transparent 0%, rgba(255,140,0,0.4) 15%, #ff8c00 50%, rgba(255,140,0,0.4) 85%, transparent 100%);
    box-shadow: 0 0 8px #ff8c00;
  }
  .nr-btn-card-primary {
    background: #ff8c00;
    border: 1.5px solid #ff8c00;
    color: #000;
    font-weight: 700;
    font-size: 0.8rem;
    border-radius: 8px;
    padding: 0.4rem 0.75rem;
    text-decoration: none;
    transition: all 0.25s ease;
    letter-spacing: 0.01em;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.35rem;
  }
  .nr-btn-card-primary:hover {
    background: #000000;
    border-color: #ff8c00;
    color: #ffffff;
    box-shadow: 0 0 12px rgba(255, 140, 0, 0.6);
    transform: translateY(-1px);
  }
  .nr-btn-card-secondary {
    background: transparent;
    border: 1.5px solid rgba(255, 140, 0, 0.45);
    color: #fff;
    font-weight: 600;
    font-size: 0.78rem;
    border-radius: 8px;
    padding: 0.38rem 0.75rem;
    text-decoration: none;
    transition: all 0.25s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.35rem;
  }
  .nr-btn-card-secondary:hover {
    background: rgba(255, 140, 0, 0.12);
    border-color: #ff8c00;
    color: #ff8c00;
    transform: translateY(-1px);
  }

  /* Light Theme overrides */
  [data-bs-theme="light"] .nr-auth-dropdown-card {
    background: #ffffff !important;
    border-color: rgba(255, 140, 0, 0.55) !important;
    box-shadow: 0 15px 45px rgba(0,0,0,0.12), 0 0 25px rgba(255,140,0,0.2) !important;
  }
  [data-bs-theme="light"] .nr-auth-dropdown-card .card-title-text {
    color: #111 !important;
  }
  [data-bs-theme="light"] .nr-auth-dropdown-card .card-sub-text {
    color: rgba(0,0,0,0.6) !important;
  }
  [data-bs-theme="light"] .nr-btn-card-secondary {
    color: #111;
    border-color: rgba(255, 140, 0, 0.5);
  }
  [data-bs-theme="light"] .nr-btn-card-secondary:hover {
    background: rgba(255, 140, 0, 0.1);
    color: #ff8c00;
  }
</style>

<!-- ======================= MAIN TOP NAVBAR ======================= -->
<header class="nr-topbar fixed-top">
  <nav class="navbar navbar-expand-xl bg-dark navbar-dark nr-navbar" id="mainNavbar">
    <div class="container position-relative">
      <div class="d-flex align-items-center gap-1 flex-grow-1 flex-xl-grow-0">
        
        <!-- Mobile Profile Dropdown -->
        <div class="dropdown d-xl-none" style="flex-shrink:0; z-index:2;">
          <button class="btn nr-user-btn {{ Auth::check() ? 'is-logged-in' : '' }} dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
            @if(Auth::check())
              @if(Auth::user()->profile_photo)
                <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile" style="width:100%;height:100%;object-fit:cover;border-radius:50%;display:block;">
              @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode(substr(Auth::user()->name, 0, 2)) }}&background=ff8c00&color=000&size=100&bold=true" alt="Profile" style="width:100%;height:100%;object-fit:cover;border-radius:50%;display:block;">
              @endif
            @else
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
            @endif
          </button>
          
          <div class="dropdown-menu dropdown-menu-dark dropdown-menu-start nr-auth-dropdown-card p-0">
            <div class="nr-auth-glow-line"></div>
            @if(Auth::check())
              <div class="px-3 pt-3 pb-2 border-bottom border-secondary border-opacity-25">
                <div class="fw-bold fs-6 card-title-text mb-1" style="color:#fff;">Welcome, <span style="color:#ff8c00;">{{ Auth::user()->name ?? 'User' }}</span></div>
                <div class="small card-sub-text" style="color: rgba(255,255,255,0.6); line-height:1.4; font-size:0.8rem;">Manage your profile &amp; settings.</div>
              </div>
              <div class="p-2">
                <a class="dropdown-item sidebar-icon-link d-flex align-items-center gap-3 py-2 rounded-3" href="{{ route('profile.edit') }}">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ff8c00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> 
                  My Profile
                </a>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                  @csrf
                  <a class="dropdown-item sidebar-icon-link d-flex align-items-center gap-3 py-2 rounded-3 text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#dc3545" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> 
                    Logout
                  </a>
                </form>
              </div>
            @else
              <div class="p-3 text-center">
                <h6 class="fw-bold card-title-text text-white mb-1" style="font-size: 0.92rem; letter-spacing: -0.01em;">
                  Welcome to <span style="color:#ff8c00;">Baddies Club</span>
                </h6>
                <p class="small card-sub-text mb-3" style="color: rgba(255,255,255,0.6); font-size: 0.74rem; line-height: 1.35;">
                  Join Kenya's #1 verified escort &amp; companionship network.
                </p>
                <div class="d-grid gap-2">
                  <a href="#" class="nr-btn-card-primary" data-bs-toggle="modal" data-bs-target="#authModal" data-auth-tab="register">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    <span>Sign Up Free</span>
                  </a>
                  <a href="#" class="nr-btn-card-secondary" data-bs-toggle="modal" data-bs-target="#authModal" data-auth-tab="login">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                    <span>Member Log In</span>
                  </a>
                </div>
              </div>
            @endif
          </div>
        </div>

        <!-- Mobile Centered Logo -->
        <a class="navbar-brand d-flex d-xl-none align-items-center gap-2 position-absolute start-50 translate-middle-x" href="{{ Auth::check() ? route('dashboard') : url('/') }}" style="text-decoration: none; z-index: 1;">
            @if(!empty($siteSettings['logo']))
                <img src="{{ asset('storage/' . $siteSettings['logo']) }}" alt="Logo" style="max-height:52px;width:auto;object-fit:contain;">
            @else
                <span class="fw-bold" style="text-transform: uppercase; letter-spacing: 1px; font-size: 1.15rem;"><span style="color: orange;">Baddies-</span><span style="color: white;">Club</span></span>
            @endif
        </a>
        
        <!-- Desktop Logo -->
        <a class="navbar-brand d-none d-xl-flex align-items-center gap-2 me-0" href="{{ Auth::check() ? route('dashboard') : url('/') }}" style="text-decoration: none;">
            @if(!empty($siteSettings['logo']))
                <img src="{{ asset('storage/' . $siteSettings['logo']) }}" alt="Logo" style="max-height:60px;width:auto;object-fit:contain;">
            @else
                <span class="fw-bold fs-4" style="text-transform: uppercase; letter-spacing: 1px;"><span style="color: orange;">Baddies-</span><span style="color: white;">Club</span></span>
            @endif
        </a>
        

        <div class="ms-auto d-flex align-items-center gap-2 d-xl-none">

          <!-- Mobile Search Toggle Button -->
          @if(!isset($hideSearch) || !$hideSearch)
          <button class="btn p-0 d-flex align-items-center justify-content-center mobile-icon-hover" type="button" data-bs-toggle="collapse" data-bs-target="#mobileSearchCollapse" aria-controls="mobileSearchCollapse" style="width: 36px; height: 36px; background-color: transparent; flex-shrink: 0;" title="Search">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="11" cy="11" r="8"></circle>
              <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
          </button>
          @endif
          
          <!-- Mobile Theme Toggle Button -->
          <button id="themeToggleBtnMobile" class="btn p-0 d-flex align-items-center justify-content-center mobile-icon-hover" type="button" style="width: 36px; height: 36px; background-color: transparent; flex-shrink: 0;" title="Toggle Theme">
            <svg id="themeIconSunMobile" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
              <circle cx="12" cy="12" r="5"></circle>
              <line x1="12" y1="1" x2="12" y2="3"></line>
              <line x1="12" y1="21" x2="12" y2="23"></line>
              <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
              <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
              <line x1="1" y1="12" x2="3" y2="12"></line>
              <line x1="21" y1="12" x2="23" y2="12"></line>
              <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
              <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
            </svg>
            <svg id="themeIconMoonMobile" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
            </svg>
          </button>

          <!-- Hamburger Menu for Mobile -->
          <button class="navbar-toggler btn p-0 mobile-icon-hover" type="button" data-bs-toggle="collapse" data-bs-target="#publicNavbar" aria-controls="publicNavbar" aria-expanded="false" aria-label="Toggle navigation" style="width: 36px; height: 36px; border-radius: 50%; border: 2px solid orange; background-color: orange; display: flex; align-items: center; justify-content: center; flex-shrink: 0; z-index: 2; padding: 0 !important; box-shadow: none !important;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="3" y1="12" x2="21" y2="12"></line>
              <line x1="3" y1="6" x2="21" y2="6"></line>
              <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
          </button>
        </div>
      </div>

      <!-- Search Input Collapse (mobile) -->
      @if(!isset($hideSearch) || !$hideSearch)
      <div class="collapse w-100 mt-2 pb-2 d-xl-none" id="mobileSearchCollapse">
        <form action="{{ route('search') }}" method="GET" class="position-relative" role="search">
          <svg class="position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: orange; pointer-events:none;" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
          </svg>
          <input type="text" name="q" value="{{ request('q') }}" class="form-control nr-navbar-search-input text-white bg-dark ps-5 py-2" placeholder="Search county, title, or category..." style="border: 2px solid orange; box-shadow: none; border-radius: 8px; width: 100%;" autocomplete="off" aria-label="Site search">
        </form>
      </div>
      @endif

      <!-- Collapsed Mobile / Desktop Nav Links -->
      <div class="collapse navbar-collapse" id="publicNavbar">
        <div class="nr-navbar__inner mt-3 mt-xl-0 w-100 d-xl-flex align-items-center">
          <div class="nr-navbar__center flex-grow-1 d-xl-flex justify-content-xl-center">
            
            <ul class="navbar-nav nr-navbar__menu gap-xl-2 text-center text-xl-start">
              <li class="nav-item">
                <a class="nav-link custom-orange-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link custom-orange-link {{ request()->routeIs('escort-girls') ? 'active' : '' }}" href="{{ route('escort-girls') }}">Escort Girls</a>
              </li>
              <li class="nav-item">
                <a class="nav-link custom-orange-link {{ request()->is('category/call-boys') ? 'active' : '' }}" href="/category/call-boys">Call Boys</a>
              </li>
              <li class="nav-item">
                <a class="nav-link custom-orange-link {{ request()->is('videos') ? 'active' : '' }}" href="/videos">Videos</a>
              </li>
              <li class="nav-item">
                <a class="nav-link custom-orange-link {{ request()->is('classifieds') ? 'active' : '' }}" href="/classifieds">Adult Classifieds</a>
              </li>
              @auth
              <li class="nav-item">
                <a class="nav-link custom-orange-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
              </li>
              @endauth
            </ul>

          </div>

          <!-- Desktop Right Side Action (Theme + Profile Dropdown) -->
          <div class="nr-navbar__actions d-none d-xl-block">
            <div class="d-flex flex-column flex-xl-row justify-content-xl-end align-items-xl-center gap-3">
              
              @if(!isset($hideSearch) || !$hideSearch)
              <!-- Desktop Search Icon (right side, opens dropdown below) -->
              <div class="nr-search-wrap">
                <button class="btn p-0 d-flex align-items-center justify-content-center" type="button" id="desktopSearchToggle" aria-label="Search" style="background:transparent; flex-shrink:0; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                  </svg>
                </button>
                <div class="nr-search-panel" id="desktopSearchPanel">
                  <span class="nr-search-icon-inner">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                  </span>
                  <form action="{{ route('search') }}" method="GET" style="display:contents;" role="search">
                    <input type="text" name="q" value="{{ request('q') }}" class="nr-navbar-search-input" placeholder="Search listings..." autocomplete="off" aria-label="Site search" id="desktopSearchInput">
                    <button type="submit">GO</button>
                  </form>
                </div>
              </div>
              @endif

              <!-- Desktop Theme Toggle -->
              <button id="themeToggleBtn" class="btn p-0 d-flex align-items-center justify-content-center" type="button" style="background-color: transparent; flex-shrink: 0; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'" title="Toggle Theme">
                <svg id="themeIconSun" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
                  <circle cx="12" cy="12" r="5"></circle>
                  <line x1="12" y1="1" x2="12" y2="3"></line>
                  <line x1="12" y1="21" x2="12" y2="23"></line>
                  <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                  <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                  <line x1="1" y1="12" x2="3" y2="12"></line>
                  <line x1="21" y1="12" x2="23" y2="12"></line>
                  <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                  <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                </svg>
                <svg id="themeIconMoon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                </svg>
              </button>

              <!-- Desktop Profile Dropdown -->
              <div class="dropdown d-none d-xl-block">
                <button class="btn nr-user-btn {{ Auth::check() ? 'is-logged-in' : '' }} dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  @if(Auth::check())
                    @if(Auth::user()->profile_photo)
                      <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile" style="width:100%;height:100%;object-fit:cover;border-radius:50%;display:block;">
                    @else
                      <img src="https://ui-avatars.com/api/?name={{ urlencode(substr(Auth::user()->name, 0, 2)) }}&background=ff8c00&color=000&size=100&bold=true" alt="Profile" style="width:100%;height:100%;object-fit:cover;border-radius:50%;display:block;">
                    @endif
                  @else
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                      <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                  @endif
                </button>
                
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-dark nr-auth-dropdown-card p-0">
                  <div class="nr-auth-glow-line"></div>
                  @if(Auth::check())
                    <div class="px-3 pt-3 pb-2 border-bottom border-secondary border-opacity-25">
                      <div class="fw-bold fs-6 card-title-text mb-1" style="color:#fff;">Welcome, <span style="color:#ff8c00;">{{ Auth::user()->name ?? 'User' }}</span></div>
                      <div class="small card-sub-text" style="color: rgba(255,255,255,0.6); line-height:1.4; font-size:0.8rem;">Manage your profile &amp; settings.</div>
                    </div>
                    <div class="p-2">
                      <a class="dropdown-item sidebar-icon-link d-flex align-items-center gap-3 py-2 rounded-3" href="{{ route('profile.edit') }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ff8c00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> 
                        My Profile
                      </a>
                      <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <a class="dropdown-item sidebar-icon-link d-flex align-items-center gap-3 py-2 rounded-3 text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#dc3545" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> 
                          Logout
                        </a>
                      </form>
                    </div>
                  @else
                    <div class="p-3 text-center">
                      <h6 class="fw-bold card-title-text text-white mb-1" style="font-size: 0.92rem; letter-spacing: -0.01em;">
                        Welcome to <span style="color:#ff8c00;">Baddies Club</span>
                      </h6>
                      <p class="small card-sub-text mb-3" style="color: rgba(255,255,255,0.6); font-size: 0.74rem; line-height: 1.35;">
                        Join Kenya's #1 verified escort &amp; companionship network.
                      </p>
                      <div class="d-grid gap-2">
                        <a href="#" class="nr-btn-card-primary" data-bs-toggle="modal" data-bs-target="#authModal" data-auth-tab="register">
                          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                          <span>Sign Up Free</span>
                        </a>
                        <a href="#" class="nr-btn-card-secondary" data-bs-toggle="modal" data-bs-target="#authModal" data-auth-tab="login">
                          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                          <span>Member Log In</span>
                        </a>
                      </div>
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
</header>

<script>
// --- Theme and Navbar Global Logic ---
// We use Event Delegation so these listeners survive Livewire DOM replacements.
if (!window._navbarLogicInitialized) {
  window._navbarLogicInitialized = true;

  // Apply saved theme immediately on load
  const savedTheme = localStorage.getItem('theme') || 'dark';
  document.documentElement.setAttribute('data-bs-theme', savedTheme);

  // Sync icons on DOM load or Livewire navigate
  function syncThemeIcons() {
    const theme = document.documentElement.getAttribute('data-bs-theme') || 'dark';
    const suns = document.querySelectorAll('#themeIconSun, #themeIconSunMobile');
    const moons = document.querySelectorAll('#themeIconMoon, #themeIconMoonMobile');
    suns.forEach(el => el.style.display = theme === 'light' ? 'none' : 'block');
    moons.forEach(el => el.style.display = theme === 'light' ? 'block' : 'none');
  }

  document.addEventListener('DOMContentLoaded', syncThemeIcons);
  document.addEventListener('livewire:navigated', syncThemeIcons);

  // Handle Theme Toggle Clicks
  document.addEventListener('click', function(e) {
    const themeBtn = e.target.closest('#themeToggleBtn') || e.target.closest('#themeToggleBtnMobile');
    if (themeBtn) {
      const htmlEl = document.documentElement;
      const currentTheme = htmlEl.getAttribute('data-bs-theme') || 'dark';
      const newTheme = currentTheme === 'light' ? 'dark' : 'light';
      
      htmlEl.setAttribute('data-bs-theme', newTheme);
      localStorage.setItem('theme', newTheme);
      syncThemeIcons();
    }
  });

  // Handle Search Dropdown Toggles
  document.addEventListener('click', function(e) {
    // Desktop Search
    const desktopBtn = e.target.closest('#desktopSearchToggle');
    const desktopPanel = document.getElementById('desktopSearchPanel');
    if (desktopBtn && desktopPanel) {
      e.stopPropagation();
      const open = desktopPanel.classList.toggle('is-open');
      if (open) {
        const input = document.getElementById('desktopSearchInput');
        if (input) setTimeout(() => input.focus(), 50);
      }
    } else if (desktopPanel && !desktopPanel.contains(e.target)) {
      desktopPanel.classList.remove('is-open');
    }

    // Mobile Search
    const mobileBtn = e.target.closest('#mobileSearchToggle');
    const mobilePanel = document.getElementById('mobileSearchPanel');
    if (mobileBtn && mobilePanel) {
      e.stopPropagation();
      const open = mobilePanel.classList.toggle('is-open');
      if (open) {
        const input = document.getElementById('mobileSearchInput');
        if (input) setTimeout(() => input.focus(), 50);
      }
    } else if (mobilePanel && !mobilePanel.contains(e.target)) {
      mobilePanel.classList.remove('is-open');
    }
  });

  // Escape key closes search panels
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      const dp = document.getElementById('desktopSearchPanel');
      if(dp) dp.classList.remove('is-open');
      const mp = document.getElementById('mobileSearchPanel');
      if(mp) mp.classList.remove('is-open');
    }
  });
}
</script>

@php
  $toastTitle = 'Success';
  $toastMsg = null;

  if (session('login_success')) {
    $toastTitle = 'Login Successful';
    $toastMsg = session('login_success');
  } elseif (session('photo_upload_success') || session('status') === 'photo-updated') {
    $toastTitle = 'Photo Published';
    $toastMsg = session('photo_upload_success') ?? 'Your profile photo has been successfully updated.';
  } elseif (session('photo_delete_success') || session('status') === 'photo-deleted') {
    $toastTitle = 'Photo Removed';
    $toastMsg = session('photo_delete_success') ?? 'Your profile photo has been successfully removed.';
  } elseif (session('video_upload_success')) {
    $toastTitle = 'Video Published';
    $toastMsg = session('video_upload_success');
  } elseif (session('video_delete_success')) {
    $toastTitle = 'Video Removed';
    $toastMsg = session('video_delete_success');
  } elseif (session('status') === 'session-terminated') {
    $toastTitle = 'Session Terminated';
    $toastMsg = 'The selected session has been signed out successfully.';
  } elseif (session('status') === 'other-sessions-terminated') {
    $toastTitle = 'Other Sessions Signed Out';
    $toastMsg = 'All other active sessions have been terminated.';
  } elseif (session('status') === 'profile-updated') {
    $toastTitle = 'Profile Updated';
    $toastMsg = 'Your profile information has been saved successfully.';
  } elseif (session('verification_upload_success')) {
    $toastTitle = 'Verification Submitted';
    $toastMsg = session('verification_upload_success');
  } elseif (session('success')) {
    $toastTitle = 'Success';
    $toastMsg = session('success');
  }
@endphp

<style>
  .success-toast {
    position: fixed; top: 5.5rem; right: 2rem; z-index: 99999;
    display: flex; align-items: flex-start; gap: 0.85rem;
    background: #0d0d0d;
    border: 1px solid rgba(40,167,69,0.45);
    border-left: 4px solid #28a745;
    border-radius: 14px;
    padding: 1rem 1.25rem;
    max-width: 360px; width: calc(100vw - 4rem);
    box-shadow: 0 20px 60px rgba(0,0,0,0.8), 0 0 0 1px rgba(255,255,255,0.04);
    font-family: "Outfit", ui-sans-serif, sans-serif;
    animation: successToastIn 0.45s cubic-bezier(0.34,1.56,0.64,1) both;
    overflow: hidden;
  }
  @keyframes successToastIn {
    from { opacity:0; transform: translateY(-20px) scale(0.93); }
    to   { opacity:1; transform: translateY(0) scale(1); }
  }
  .success-toast__icon {
    flex-shrink:0; margin-top:2px;
    width:38px; height:38px; border-radius:11px;
    background:rgba(40,167,69,0.12); border:1px solid rgba(40,167,69,0.3);
    display:flex; align-items:center; justify-content:center; color:#28a745;
  }
  .success-toast__body { flex:1; min-width:0; }
  .success-toast__title { font-size:.88rem; font-weight:700; color:#28a745; margin:0 0 .2rem; line-height:1.2; }
  .success-toast__msg   { font-size:.8rem;  color:rgba(255,255,255,.6); margin:0; line-height:1.5; }
  .success-toast__close {
    flex-shrink:0; align-self:flex-start;
    background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.1);
    border-radius:7px; width:26px; height:26px;
    display:flex; align-items:center; justify-content:center;
    color:rgba(255,255,255,.45); cursor:pointer; padding:0; transition:all .2s;
  }
  .success-toast__close:hover { background:rgba(40,167,69,.15); border-color:rgba(40,167,69,.35); color:#28a745; }
  .success-toast__bar {
    position:absolute; bottom:0; left:0; height:3px;
    background:linear-gradient(90deg,#28a745,rgba(40,167,69,.1));
    border-radius:0 0 0 14px;
    animation:successToastBar 6s linear both;
  }
  @keyframes successToastBar { from{width:100%} to{width:0%} }
  
  /* Warning Toast for generic alerts (orange) */
  .warning-toast {
    position: fixed; top: 5.5rem; right: 2rem; z-index: 99999;
    display: flex; align-items: flex-start; gap: 0.85rem;
    background: #0d0d0d;
    border: 1px solid rgba(255,140,0,0.45);
    border-left: 4px solid #ff8c00;
    border-radius: 14px;
    padding: 1rem 1.25rem;
    max-width: 360px; width: calc(100vw - 4rem);
    box-shadow: 0 20px 60px rgba(0,0,0,0.8), 0 0 0 1px rgba(255,255,255,0.04);
    font-family: "Outfit", ui-sans-serif, sans-serif;
    animation: successToastIn 0.45s cubic-bezier(0.34,1.56,0.64,1) both;
    overflow: hidden;
  }
  .warning-toast__icon {
    flex-shrink:0; margin-top:2px;
    width:38px; height:38px; border-radius:11px;
    background:rgba(255,140,0,0.12); border:1px solid rgba(255,140,0,0.3);
    display:flex; align-items:center; justify-content:center; color:#ff8c00;
  }
  .warning-toast__body { flex:1; min-width:0; }
  .warning-toast__title { font-size:.88rem; font-weight:700; color:#ff8c00; margin:0 0 .2rem; line-height:1.2; }
  .warning-toast__msg   { font-size:.8rem;  color:rgba(255,255,255,.6); margin:0; line-height:1.5; }
  .warning-toast__close {
    flex-shrink:0; align-self:flex-start;
    background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.1);
    border-radius:7px; width:26px; height:26px;
    display:flex; align-items:center; justify-content:center;
    color:rgba(255,255,255,.45); cursor:pointer; padding:0; transition:all .2s;
  }
  .warning-toast__close:hover { background:rgba(255,140,0,.15); border-color:rgba(255,140,0,.35); color:#ff8c00; }
  .warning-toast__bar {
    position:absolute; bottom:0; left:0; height:3px;
    background:linear-gradient(90deg,#ff8c00,rgba(255,140,0,.1));
    border-radius:0 0 0 14px;
    animation:successToastBar 6s linear both;
  }
</style>

@if($toastMsg)
<div class="success-toast" id="successToast" role="alert" aria-live="assertive">
  <div class="success-toast__icon">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
      <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>
    </svg>
  </div>
  <div class="success-toast__body">
    <p class="success-toast__title">{{ $toastTitle }}</p>
    <p class="success-toast__msg">{{ $toastMsg }}</p>
  </div>
  <button class="success-toast__close" onclick="document.getElementById('successToast').remove();" aria-label="Dismiss">
    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
      <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
    </svg>
  </button>
  <div class="success-toast__bar"></div>
</div>
<script>setTimeout(()=>{const t=document.getElementById('successToast');if(t)t.remove();},6000);</script>
@endif

<script>
  (function () {
    // Auto-collapse mobile navbar on outside tap / nav-link tap
    document.addEventListener('click', function (e) {
      var navCollapse = document.getElementById('publicNavbar');
      if (!navCollapse) return;

      // Only act when menu is open
      if (!navCollapse.classList.contains('show')) return;

      var navbar = document.getElementById('mainNavbar');

      // Close if the tap was outside the entire navbar
      if (navbar && !navbar.contains(e.target)) {
        var bsCollapse = bootstrap.Collapse.getInstance(navCollapse);
        if (bsCollapse) {
          bsCollapse.hide();
        } else {
          // Fallback: initialise and hide
          new bootstrap.Collapse(navCollapse, { toggle: false }).hide();
        }
        return;
      }

      // Close if a nav-link inside the menu was tapped
      if (e.target.closest('#publicNavbar a')) {
        var bsCollapse = bootstrap.Collapse.getInstance(navCollapse);
        if (bsCollapse) {
          bsCollapse.hide();
        } else {
          new bootstrap.Collapse(navCollapse, { toggle: false }).hide();
        }
      }
    }, true);
  })();
</script>
