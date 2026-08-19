<style>
  /* NAVBAR STYLES (Required for x-navbar) */
  body {
    padding-top: 85px; /* Account for fixed navbar */
  }
  @media (max-width: 1199.98px) { 
    body { padding-top: 75px; } 
  }
  
  /* Offcanvas elements must NOT affect page layout */
  #mobileUserSidebar,
  #mobileMenuSidebar {
    position: fixed !important;
    height: 100vh !important;
    top: 0 !important;
  }
  .nr-topbar.fixed-top {
    position: fixed !important;
    top: 0 !important;
    z-index: 1040 !important;
    -webkit-transform: translateZ(0);
    transform: translateZ(0);
    will-change: transform;
    margin: 0 !important;
    width: 100%;
  }
  /* Offcanvas elements must NOT affect page layout */
  #mobileUserSidebar,
  #mobileMenuSidebar {
    position: fixed !important;
    height: 100vh !important;
    top: 0 !important;
  }
  .nr-topbar.sticky-top {
    position: -webkit-sticky !important;
    position: sticky !important;
    top: 0 !important;
    z-index: 1040 !important;
    -webkit-transform: translateZ(0);
    transform: translateZ(0);
    will-change: transform;
    margin: 0 !important;
  }
  .nr-navbar { background:linear-gradient(160deg,#0d0d0d 0%,#1a0f00 50%,#0d0d0d 100%) !important; border-bottom:2px solid rgba(255,140,0,0.6); box-shadow:inset 0 -2px 30px rgba(255,140,0,0.06); padding-top:1.25rem !important; padding-bottom:1.25rem !important; }
  .nr-navbar .nav-link { font-weight:500; font-size:0.82rem; color:rgba(255,140,0,0.92) !important; text-decoration:none !important; display:inline-block !important; position:relative !important; padding-bottom:3px !important; box-shadow:none !important; transition:color 0.3s ease !important; }
  .nr-navbar .nav-link::after { content:"" !important; position:absolute !important; left:0 !important; bottom:0 !important; width:100% !important; height:1.5px !important; background:linear-gradient(90deg,rgba(255,255,255,0) 0%,rgba(255,255,255,0.9) 50%,rgba(255,255,255,0) 100%) !important; border-radius:2px !important; transform:scaleX(0) !important; transform-origin:center !important; transition:transform 0.35s cubic-bezier(0.4,0,0.2,1) !important; }
  .nr-navbar .nav-link.active, .nr-navbar .nav-link:hover, .nr-navbar .nav-link:focus { color:#ffffff !important; text-decoration:none !important; box-shadow:none !important; }
  .nr-navbar .nav-link.active::after, .nr-navbar .nav-link:hover::after, .nr-navbar .nav-link:focus::after { transform:scaleX(1) !important; }

  .sidebar-icon-link {
    color: white;
    text-decoration: none;
    transition: color 0.3s;
  }
  .sidebar-icon-link:hover, .sidebar-icon-link:active {
          </div>
          <span class="small mt-2 fw-medium" style="font-size: 0.75rem;">Sign Up</span>
        </a>
        <a class="sidebar-icon-link d-flex flex-column align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#authModal" data-auth-tab="login" title="Login">
          <div class="icon-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; border-radius: 50%; border: 2px solid orange;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
              <polyline points="10 17 15 12 10 7"></polyline>
              <line x1="15" y1="12" x2="3" y2="12"></line>
            </svg>
          </div>
          <span class="small mt-2 fw-medium" style="font-size: 0.75rem;">Login</span>
        </a>
        <a class="sidebar-icon-link d-flex flex-column align-items-center" href="#" title="Liked Profiles">
          <div class="icon-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; border-radius: 50%; border: 2px solid orange;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
            </svg>
          </div>
          <span class="small mt-2 fw-medium text-center" style="font-size: 0.75rem;">Liked Profile</span>
        </a>
      </div>

      <hr class="border-secondary mt-4 mb-4">

      <div class="d-flex flex-column gap-4 px-2 pb-4">
        @auth
        <a href="{{ route('dashboard') }}" class="sidebar-icon-link d-flex align-items-center gap-3 text-decoration-none">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
          <span class="fw-medium">Dashboard</span>
        </a>
        @endauth
        <a href="#" class="sidebar-icon-link d-flex align-items-center gap-3 text-decoration-none">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
          </svg>
          <span class="fw-medium">Subscriptions</span>
        </a>
        
        <a href="#" class="sidebar-icon-link d-flex align-items-center gap-3 text-decoration-none">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
            <polyline points="17 8 12 3 7 8"></polyline>
            <line x1="12" y1="3" x2="12" y2="15"></line>
          </svg>
          <span class="fw-medium">Upload</span>
        </a>

        <div class="dropdown">
          <a href="#" class="sidebar-icon-link d-flex align-items-center gap-3 text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"></circle>
              <line x1="2" y1="12" x2="22" y2="12"></line>
              <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
            </svg>
            <span class="fw-medium">Language</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-dark shadow border-secondary mt-2">
            <li><a class="dropdown-item d-flex align-items-center py-2" href="#">English</a></li>
            <li><a class="dropdown-item d-flex align-items-center py-2" href="#">EspaÃ±ol</a></li>
            <li><a class="dropdown-item d-flex align-items-center py-2" href="#">FranÃ§ais</a></li>
          </ul>
        </div>

        <a href="#" class="sidebar-icon-link d-flex align-items-center gap-3 text-decoration-none">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
            <line x1="12" y1="17" x2="12.01" y2="17"></line>
          </svg>
          <span class="fw-medium">FAQ</span>
        </a>

        <a href="#" class="sidebar-icon-link d-flex align-items-center gap-3 text-decoration-none">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
          </svg>
          <span class="fw-medium">Contact Support</span>
        </a>
      </div>

    </div>
  </div>
        </a>

        <div class="dropdown">
          <a href="#" class="sidebar-icon-link d-flex align-items-center gap-3 text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"></circle>
              <line x1="2" y1="12" x2="22" y2="12"></line>
              <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
            </svg>
            <span class="fw-medium">Language</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-dark shadow border-secondary mt-2">
            <li><a class="dropdown-item d-flex align-items-center py-2" href="#">English</a></li>
            <li><a class="dropdown-item d-flex align-items-center py-2" href="#">EspaÃ±ol</a></li>
            <li><a class="dropdown-item d-flex align-items-center py-2" href="#">FranÃ§ais</a></li>
          </ul>
        </div>

        <a href="#" class="sidebar-icon-link d-flex align-items-center gap-3 text-decoration-none">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
            <line x1="12" y1="17" x2="12.01" y2="17"></line>
          </svg>
          <span class="fw-medium">FAQ</span>
        </a>

        <a href="#" class="sidebar-icon-link d-flex align-items-center gap-3 text-decoration-none">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
          </svg>
          <span class="fw-medium">Contact Support</span>
        </a>
      </div>

    </div>
  </div>

  <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="mobileMenuSidebar" aria-labelledby="mobileMenuSidebarLabel" style="background-color: black !important; width: 60vw; max-width: 280px; min-width: 220px;">
    <div class="offcanvas-header border-bottom border-secondary py-2">
      <h5 class="offcanvas-title mb-0" id="mobileMenuSidebarLabel">
        <span class="fw-bold" style="color: orange; font-size: 1.1rem;">Nai-Raha</span>
      </h5>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body py-3 px-3">
      <div class="d-flex flex-column gap-2">
        <a class="text-white text-decoration-none fw-medium sidebar-icon-link" style="font-size: 0.9rem;" href="category/escort-girls.html">Escort Girls</a>
        <a class="text-white text-decoration-none fw-medium sidebar-icon-link" style="font-size: 0.9rem;" href="category/call-boys.html">Call Boys</a>
        <a class="text-white text-decoration-none fw-medium sidebar-icon-link" style="font-size: 0.9rem;" href="videos.html">Videos</a>
        <a class="text-white text-decoration-none fw-medium sidebar-icon-link" style="font-size: 0.9rem;" href="classifieds.html">Hot Hookups</a>
              </a>
            </li>
            <li><hr class="dropdown-divider border-secondary"></li>
            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a class="dropdown-item sidebar-icon-link d-flex align-items-center gap-3 py-2" href="{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                  </svg>
                  Logout
                </a>
              </form>
            </li>
            @else
            <li>
              <a class="dropdown-item sidebar-icon-link d-flex align-items-center gap-3 py-2" href="#" data-bs-toggle="modal" data-bs-target="#authModal" data-auth-tab="login">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                  <polyline points="10 17 15 12 10 7"></polyline>
                  <line x1="15" y1="12" x2="3" y2="12"></line>
                </svg>
                Login
              </a>
            </li>
            <li><hr class="dropdown-divider border-secondary"></li>
            <li>
            <li><hr class="dropdown-divider border-secondary"></li>
            <li>
              <a class="dropdown-item sidebar-icon-link d-flex align-items-center gap-3 py-2" href="{{ route('profile.edit') }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                  <circle cx="12" cy="7" r="4"></circle>
                </svg>
                My Profile
              </a>
            </li>
            <li><hr class="dropdown-divider border-secondary"></li>
            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a class="dropdown-item sidebar-icon-link d-flex align-items-center gap-3 py-2" href="{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                  </svg>
                  Logout
                </a>
              </form>
            </li>
            @else
            <li>
              <a class="dropdown-item sidebar-icon-link d-flex align-items-center gap-3 py-2" href="#" data-bs-toggle="modal" data-bs-target="#authModal" data-auth-tab="login">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                  <polyline points="10 17 15 12 10 7"></polyline>
                  <line x1="15" y1="12" x2="3" y2="12"></line>
        <div class="ms-auto d-flex align-items-center gap-2 d-xl-none">
          @if(!isset($hideSearch) || !$hideSearch)
          <!-- Mobile Search Toggle Button -->
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

          <button class="btn p-0 mobile-icon-hover" type="button" data-bs-toggle="collapse" data-bs-target="#publicNavbar" aria-controls="publicNavbar" aria-expanded="false" aria-label="Toggle navigation" style="width: 36px; height: 36px; border-radius: 50%; border: 2px solid orange; background-color: orange; display: flex; align-items: center; justify-content: center; flex-shrink: 0; z-index: 2;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="3" y1="12" x2="21" y2="12"></line>
              <line x1="3" y1="6" x2="21" y2="6"></line>
              <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
          </button>
        </div>
      </div>

      @if(!isset($hideSearch) || !$hideSearch)
      <!-- Mobile Search Input Collapse -->
      <div class="collapse w-100 mt-2 pb-2 d-xl-none" id="mobileSearchCollapse">
        <form action="search.html" method="get" class="position-relative">
          <svg class="position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: orange;" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
          </svg>
          <input type="text" name="q" class="form-control text-white bg-dark ps-5 py-2" placeholder="Search county, title, or category..." style="border: 2px solid orange; box-shadow: none; border-radius: 8px; width: 100%;">
        </form>
      </div>
      @endif

      <div class="collapse navbar-collapse" id="publicNavbar">
        <div class="nr-navbar__inner mt-3 mt-xl-0 d-xl-flex w-100 align-items-center">
          <div class="nr-navbar__center flex-grow-1 d-xl-flex justify-content-xl-center">
            <style>
              .custom-orange-link {
                color: rgba(255, 140, 0, 0.92) !important;
                text-decoration: none !important;
                transition: color 0.3s ease;
              }
              .custom-orange-link:hover {
                color: white !important;
                text-decoration: none !important;
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
              @media (min-width: 1200px) {
                .navbar-nav > .nav-item > .custom-orange-link:not(.dropdown-toggle) {
                  position: relative;
                }
                .navbar-nav > .nav-item > .custom-orange-link:not(.dropdown-toggle)::after {
                  content: '';
                  position: absolute;
                  width: 0;
                  height: 2px;
                  bottom: 6px;
                  left: 50%;
                  background-color: white;
                  transition: all 0.3s ease;
                  transform: translateX(-50%);
                  border-radius: 2px;
                }
                .navbar-nav > .nav-item > .custom-orange-link:not(.dropdown-toggle):hover::after,
                .navbar-nav > .nav-item > .custom-orange-link.active::after {
                  width: calc(100% - 1rem);
                }
                .navbar-nav > .nav-item > .custom-orange-link.active {
                  color: white !important;
                }
              }
            </style>
            <ul class="navbar-nav nr-navbar__menu gap-xl-2 text-center text-xl-start">
                                                                <li class="nav-item">
                    <a class="nav-link custom-orange-link {{ request()->is('/') ? 'active' : '' }}" href="/#vip-escorts">Escort Girls</a>
                  </li>
                                                                                <li class="nav-item">
                    <a class="nav-link custom-orange-link {{ request()->is('category/call-boys') ? 'active' : '' }}" href="/category/call-boys">Call Boys</a>
                  </li>
                                                                                <li class="nav-item">
                    <a class="nav-link custom-orange-link {{ request()->is('videos') ? 'active' : '' }}" href="/videos">Videos</a>
                  </li>
                                                                                <li class="nav-item">
                    <a class="nav-link custom-orange-link {{ request()->is('hot-hookups') ? 'active' : '' }}" href="/hot-hookups">Hot Hookups</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle custom-orange-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      More
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" style="background-color: black;">
                      <li><a class="dropdown-item sidebar-icon-link custom-orange-link" href="category/queer.html">Queer</a></li>
                      <li><a class="dropdown-item sidebar-icon-link custom-orange-link" href="our-locations.html">Our Locations</a></li>
                    </ul>
                  </li>
                  @auth
                  <li class="nav-item">
                    <a class="nav-link custom-orange-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="me-1" style="vertical-align:-1px"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                      Dashboard
                    </a>
                  </li>
                  @endauth
                                          </ul>
          </div>

          <div class="nr-navbar__actions">
            <div class="d-flex flex-column flex-xl-row justify-content-xl-end align-items-xl-center gap-2">
              
              <!-- Theme Toggle Button -->
              <button id="themeToggleBtn" class="btn p-0 me-3 d-none d-xl-flex align-items-center justify-content-center" type="button" style="width: 36px; height: 36px; background-color: transparent; flex-shrink: 0;" title="Toggle Theme">
                <svg id="themeIconSun" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
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
                <svg id="themeIconMoon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                </svg>
              </button>

                              <div class="dropdown d-none d-xl-block">
                <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 42px; height: 42px; border-radius: 50%; border: 2px solid orange; background-color: {{ Auth::check() ? 'orange' : 'transparent' }}; display: flex; align-items: center; justify-content: center; flex-shrink: 0; overflow: hidden; padding: 0;">
                  @if(Auth::check() && Auth::user()->profile_photo)
                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile" style="width:100%;height:100%;object-fit:cover;border-radius:50%;display:block;">
                  @else
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="{{ Auth::check() ? 'black' : 'orange' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                      <div class="small" style="color: rgba(255,255,255,0.6); line-height:1.4;">Manage your profile, balance, and account settings.</div>
                    </div>
                  </li>
                  <li><hr class="dropdown-divider border-secondary"></li>
                  <li>
                    <a class="dropdown-item sidebar-icon-link d-flex align-items-center gap-3 py-2" href="{{ route('profile.edit') }}">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                      </svg> 
                      My Profile
                    </a>
                  </li>
                  <li><hr class="dropdown-divider border-secondary"></li>
                  <li>
                    <form method="POST" action="{{ route('logout') }}">
                      @csrf
                      <a class="dropdown-item sidebar-icon-link d-flex align-items-center gap-3 py-2" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                          <polyline points="16 17 21 12 16 7"></polyline>
                          <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg> 
                        Logout
                      </a>
                    </form>
                  </li>
                  @else
                  <li>
                    <a class="dropdown-item sidebar-icon-link d-flex align-items-center gap-3 py-2" href="#" data-bs-toggle="modal" data-bs-target="#authModal" data-auth-tab="login">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                        <polyline points="10 17 15 12 10 7"></polyline>
                        <line x1="15" y1="12" x2="3" y2="12"></line>
                      </svg> 
                      Login
                    </a>
                  </li>
                  <li><hr class="dropdown-divider border-secondary"></li>
                  <li>
                    <a class="dropdown-item sidebar-icon-link d-flex align-items-center gap-3 py-2" href="#" data-bs-toggle="modal" data-bs-target="#authModal" data-auth-tab="register">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <line x1="19" y1="8" x2="19" y2="14"></line>
                        <line x1="22" y1="11" x2="16" y2="11"></line>
                      </svg> 
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
    var desktopBtn = document.getElementById('themeToggleBtn');
    var mobileBtn = document.getElementById('themeToggleBtnMobile');
    
    var currentTheme = localStorage.getItem('site_theme') || 'dark';
    applyTheme(currentTheme);
    
    function toggleTheme() {
      currentTheme = currentTheme === 'dark' ? 'light' : 'dark';
      applyTheme(currentTheme);
      localStorage.setItem('site_theme', currentTheme);
    }
    
    if (desktopBtn) desktopBtn.addEventListener('click', toggleTheme);
    if (mobileBtn) mobileBtn.addEventListener('click', toggleTheme);
    
    function applyTheme(theme) {
      document.documentElement.setAttribute('data-bs-theme', theme);
      
      var sunIcons = [document.getElementById('themeIconSun'), document.getElementById('themeIconSunMobile')];
      var moonIcons = [document.getElementById('themeIconMoon'), document.getElementById('themeIconMoonMobile')];
      
      if (theme === 'dark') {
        sunIcons.forEach(function(i) { if(i) i.style.display = 'none'; });
        moonIcons.forEach(function(i) { if(i) i.style.display = 'block'; });
        document.body.style.backgroundColor = 'black';
        document.body.style.color = 'white';
      } else {
        sunIcons.forEach(function(i) { if(i) i.style.display = 'block'; });
        moonIcons.forEach(function(i) { if(i) i.style.display = 'none'; });
        document.body.style.backgroundColor = 'white';
        document.body.style.color = 'black';
      }
    }
  });
</script>

