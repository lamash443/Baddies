<style>
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
</style>

<!-- ======================= MAIN TOP NAVBAR ======================= -->
<header class="nr-topbar fixed-top">
  <nav class="navbar navbar-expand-xl bg-dark navbar-dark nr-navbar" id="mainNavbar">
    <div class="container position-relative">
      <div class="d-flex align-items-center gap-1 flex-grow-1 flex-xl-grow-0">
        
        <!-- Mobile Profile Dropdown -->
        <style>
          .mobile-profile-dropdown-toggle::after { display: none !important; }
        </style>
        <div class="dropdown d-xl-none" style="flex-shrink:0; z-index:2;">
          <button class="btn p-0 mobile-icon-hover dropdown-toggle mobile-profile-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false" style="width:42px;height:42px;border-radius:50%;border:2px solid orange;background-color:{{ Auth::check() ? 'orange' : 'transparent' }};display:flex;align-items:center;justify-content:center;overflow:hidden;padding:0;">
            @if(Auth::check())
              @if(Auth::user()->profile_photo)
                <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile" style="width:100%;height:100%;object-fit:cover;border-radius:50%;display:block;">
              @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode(substr(Auth::user()->name, 0, 2)) }}&background=ff8c00&color=000&size=100&bold=true" alt="Profile" style="width:100%;height:100%;object-fit:cover;border-radius:50%;display:block;">
              @endif
            @else
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
            @endif
          </button>
          
          <ul class="dropdown-menu dropdown-menu-dark shadow border-secondary mt-2" style="min-width: 200px; background-color: black;">
            @if(Auth::check())
            <li>
              <div class="px-3 py-2">
                <div class="fw-bold fs-6 text-white mb-1">Welcome, <span style="color:orange;">{{ Auth::user()->name ?? 'User' }}</span></div>
                <div class="small" style="color: rgba(255,255,255,0.6); line-height:1.4;">Manage your profile &amp; settings.</div>
              </div>
            </li>
            <li><hr class="dropdown-divider border-secondary"></li>
            <li>
              <a class="dropdown-item sidebar-icon-link d-flex align-items-center gap-3 py-2" href="{{ route('profile.edit') }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> 
                My Profile
              </a>
            </li>
            <li><hr class="dropdown-divider border-secondary"></li>
            <li>
              <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <a class="dropdown-item sidebar-icon-link d-flex align-items-center gap-3 py-2" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> 
                  Logout
                </a>
              </form>
            </li>
            @else
            <li>
              <a class="dropdown-item sidebar-icon-link d-flex align-items-center gap-3 py-2" href="#" data-bs-toggle="modal" data-bs-target="#authModal" data-auth-tab="login">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg> 
                Login
              </a>
            </li>
            <li><hr class="dropdown-divider border-secondary"></li>
            <li>
              <a class="dropdown-item sidebar-icon-link d-flex align-items-center gap-3 py-2" href="#" data-bs-toggle="modal" data-bs-target="#authModal" data-auth-tab="register">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="22" y1="11" x2="16" y2="11"></line></svg> 
                Sign Up
              </a>
            </li>
            @endif
          </ul>
        </div>

        <!-- Mobile Centered Logo -->
        <a class="navbar-brand d-flex d-xl-none align-items-center gap-2 position-absolute start-50 translate-middle-x" href="{{ Auth::check() ? route('dashboard') : url('/') }}" style="text-decoration: none; z-index: 1;">
            @if(!empty($siteSettings['logo']))
                <img src="{{ asset('storage/' . $siteSettings['logo']) }}" alt="Logo" style="max-height:36px;width:auto;object-fit:contain;">
            @else
                <span class="fw-bold" style="text-transform: uppercase; letter-spacing: 1px; font-size: 1.15rem;"><span style="color: orange;">Baddies-</span><span style="color: white;">Club</span></span>
            @endif
        </a>
        
        <!-- Desktop Logo -->
        <a class="navbar-brand d-none d-xl-flex align-items-center gap-2 me-0" href="{{ Auth::check() ? route('dashboard') : url('/') }}" style="text-decoration: none;">
            @if(!empty($siteSettings['logo']))
                <img src="{{ asset('storage/' . $siteSettings['logo']) }}" alt="Logo" style="max-height:42px;width:auto;object-fit:contain;">
            @else
                <span class="fw-bold fs-4" style="text-transform: uppercase; letter-spacing: 1px;"><span style="color: orange;">Baddies-</span><span style="color: white;">Club</span></span>
            @endif
        </a>
        
        <!-- Desktop Search Bar -->
        @if(!isset($hideSearch) || !$hideSearch)
        <form action="{{ route('search') }}" method="GET" class="d-none d-xl-flex align-items-center ms-5" role="search">
          <div style="display:flex; align-items:stretch; border:2px solid orange; border-radius:8px; overflow:hidden; background:#1a1a1a;">
            <div style="position:relative; display:flex; align-items:center;">
              <svg style="position:absolute; left:10px; color:orange; pointer-events:none; flex-shrink:0;" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
              </svg>
              <input type="text" name="q" value="{{ request('q') }}" class="nr-navbar-search-input" placeholder="Search county, title, or category..." autocomplete="off" aria-label="Site search"
                style="width:230px; padding:0.3rem 0.5rem 0.3rem 2.2rem; border:none; outline:none; background:transparent; color:#fff; font-family:'Outfit',sans-serif; font-size:0.82rem;">
            </div>
            <button type="submit" style="background:orange; border:none; border-left:2px solid orange; color:#000; font-weight:800; font-size:0.78rem; padding:0 0.9rem; cursor:pointer; transition:background 0.2s; letter-spacing:0.03em; white-space:nowrap;" onmouseover="this.style.background='#e07a00'" onmouseout="this.style.background='orange'">GO</button>
          </div>
        </form>
        @endif

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

      <!-- Mobile Search Input Collapse -->
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
              
              <!-- Desktop Theme Toggle -->
              <button id="themeToggleBtn" class="btn p-0 d-flex align-items-center justify-content-center" type="button" style="width: 42px; height: 42px; border-radius: 50%; border: 2px solid orange; background-color: transparent; flex-shrink: 0;" title="Toggle Theme">
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
                <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 42px; height: 42px; border-radius: 50%; border: 2px solid orange; background-color: {{ Auth::check() ? 'orange' : 'transparent' }}; display: flex; align-items: center; justify-content: center; flex-shrink: 0; overflow: hidden; padding: 0;">
                  @if(Auth::check())
                    @if(Auth::user()->profile_photo)
                      <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile" style="width:100%;height:100%;object-fit:cover;border-radius:50%;display:block;">
                    @else
                      <img src="https://ui-avatars.com/api/?name={{ urlencode(substr(Auth::user()->name, 0, 2)) }}&background=ff8c00&color=000&size=100&bold=true" alt="Profile" style="width:100%;height:100%;object-fit:cover;border-radius:50%;display:block;">
                    @endif
                  @else
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                      <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                  @endif
                </button>
                
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark shadow border-secondary mt-2" style="min-width: 200px; background-color: black;">
                  @if(Auth::check())
                  <li>
                    <div class="px-3 py-2">
                      <div class="fw-bold fs-6 text-white mb-1">Welcome, <span style="color:orange;">{{ Auth::user()->name ?? 'User' }}</span></div>
                      <div class="small" style="color: rgba(255,255,255,0.6); line-height:1.4;">Manage your profile &amp; settings.</div>
                    </div>
                  </li>
                  <li><hr class="dropdown-divider border-secondary"></li>
                  <li>
                    <a class="dropdown-item sidebar-icon-link d-flex align-items-center gap-3 py-2" href="{{ route('profile.edit') }}">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> 
                      My Profile
                    </a>
                  </li>
                  <li><hr class="dropdown-divider border-secondary"></li>
                  <li>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                      @csrf
                      <a class="dropdown-item sidebar-icon-link d-flex align-items-center gap-3 py-2" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> 
                        Logout
                      </a>
                    </form>
                  </li>
                  @else
                  <li>
                    <a class="dropdown-item sidebar-icon-link d-flex align-items-center gap-3 py-2" href="#" data-bs-toggle="modal" data-bs-target="#authModal" data-auth-tab="login">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg> 
                      Login
                    </a>
                  </li>
                  <li><hr class="dropdown-divider border-secondary"></li>
                  <li>
                    <a class="dropdown-item sidebar-icon-link d-flex align-items-center gap-3 py-2" href="#" data-bs-toggle="modal" data-bs-target="#authModal" data-auth-tab="register">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="22" y1="11" x2="16" y2="11"></line></svg> 
                      Sign Up
                    </a>
                  </li>
                  @endif
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const htmlEl = document.documentElement;
  
  // Theme Toggle Elements
  const btnDesktop = document.getElementById('themeToggleBtn');
  const sunDesktop = document.getElementById('themeIconSun');
  const moonDesktop = document.getElementById('themeIconMoon');
  
  const btnMobile = document.getElementById('themeToggleBtnMobile');
  const sunMobile = document.getElementById('themeIconSunMobile');
  const moonMobile = document.getElementById('themeIconMoonMobile');

  // Load saved theme
  const savedTheme = localStorage.getItem('theme') || 'dark';
  applyTheme(savedTheme);

  function applyTheme(theme) {
    if (theme === 'light') {
      htmlEl.setAttribute('data-bs-theme', 'light');
      if (sunDesktop) { sunDesktop.style.display = 'none'; moonDesktop.style.display = 'block'; }
      if (sunMobile) { sunMobile.style.display = 'none'; moonMobile.style.display = 'block'; }
    } else {
      htmlEl.setAttribute('data-bs-theme', 'dark');
      if (sunDesktop) { sunDesktop.style.display = 'block'; moonDesktop.style.display = 'none'; }
      if (sunMobile) { sunMobile.style.display = 'block'; moonMobile.style.display = 'none'; }
    }
    localStorage.setItem('theme', theme);
  }

  function toggleTheme() {
    const currentTheme = htmlEl.getAttribute('data-bs-theme');
    applyTheme(currentTheme === 'light' ? 'dark' : 'light');
  }

  if (btnDesktop) btnDesktop.addEventListener('click', toggleTheme);
  if (btnMobile) btnMobile.addEventListener('click', toggleTheme);
});
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
