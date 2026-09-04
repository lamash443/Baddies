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
          .pwd-req {
            color: rgba(255,255,255,0.4);
            transition: color 0.3s ease;
          }
          .pwd-req svg {
            opacity: 0.3;
            transition: opacity 0.3s ease, color 0.3s ease;
          }
          .pwd-req.valid {
            color: #198754 !important;
          }
          .pwd-req.valid svg {
            opacity: 1;
            color: #198754;
          }
          [data-bs-theme="light"] .pwd-req {
            color: rgba(0,0,0,0.5);
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
                  <input id="reg-name" type="text" name="name" class="form-control auth-custom-input" value="{{ old('name') }}" required placeholder="Enter your name">
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
                  <div class="mt-2 d-none" id="password-strength-container">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                      <span class="small fw-bold" id="password-strength-text" style="font-size: 0.75rem; letter-spacing: 0.02em;">Password Strength</span>
                    </div>
                    <div class="progress mb-2" style="height: 4px; background-color: rgba(255,255,255,0.1); border-radius: 2px;">
                      <div id="password-strength-bar" class="progress-bar" role="progressbar" style="width: 0%; transition: width 0.3s ease, background-color 0.3s ease;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="small" style="font-size: 0.75rem;">
                      <ul class="list-unstyled mb-0" style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px;">
                        <li id="req-length" class="pwd-req"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="me-1"><polyline points="20 6 9 17 4 12"></polyline></svg>8+ characters</li>
                        <li id="req-upper" class="pwd-req"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="me-1"><polyline points="20 6 9 17 4 12"></polyline></svg>Uppercase</li>
                        <li id="req-lower" class="pwd-req"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="me-1"><polyline points="20 6 9 17 4 12"></polyline></svg>Lowercase</li>
                        <li id="req-number" class="pwd-req"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="me-1"><polyline points="20 6 9 17 4 12"></polyline></svg>Number/Symbol</li>
                      </ul>
                    </div>
                  </div>
                  @error('password')<div class="small mt-1" style="color:#ff6b6b; font-weight:500;">{{ $message }}</div>@enderror
                </div>
                <div class="mb-4">
                  <label class="form-label small fw-bold mb-2" style="color:rgba(255,140,0,0.9); letter-spacing:.03em; text-transform:uppercase;">Confirm Password</label>
                  <input id="reg-password-confirm" type="password" name="password_confirmation" class="form-control auth-custom-input" required placeholder="Repeat password">
                </div>
                <button type="submit" id="reg-submit-btn" class="btn btn-orange-lg w-100 shadow-sm" disabled style="opacity: 0.6; cursor: not-allowed;">Sign Up</button>
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

      // Handle opening modal via URL parameter
      var urlParams = new URLSearchParams(window.location.search);
      if (urlParams.has('auth')) {
        var authTab = urlParams.get('auth');
        var modal = new bootstrap.Modal(authModalEl);
        modal.show();
        if (authTab === 'register') {
          switchAuthTab('register');
          showEmailForm('register');
        } else {
          switchAuthTab('login');
          showEmailForm('login');
        }
        var newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
        window.history.replaceState({path: newUrl}, '', newUrl);
      }

      @if($errors->any() && !in_array(request()->route()->getName(), ['password.request', 'password.reset']))
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

  // Password strength logic
  document.addEventListener("DOMContentLoaded", function() {
    const passwordInput = document.getElementById('reg-password');
    const strengthContainer = document.getElementById('password-strength-container');
    const strengthText = document.getElementById('password-strength-text');
    const strengthBar = document.getElementById('password-strength-bar');
    const submitBtn = document.getElementById('reg-submit-btn');
    
    const reqLength = document.getElementById('req-length');
    const reqUpper = document.getElementById('req-upper');
    const reqLower = document.getElementById('req-lower');
    const reqNumber = document.getElementById('req-number');

    function updateRequirement(el, isValid) {
      if (!el) return;
      if (isValid) {
        el.classList.add('valid');
      } else {
        el.classList.remove('valid');
      }
    }

    if (passwordInput && strengthContainer && strengthText && strengthBar && submitBtn) {
      passwordInput.addEventListener('input', function() {
        const val = passwordInput.value;
        if (val.length > 0) {
          strengthContainer.classList.remove('d-none');
        } else {
          strengthContainer.classList.add('d-none');
          submitBtn.disabled = true;
          submitBtn.style.opacity = '0.6';
          submitBtn.style.cursor = 'not-allowed';
          return;
        }

        let strength = 0;
        
        const hasLength = val.length >= 8;
        const hasLower = /[a-z]/.test(val);
        const hasUpper = /[A-Z]/.test(val);
        const hasNumberOrSymbol = /[0-9]/.test(val) || /[$@#&!%*?]/.test(val);

        updateRequirement(reqLength, hasLength);
        updateRequirement(reqLower, hasLower);
        updateRequirement(reqUpper, hasUpper);
        updateRequirement(reqNumber, hasNumberOrSymbol);

        const allValid = hasLength && hasLower && hasUpper && hasNumberOrSymbol;
        
        if (allValid) {
          submitBtn.disabled = false;
          submitBtn.style.opacity = '1';
          submitBtn.style.cursor = 'pointer';
        } else {
          submitBtn.disabled = true;
          submitBtn.style.opacity = '0.6';
          submitBtn.style.cursor = 'not-allowed';
        }

        if (hasLength) strength += 25;
        if (hasLower) strength += 25;
        if (hasUpper) strength += 25;
        if (hasNumberOrSymbol) strength += 25;

        strengthBar.style.width = strength + '%';
        strengthBar.setAttribute('aria-valuenow', strength);
        
        strengthBar.classList.remove('bg-danger', 'bg-warning', 'bg-info', 'bg-success');

        if (strength <= 25) {
          strengthBar.classList.add('bg-danger');
          strengthText.textContent = 'Weak';
          strengthText.style.color = '#dc3545';
        } else if (strength <= 50) {
          strengthBar.classList.add('bg-warning');
          strengthText.textContent = 'Fair';
          strengthText.style.color = '#ffc107';
        } else if (strength <= 75) {
          strengthBar.classList.add('bg-info');
          strengthText.textContent = 'Good';
          strengthText.style.color = '#0dcaf0';
        } else {
          strengthBar.classList.add('bg-success');
          strengthText.textContent = 'Strong';
          strengthText.style.color = '#198754';
        }
      });
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

{{-- ══ CHAT GUEST TOAST + openChatGuestFlow() ══ --}}
<style>
  /* ── Premium Chat Lock Toast ── */
  .chat-lock-toast {
    position: fixed;
    top: 5.5rem; right: 1.5rem;
    z-index: 2000;
    display: flex; align-items: flex-start; gap: 0.9rem;
    background: #0a0a0a;
    border: 1px solid rgba(255,140,0,0.35);
    border-left: 4px solid #ff8c00;
    border-radius: 16px;
    padding: 1rem 1.15rem 1rem 1rem;
    max-width: 370px; width: calc(100vw - 3rem);
    box-shadow: 0 24px 64px rgba(0,0,0,0.85), 0 0 0 1px rgba(255,255,255,0.04), 0 0 30px rgba(255,140,0,0.08);
    font-family: "Outfit", ui-sans-serif, sans-serif;
    animation: chatLockToastIn 0.5s cubic-bezier(0.34,1.56,0.64,1) both;
    overflow: hidden;
    pointer-events: auto;
  }
  @keyframes chatLockToastIn {
    from { opacity: 0; transform: translateX(60px) scale(0.92); }
    to   { opacity: 1; transform: translateX(0) scale(1); }
  }
  .chat-lock-toast.removing {
    animation: chatLockToastOut 0.35s ease-in both;
  }
  @keyframes chatLockToastOut {
    from { opacity: 1; transform: translateX(0) scale(1); }
    to   { opacity: 0; transform: translateX(60px) scale(0.9); }
  }
  .chat-lock-toast__icon {
    flex-shrink: 0;
    width: 42px; height: 42px; border-radius: 12px;
    background: rgba(255,140,0,0.1);
    border: 1px solid rgba(255,140,0,0.3);
    display: flex; align-items: center; justify-content: center;
    color: #ff8c00;
  }
  .chat-lock-toast__body { flex: 1; min-width: 0; }
  .chat-lock-toast__badge {
    display: inline-flex; align-items: center; gap: 0.3rem;
    font-size: 0.68rem; font-weight: 700; letter-spacing: 0.08em;
    text-transform: uppercase; color: #ff8c00;
    background: rgba(255,140,0,0.12);
    border: 1px solid rgba(255,140,0,0.25);
    border-radius: 20px; padding: 0.15rem 0.55rem;
    margin-bottom: 0.35rem;
  }
  .chat-lock-toast__title {
    font-size: 0.93rem; font-weight: 800; color: #fff;
    margin: 0 0 0.2rem; line-height: 1.25;
  }
  .chat-lock-toast__msg {
    font-size: 0.8rem; color: rgba(255,255,255,0.6);
    margin: 0 0 0.6rem; line-height: 1.5;
  }
  .chat-lock-toast__action {
    display: inline-flex; align-items: center; gap: 0.3rem;
    font-size: 0.78rem; font-weight: 700; color: #ff8c00;
    text-decoration: none; cursor: pointer; background: none; border: none;
    padding: 0; transition: color 0.2s;
  }
  .chat-lock-toast__action:hover { color: #fff; }
  .chat-lock-toast__close {
    flex-shrink: 0; align-self: flex-start;
    background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
    border-radius: 8px; width: 26px; height: 26px;
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,0.4); cursor: pointer; padding: 0;
    transition: all 0.2s;
  }
  .chat-lock-toast__close:hover { background: rgba(255,140,0,0.15); border-color: rgba(255,140,0,0.35); color: #ff8c00; }
  .chat-lock-toast__bar {
    position: absolute; bottom: 0; left: 0; height: 3px;
    background: linear-gradient(90deg, #ff8c00, rgba(255,140,0,0.15));
    border-radius: 0 0 0 16px;
    animation: chatLockToastBar 5s linear both;
  }
  @keyframes chatLockToastBar { from { width: 100%; } to { width: 0%; } }

  /* Light theme */
  [data-bs-theme="light"] .chat-lock-toast {
    background: #ffffff;
    border-color: rgba(255,140,0,0.3);
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
  }
  [data-bs-theme="light"] .chat-lock-toast__title { color: #111; }
  [data-bs-theme="light"] .chat-lock-toast__msg   { color: rgba(0,0,0,0.6); }
  [data-bs-theme="light"] .chat-lock-toast__close { background: rgba(0,0,0,0.04); border-color: rgba(0,0,0,0.08); color: rgba(0,0,0,0.4); }
  [data-bs-theme="light"] .chat-lock-toast__close:hover { background: rgba(255,140,0,0.1); color: #ff8c00; border-color: rgba(255,140,0,0.25); }
</style>

<script>
(function() {
  var _toastTimer = null;
  var _toastEl    = null;

  function removeChatToast() {
    if (!_toastEl) return;
    _toastEl.classList.add('removing');
    setTimeout(function() {
      if (_toastEl && _toastEl.parentNode) _toastEl.parentNode.removeChild(_toastEl);
      _toastEl = null;
    }, 380);
    if (_toastTimer) { clearTimeout(_toastTimer); _toastTimer = null; }
  }

  function showChatGuestToast() {
    // Remove any existing toast first
    if (_toastEl) removeChatToast();

    var toast = document.createElement('div');
    toast.className = 'chat-lock-toast';
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.innerHTML = [
      '<div class="chat-lock-toast__icon">',
        '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">',
          '<rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>',
          '<path d="M7 11V7a5 5 0 0 1 10 0v4"/>',
        '</svg>',
      '</div>',
      '<div class="chat-lock-toast__body">',
        '<div class="chat-lock-toast__badge">',
          '<svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a5 5 0 0 1 5 5v2H7V7a5 5 0 0 1 5-5zm7 9H5a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2z"/></svg>',
          'Members Only',
        '</div>',
        '<p class="chat-lock-toast__title">Login Required to Chat</p>',
        '<p class="chat-lock-toast__msg">You need to be logged in with an active chat plan to message members. Join now to unlock private messaging.</p>',
        '<button class="chat-lock-toast__action" onclick="openAuthModalNow(); removeChatToastPublic();">',
          '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3"/></svg>',
          'Sign In Now &rarr;',
        '</button>',
      '</div>',
      '<button class="chat-lock-toast__close" onclick="removeChatToastPublic();" aria-label="Dismiss">',
        '<svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">',
          '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>',
        '</svg>',
      '</button>',
      '<div class="chat-lock-toast__bar"></div>',
    ].join('');

    document.body.appendChild(toast);
    _toastEl = toast;

    // Auto-dismiss after 5s (matches bar animation)
    _toastTimer = setTimeout(removeChatToast, 5200);
  }

  function openAuthModalNow() {
    var modalEl = document.getElementById('authModal');
    if (modalEl && typeof bootstrap !== 'undefined') {
      var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
      modal.show();
      if (typeof switchAuthTab === 'function') switchAuthTab('login');
    }
  }

  // Global entry-point: show toast, then open auth modal after a short delay
  window.openChatGuestFlow = function() {
    showChatGuestToast();
    setTimeout(openAuthModalNow, 650);
  };

  // Exposed so inline onclick inside toast can call it
  window.removeChatToastPublic = function() { removeChatToast(); };
  window.openAuthModalNow      = openAuthModalNow;

  // Real-time emoji disallow on all modal login and sign up inputs
  document.addEventListener('input', function(e) {
    if (e.target && (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA')) {
      var emojiRegex = /[\u{1F600}-\u{1F64F}\u{1F300}-\u{1F5FF}\u{1F680}-\u{1F6FF}\u{1F700}-\u{1F7FF}\u{1F800}-\u{1F8FF}\u{1F900}-\u{1F9FF}\u{1FA00}-\u{1FA6F}\u{1FA70}-\u{1FAFF}\u{2600}-\u{26FF}\u{2700}-\u{27BF}\u{2300}-\u{23FF}\u{2B50}\u{2B55}\u{203C}\u{2049}\u{2122}\u{2139}\u{2194}-\u{2199}\u{21A9}-\u{21AA}\u{231A}-\u{231B}\u{23E9}-\u{23EC}\u{23F0}\u{23F3}\u{25AA}-\u{25AB}\u{25FB}-\u{25FE}\u{2614}-\u{2615}\u{2648}-\u{2653}\u{267F}\u{2693}\u{26A1}\u{26AA}-\u{26AB}\u{26BD}-\u{26BE}\u{26C4}-\u{26C5}\u{26CE}\u{26D4}\u{26EA}\u{26F2}-\u{26F3}\u{26F5}\u{26FA}\u{26FD}\u{2702}\u{2705}\u{2708}-\u{270D}\u{270F}\u{2712}\u{2714}\u{2716}\u{271D}\u{2721}\u{2728}\u{2733}-\u{2734}\u{2744}\u{2747}\u{274C}\u{274E}\u{2753}-\u{2755}\u{2757}\u{2763}-\u{2764}\u{2795}-\u{2797}\u{27A1}\u{27B0}\u{27BF}\u{2934}-\u{2935}\u{2B05}-\u{2B07}\u{3030}\u{303D}\u{3297}\u{3299}]/gu;
      if (emojiRegex.test(e.target.value)) {
        e.target.value = e.target.value.replace(emojiRegex, '');
      }
    }
  }, true);
})();
</script>
