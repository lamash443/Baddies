<!-- ══ AUTH MODAL ══ -->
<div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-fullscreen-md-down" style="max-width: 480px;">
    <div class="modal-content auth-modal-content border-0 shadow-lg" style="background:#000000; border: 1px solid rgba(255,140,0,0.5) !important; box-shadow: 0 0 40px rgba(255,140,0,0.25) !important;">
      
      <div class="modal-header border-0 pb-0 pt-4 px-4 px-md-5 position-relative">
        <!-- Optional Back Button (hidden by default) -->
        <button type="button" class="btn p-0 d-none auth-back-btn" id="authBackBtn" style="position:absolute; left: 1.5rem; top: 1.5rem; color: #ff8c00;">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        </button>

        <div class="d-flex align-items-center justify-content-center w-100 gap-2 fw-bold fs-4 text-center">
          <span style="color:#ff8c00;">Baddies-</span><span class="auth-brand-club" style="color:#fff;">Club</span>
        </div>
        <button type="button" class="btn-close btn-close-white opacity-75" data-bs-dismiss="modal" aria-label="Close" style="position:absolute; right: 1.5rem; top: 1.5rem;"></button>
      </div>
      
      <div class="modal-body px-4 px-md-5 pb-5 pt-3">
        <!-- Visible Tabs -->
        <ul class="nav nav-tabs border-0 mb-4" id="authTabs" role="tablist" style="gap:.5rem;">
          <li class="nav-item" role="presentation" style="flex:1;">
            <button class="nav-link active w-100 py-2 fw-bold auth-tab-btn" id="tab-login" data-bs-toggle="tab" data-bs-target="#pane-login" type="button">
              Login
            </button>
          </li>
          <li class="nav-item" role="presentation" style="flex:1;">
            <button class="nav-link w-100 py-2 fw-bold auth-tab-btn" id="tab-register" data-bs-toggle="tab" data-bs-target="#pane-register" type="button">
              Sign Up
            </button>
          </li>
        </ul>

        <style>
                    .auth-modal-content { border-radius: 1.5rem !important; }
          #authTabs .auth-tab-btn {
            border-radius: .6rem;
            font-size: 1.05rem;
            transition: all 0.3s ease;
          }
          #authTabs .auth-tab-btn.active {
            background: rgba(255,140,0,0.15) !important;
            border: 1px solid rgba(255,140,0,0.4) !important;
            color: #ff8c00 !important;
          }
          #authTabs .auth-tab-btn:not(.active) {
            background: rgba(255,255,255,0.03) !important;
            border: 1px solid rgba(255,255,255,0.1) !important;
            color: rgba(255,255,255,0.6) !important;
          }
          #authTabs .auth-tab-btn:not(.active):hover {
            background: rgba(255,255,255,0.08) !important;
            color: #fff !important;
          }
          @media (max-width: 767.98px) {
            .auth-modal-content { border-radius: 0 !important; border: none !important; }
          }
          .auth-custom-input {
            background: rgba(0,0,0,0.4) !important;
            border: 1px solid rgba(255,140,0,0.25) !important;
            color: #fff !important;
            border-radius: .75rem !important;
            padding: .6rem 1rem !important;
            font-size: 1rem !important;
            transition: all 0.3s ease;
          }
          .auth-custom-input:focus {
            border-color: #ff8c00 !important;
            box-shadow: 0 0 0 0.2rem rgba(255,140,0,0.2) !important;
            background: rgba(0,0,0,0.6) !important;
          }
          .auth-google-btn {
            background: transparent; color: #fff; font-weight: 700;
            border-radius: .75rem; border: 2px solid #ff8c00;
            font-size: 1rem;
            transition: all 0.3s ease;
          }
          .auth-google-btn:hover {
            background-color: #000000 !important;
            border-color: #ff8c00 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 15px rgba(255, 140, 0, 0.4) !important;
            transform: translateY(-1px);
          }
          .btn-orange-lg {
            background: #ff8c00; border: 2px solid #ff8c00;
            color: #000; font-weight: 700; font-size: 1rem;
            padding: .75rem 2rem; border-radius: .75rem;
            transition: all .3s ease; letter-spacing: .02em;
          }
          .btn-orange-lg:hover {
            background-color: #000000 !important;
            border-color: #ff8c00 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 15px rgba(255, 140, 0, 0.4) !important;
            transform: translateY(-1px);
          }
          .btn-outline-orange-lg {
            background: transparent; border: 2px solid #ff8c00;
            color: #fff; font-weight: 700; font-size: 1rem;
            padding: .75rem 2rem; border-radius: .75rem;
            transition: all .3s ease; letter-spacing: .02em;
          }
          .btn-outline-orange-lg:hover {
            background-color: #000000 !important;
            border-color: #ff8c00 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 15px rgba(255, 140, 0, 0.4) !important;
            transform: translateY(-1px);
          }
          .auth-title {
            font-size: 1.5rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 2rem;
            margin-top: 0.5rem;
          }
          .switch-link {
            color: #ff8c00;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: color 0.2s;
          }
          .switch-link:hover { color: #fff; }

          /* ── LIGHT THEME OVERRIDES ── */
          [data-bs-theme="light"] .auth-modal-content {
            background: #ffffff !important;
            border-color: rgba(0,0,0,0.1) !important;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08) !important;
          }
          [data-bs-theme="light"] #authBackBtn {
            color: #111 !important;
          }
          [data-bs-theme="light"] .auth-brand-club {
            color: #111 !important;
          }
          [data-bs-theme="light"] .btn-close-white {
            filter: invert(1) grayscale(100%) brightness(0) !important;
          }
          [data-bs-theme="light"] #authTabs .auth-tab-btn:not(.active) {
            background: rgba(0,0,0,0.03) !important;
            border-color: rgba(0,0,0,0.1) !important;
            color: rgba(0,0,0,0.6) !important;
          }
          [data-bs-theme="light"] #authTabs .auth-tab-btn:not(.active):hover {
            background: rgba(0,0,0,0.06) !important;
            color: #111 !important;
          }
          [data-bs-theme="light"] .auth-custom-input {
            background: #ffffff !important;
            border-color: rgba(0,0,0,0.2) !important;
            color: #111 !important;
          }
          [data-bs-theme="light"] .auth-custom-input:focus {
            background: #ffffff !important;
            border-color: #ff8c00 !important;
            box-shadow: 0 0 0 0.2rem rgba(255,140,0,0.2) !important;
          }
          [data-bs-theme="light"] .auth-google-btn {
            color: #111;
            border-color: rgba(0,0,0,0.2);
          }
          [data-bs-theme="light"] .auth-google-btn:hover {
            background-color: #f8f9fa !important;
            color: #111 !important;
            border-color: rgba(0,0,0,0.3) !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important;
            transform: translateY(-1px);
          }
          [data-bs-theme="light"] .btn-outline-orange-lg {
            color: #111;
            border-color: rgba(255,140,0,0.5);
          }
          [data-bs-theme="light"] .btn-outline-orange-lg:hover {
            background-color: rgba(255,140,0,0.1) !important;
            color: #ff8c00 !important;
            border-color: #ff8c00 !important;
            box-shadow: none !important;
          }
          [data-bs-theme="light"] .auth-title { color: #111; }
          [data-bs-theme="light"] .switch-link:hover { color: #111; }
          
          /* Override inline text colors */
          [data-bs-theme="light"] .auth-modal-content span[style*="color:rgba(255,255,255,0.4)"],
          [data-bs-theme="light"] .auth-modal-content span[style*="color:rgba(255,255,255,0.6)"],
          [data-bs-theme="light"] .auth-modal-content p[style*="color:rgba(255,255,255,0.6)"],
          [data-bs-theme="light"] .form-check-label.text-white-50 {
            color: rgba(0,0,0,0.6) !important;
          }
          [data-bs-theme="light"] .auth-modal-content span[style*="background:#000000;"] {
            background: #ffffff !important;
          }
        </style>

        <div class="tab-content">
          <!-- LOGIN PANE -->
          <div class="tab-pane fade show active" id="pane-login" role="tabpanel">
            
            <div id="login-step-1">
              <h2 class="auth-title">Welcome back</h2>
              
              <a href="/auth/google" class="btn auth-google-btn w-100 py-3 mb-4 d-flex align-items-center justify-content-center gap-2">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                Log in with Google
              </a>
              
              <div class="position-relative text-center mb-4">
                <hr style="border-color:rgba(255,140,0,0.2); margin:0;">
                <span class="position-absolute top-50 start-50 translate-middle px-3 fw-bold" style="background:#000000; color:rgba(255,255,255,0.4); font-size:.85rem; border-radius:1rem;">OR</span>
              </div>
              
              <button type="button" class="btn btn-outline-orange-lg w-100 mb-4" onclick="showEmailForm('login')">
                Log in with email and password
              </button>

              <div class="text-center mt-4 pt-2">
                <span style="color:rgba(255,255,255,0.6); font-size: .95rem;">Don't have an account?</span> 
                <span class="switch-link" onclick="switchAuthTab('register')">Sign up here</span>
              </div>
            </div>

            <div id="login-step-2" class="d-none">
              <h2 class="auth-title">Log in</h2>
              <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                  <label class="form-label small fw-bold mb-2" style="color:rgba(255,140,0,0.9); letter-spacing:.03em; text-transform:uppercase;">Email Address</label>
                  <input id="login-email" type="email" name="email" class="form-control auth-custom-input" value="{{ old('email') }}" required autofocus placeholder="Enter your email">
                </div>
                <div class="mb-3">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="form-label small fw-bold mb-0" style="color:rgba(255,140,0,0.9); letter-spacing:.03em; text-transform:uppercase;">Password</label>
                    @if (Route::has('password.request'))
                      <a href="{{ route('password.request') }}" class="small text-decoration-none switch-link" style="font-weight:600;">Forgot?</a>
                    @endif
                  </div>
                  <input id="login-password" type="password" name="password" class="form-control auth-custom-input" required placeholder="Enter your password">
                </div>
                <div class="mb-4">
                  <div class="form-check d-flex align-items-center gap-2">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input" style="border-color:rgba(255,140,0,0.5); background-color:transparent; width:1.1rem; height:1.1rem; margin-top:0;">
                    <label for="remember" class="form-check-label small text-white-50" style="font-size:.9rem;">Keep me logged in</label>
                  </div>
                </div>

                <button type="submit" class="btn btn-orange-lg w-100 shadow-sm">Log in</button>
              </form>
            </div>
          </div>

          <!-- REGISTER PANE -->
          <div class="tab-pane fade" id="pane-register" role="tabpanel">
            
            <div id="register-step-1">
              <h2 class="auth-title">Join Kenyan Baddies</h2>

              <a href="/auth/google" class="btn auth-google-btn w-100 py-3 mb-4 d-flex align-items-center justify-content-center gap-2">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                Sign up with Google
              </a>
              
              <div class="position-relative text-center mb-4">
                <hr style="border-color:rgba(255,140,0,0.2); margin:0;">
                <span class="position-absolute top-50 start-50 translate-middle px-3 fw-bold" style="background:#000000; color:rgba(255,255,255,0.4); font-size:.85rem; border-radius:1rem;">OR</span>
              </div>
              
              <button type="button" class="btn btn-outline-orange-lg w-100 mb-4" onclick="showEmailForm('register')">
                Sign up with email and password
              </button>

              <div class="mt-4 pt-2">
                <p class="text-center mb-2" style="color:rgba(255,255,255,0.6); font-size: .85rem; line-height: 1.5; max-width: 90%; margin: 0 auto;">
                  By signing up, you agree to the Terms and Conditions and Privacy Notice, including Cookie Use.
                </p>
                <div class="text-center mt-3">
                  <span style="color:rgba(255,255,255,0.6); font-size: .95rem;">Already have an account?</span> 
                  <span class="switch-link" onclick="switchAuthTab('login')">Login here</span>
                </div>
              </div>
            </div>

            <div id="register-step-2" class="d-none">
              <h2 class="auth-title">Create your account</h2>
              <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                  <label class="form-label small fw-bold mb-2" style="color:rgba(255,140,0,0.9); letter-spacing:.03em; text-transform:uppercase;">Full Name</label>
                  <input id="reg-name" type="text" name="name" class="form-control auth-custom-input" value="{{ old('name') }}" required placeholder="e.g. Jane Doe">
                  @error('name')<div class="small mt-1" style="color:#ff6b6b; font-weight:500;">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                  <label class="form-label small fw-bold mb-2" style="color:rgba(255,140,0,0.9); letter-spacing:.03em; text-transform:uppercase;">Email Address</label>
                  <input id="reg-email" type="email" name="email" class="form-control auth-custom-input" value="{{ old('email') }}" required placeholder="Enter a valid email">
                  @error('email')<div class="small mt-1" style="color:#ff6b6b; font-weight:500;">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                  <label class="form-label small fw-bold mb-2" style="color:rgba(255,140,0,0.9); letter-spacing:.03em; text-transform:uppercase;">Password</label>
                  <input id="reg-password" type="password" name="password" class="form-control auth-custom-input" required placeholder="Min 8 characters">
                  @error('password')<div class="small mt-1" style="color:#ff6b6b; font-weight:500;">{{ $message }}</div>@enderror
                </div>
                <div class="mb-4">
                  <label class="form-label small fw-bold mb-2" style="color:rgba(255,140,0,0.9); letter-spacing:.03em; text-transform:uppercase;">Confirm Password</label>
                  <input id="reg-password-confirm" type="password" name="password_confirmation" class="form-control auth-custom-input" required placeholder="Repeat password">
                </div>
                <button type="submit" class="btn btn-orange-lg w-100 shadow-sm">Sign Up</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  let currentAuthContext = 'login';
  
  function switchAuthTab(tab) {
    if(typeof bootstrap === 'undefined') return;
    var triggerEl = document.querySelector('#tab-' + tab);
    if (triggerEl) {
      new bootstrap.Tab(triggerEl).show();
      currentAuthContext = tab;
      resetAuthSteps();
    }
  }

  function showEmailForm(context) {
    document.getElementById(context + '-step-1').classList.add('d-none');
    document.getElementById(context + '-step-2').classList.remove('d-none');
    document.getElementById('authBackBtn').classList.remove('d-none');
  }

  function resetAuthSteps() {
    document.getElementById('login-step-1').classList.remove('d-none');
    document.getElementById('login-step-2').classList.add('d-none');
    document.getElementById('register-step-1').classList.remove('d-none');
    document.getElementById('register-step-2').classList.add('d-none');
    document.getElementById('authBackBtn').classList.add('d-none');
  }

  document.addEventListener("DOMContentLoaded", function() {
    // Back button logic
    var authBackBtn = document.getElementById('authBackBtn');
    if (authBackBtn) {
      authBackBtn.addEventListener('click', function() {
        resetAuthSteps();
      });
    }

    // Auth modal initial logic
    var authModalEl = document.getElementById('authModal');
    if (authModalEl && typeof bootstrap !== 'undefined') {
      authModalEl.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var tab = button ? button.getAttribute('data-auth-tab') : null;
        if (tab) {
          switchAuthTab(tab);
        } else {
          resetAuthSteps();
        }
      });

      // Handle server-side validation errors
      @if($errors->any())
        var modal = new bootstrap.Modal(authModalEl);
        modal.show();
        @if(old('name') || $errors->has('name'))
          switchAuthTab('register');
          showEmailForm('register');
        @else
          switchAuthTab('login');
          showEmailForm('login');
        @endif
      @endif
    }
  });
</script>

@if($errors->has('email') && !old('name'))
<style>
  .auth-err-toast {
    position: fixed; top: 5.5rem; right: 2rem; z-index: 1060; /* Above modal (1055) */
    display: flex; align-items: flex-start; gap: 0.85rem;
    background: #0d0d0d;
    border: 1px solid rgba(220,53,69,0.45);
    border-left: 4px solid #dc3545;
    border-radius: 14px;
    padding: 1rem 1.25rem;
    max-width: 360px; width: calc(100vw - 4rem);
    box-shadow: 0 20px 60px rgba(0,0,0,0.8), 0 0 0 1px rgba(255,255,255,0.04);
    font-family: "Outfit", ui-sans-serif, sans-serif;
    animation: authErrToastIn 0.45s cubic-bezier(0.34,1.56,0.64,1) both;
    overflow: hidden;
  }
  @keyframes authErrToastIn {
    from { opacity:0; transform: translateY(-20px) scale(0.93); }
    to   { opacity:1; transform: translateY(0) scale(1); }
  }
  .auth-err-toast__icon {
    flex-shrink:0; margin-top:2px;
    width:38px; height:38px; border-radius:11px;
    background:rgba(220,53,69,0.12); border:1px solid rgba(220,53,69,0.3);
    display:flex; align-items:center; justify-content:center; color:#ff4d4d;
  }
  .auth-err-toast__body { flex:1; min-width:0; }
  .auth-err-toast__title { font-size:.88rem; font-weight:700; color:#ff4d4d; margin:0 0 .2rem; line-height:1.2; }
  .auth-err-toast__msg   { font-size:.8rem;  color:rgba(255,255,255,.6); margin:0; line-height:1.5; }
  .auth-err-toast__close {
    flex-shrink:0; align-self:flex-start;
    background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.1);
    border-radius:7px; width:26px; height:26px;
    display:flex; align-items:center; justify-content:center;
    color:rgba(255,255,255,.45); cursor:pointer; padding:0; transition:all .2s;
  }
  .auth-err-toast__close:hover { background:rgba(220,53,69,.15); border-color:rgba(220,53,69,.35); color:#ff4d4d; }
  .auth-err-toast__bar {
    position:absolute; bottom:0; left:0; height:3px;
    background:linear-gradient(90deg,#dc3545,rgba(220,53,69,.1));
    border-radius:0 0 0 14px;
    animation:authErrToastBar 6s linear both;
  }
  @keyframes authErrToastBar { from{width:100%} to{width:0%} }
  
  /* ── LIGHT THEME OVERRIDES ── */
  [data-bs-theme="light"] .auth-err-toast { background: #ffffff; border-color: rgba(220,53,69,0.3); box-shadow: 0 10px 40px rgba(0,0,0,0.08); }
  [data-bs-theme="light"] .auth-err-toast__title { color: #dc3545; }
  [data-bs-theme="light"] .auth-err-toast__msg { color: rgba(0,0,0,0.7); }
  [data-bs-theme="light"] .auth-err-toast__close { background: rgba(0,0,0,0.04); border-color: rgba(0,0,0,0.08); color: rgba(0,0,0,0.5); }
  [data-bs-theme="light"] .auth-err-toast__close:hover { background: rgba(220,53,69,0.1); color: #dc3545; border-color: rgba(220,53,69,0.2); }
</style>
<div class="auth-err-toast" id="authErrToast" role="alert" aria-live="assertive">
  <div class="auth-err-toast__icon">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
      <circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line>
    </svg>
  </div>
  <div class="auth-err-toast__body">
    <p class="auth-err-toast__title">Login Failed</p>
    <p class="auth-err-toast__msg">{{ $errors->first('email') }}</p>
  </div>
  <button class="auth-err-toast__close" onclick="document.getElementById('authErrToast').remove();" aria-label="Dismiss">
    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
      <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
    </svg>
  </button>
  <div class="auth-err-toast__bar"></div>
</div>
<script>setTimeout(()=>{const t=document.getElementById('authErrToast');if(t)t.remove();},6000);</script>
@endif

{{-- ── SCROLL LOCK: disable body scroll when auth modal opens (works on mobile) ── --}}
<script>
(function () {
  var _scrollY = 0;

  function lockScroll() {
    _scrollY = window.scrollY || window.pageYOffset;
    document.body.style.position  = 'fixed';
    document.body.style.top       = '-' + _scrollY + 'px';
    document.body.style.left      = '0';
    document.body.style.right     = '0';
    document.body.style.overflowY = 'scroll';
  }

  function unlockScroll() {
    document.body.style.position  = '';
    document.body.style.top       = '';
    document.body.style.left      = '';
    document.body.style.right     = '';
    document.body.style.overflowY = '';
    window.scrollTo(0, _scrollY);
  }

  function attachScrollLock() {
    var modalEl = document.getElementById('authModal');
    if (!modalEl || modalEl.dataset.scrollLockAttached) return;
    modalEl.dataset.scrollLockAttached = '1';
    modalEl.addEventListener('show.bs.modal',   lockScroll);
    modalEl.addEventListener('hidden.bs.modal', unlockScroll);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', attachScrollLock);
  } else {
    attachScrollLock();
  }
})();
</script>
