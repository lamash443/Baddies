<!DOCTYPE html>
<html lang="en">
<head>
  <script>
    (function() {
      const theme = localStorage.getItem('theme') || 'dark';
      document.documentElement.setAttribute('data-bs-theme', theme);
    })();
  </script>
  <meta charset="utf-8">
  <x-site-favicon />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <title>Reset Password - Kenyan Baddies Club</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <style>
    *, *::before, *::after { box-sizing: border-box; }
    html, body {
      margin: 0; padding: 0;
      font-family: "Outfit", sans-serif;
      background: #000000;
      color: #fff;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* Input Styles */
    .auth-custom-input {
      background: rgba(0,0,0,0.4) !important;
      border: 1px solid rgba(255,140,0,0.25) !important;
      color: #fff !important;
      border-radius: .75rem !important;
      padding: .8rem 1rem !important;
      font-size: 1rem !important;
      transition: all 0.3s ease;
    }
    .auth-custom-input:focus {
      border-color: #ff8c00 !important;
      box-shadow: 0 0 0 0.2rem rgba(255,140,0,0.2) !important;
      background: rgba(0,0,0,0.6) !important;
    }
    .auth-custom-input::placeholder { color: rgba(255,255,255,0.35) !important; }

    /* Password toggle wrapper */
    .input-pw-wrap { position: relative; }
    .pw-toggle-btn {
      position: absolute; right: 1rem; top: 50%; transform: translateY(-50%);
      background: none; border: none; padding: 0; cursor: pointer;
      color: rgba(255,255,255,0.4); transition: color 0.2s;
    }
    .pw-toggle-btn:hover { color: #ff8c00; }

    /* Button */
    .btn-orange-lg {
      background: #ff8c00; border: 2px solid #ff8c00;
      color: #000; font-weight: 700; font-size: 1rem;
      padding: .8rem 2rem; border-radius: .75rem;
      transition: all .3s ease; letter-spacing: .02em;
    }
    .btn-orange-lg:hover {
      background-color: #000000 !important;
      border-color: #ff8c00 !important;
      color: #ffffff !important;
      box-shadow: 0 4px 15px rgba(255,140,0,0.4) !important;
      transform: translateY(-1px);
    }
    .btn-orange-lg:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

    /* Page wrapper */
    .auth-page-wrapper {
      flex: 1;
      display: flex; align-items: center; justify-content: center;
      padding: 4rem 1.5rem;
      position: relative; overflow: hidden;
    }
    .auth-page-bg {
      position: absolute; inset: 0;
      background: linear-gradient(160deg, #000000 0%, #1a0f00 40%, #000000 100%);
      z-index: 0;
    }
    /* Ambient glow blobs */
    .auth-page-bg::before {
      content: "";
      position: absolute; top: -80px; left: -80px;
      width: 320px; height: 320px;
      background: radial-gradient(circle, rgba(255,140,0,0.08) 0%, transparent 65%);
      pointer-events: none;
    }
    .auth-page-bg::after {
      content: "";
      position: absolute; bottom: -60px; right: -60px;
      width: 260px; height: 260px;
      background: radial-gradient(circle, rgba(255,80,0,0.06) 0%, transparent 65%);
      pointer-events: none;
    }

    /* Card */
    .auth-card {
      position: relative; z-index: 2;
      background: #111;
      border: 1px solid rgba(255,140,0,0.25);
      border-radius: 1.25rem;
      padding: 2.5rem;
      max-width: 480px; width: 100%;
      box-shadow: 0 10px 40px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,140,0,0.04) inset;
    }

    /* Lock icon */
    .lock-icon-badge {
      width: 60px; height: 60px; border-radius: 50%;
      background: rgba(255,140,0,0.08);
      border: 1.5px solid rgba(255,140,0,0.25);
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 1.25rem;
    }

    .auth-title {
      font-size: 1.65rem; font-weight: 800;
      color: #fff; margin-bottom: .6rem; text-align: center;
    }
    .auth-title span { color: #ff8c00; }
    .auth-desc {
      font-size: 0.9rem; color: rgba(255,255,255,0.55);
      text-align: center; margin-bottom: 2rem; line-height: 1.6;
    }

    /* Field label */
    .field-label {
      font-size: 0.78rem; font-weight: 700;
      color: rgba(255,140,0,0.9);
      letter-spacing: .04em; text-transform: uppercase;
      margin-bottom: .5rem; display: block;
    }

    /* Password strength bar */
    .pw-strength-wrap { margin-top: 8px; }
    .pw-strength-bar-bg {
      height: 4px; border-radius: 99px;
      background: rgba(255,255,255,0.08);
      overflow: hidden;
    }
    .pw-strength-bar {
      height: 100%; border-radius: 99px;
      width: 0%; transition: width 0.4s ease, background 0.4s ease;
    }
    .pw-strength-label {
      font-size: 0.72rem; margin-top: 4px;
      color: rgba(255,255,255,0.4);
      transition: color 0.3s;
    }

    /* Back arrow */
    .auth-back-arrow {
      position: absolute; left: 1.5rem; top: 1.5rem;
      color: #ff8c00; transition: color 0.3s ease, transform 0.2s ease;
      background: transparent; border: none; padding: 0; z-index: 10;
    }
    .auth-back-arrow:hover { color: #fff; transform: translateX(-2px); }

    /* LIGHT THEME */
    [data-bs-theme="light"] body { background: #f4f6f9; color: #111; }
    [data-bs-theme="light"] .auth-page-bg { background: linear-gradient(160deg, #f4f6f9 0%, #fff4e6 40%, #f4f6f9 100%); }
    [data-bs-theme="light"] .auth-card { background: #ffffff; border-color: rgba(255,140,0,0.3); box-shadow: 0 10px 40px rgba(0,0,0,0.08); }
    [data-bs-theme="light"] .auth-title { color: #111; }
    [data-bs-theme="light"] .auth-desc { color: rgba(0,0,0,0.55); }
    [data-bs-theme="light"] .auth-custom-input { background: rgba(0,0,0,0.04) !important; color: #111 !important; }
    [data-bs-theme="light"] .auth-custom-input::placeholder { color: rgba(0,0,0,0.3) !important; }
    [data-bs-theme="light"] .pw-toggle-btn { color: rgba(0,0,0,0.35); }
    [data-bs-theme="light"] .pw-toggle-btn:hover { color: #ff8c00; }
    [data-bs-theme="light"] .auth-back-arrow:hover { color: #111; }
    [data-bs-theme="light"] .pw-strength-label { color: rgba(0,0,0,0.45); }
  </style>
</head>
<body>

<x-navbar :hideSearch="true" />

<div class="auth-page-wrapper">
  <div class="auth-page-bg"></div>

  <div class="auth-card">
    <!-- Back arrow -->
    <a href="{{ route('password.request') }}" class="auth-back-arrow" title="Back">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
      </svg>
    </a>

    <!-- Lock icon -->
    <div class="lock-icon-badge">
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#ff8c00" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
      </svg>
    </div>

    <h1 class="auth-title">Set New <span>Password</span></h1>
    <p class="auth-desc">Choose a strong password for your account. Make it at least 8 characters long.</p>

    <form method="POST" action="{{ route('password.store') }}" id="resetPwForm">
      @csrf
      <input type="hidden" name="token" value="{{ $request->route('token') }}">

      {{-- Email --}}
      <div class="mb-3">
        <label class="field-label" for="email">Email Address</label>
        <input
          id="email"
          class="form-control auth-custom-input"
          type="email"
          name="email"
          value="{{ old('email', $request->email) }}"
          required autofocus autocomplete="username"
          placeholder="your@email.com"
        >
        @error('email')
          <div class="small mt-1" style="color:#ff6b6b; font-weight:500;">{{ $message }}</div>
        @enderror
      </div>

      {{-- New Password --}}
      <div class="mb-3">
        <label class="field-label" for="password">New Password</label>
        <div class="input-pw-wrap">
          <input
            id="password"
            class="form-control auth-custom-input pe-5"
            type="password"
            name="password"
            required autocomplete="new-password"
            placeholder="Min. 8 characters"
            oninput="checkStrength(this.value)"
          >
          <button type="button" class="pw-toggle-btn" onclick="togglePw('password', this)" tabindex="-1" aria-label="Show password">
            <svg class="eye-open" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            <svg class="eye-closed" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
          </button>
        </div>
        <!-- Strength bar -->
        <div class="pw-strength-wrap">
          <div class="pw-strength-bar-bg"><div class="pw-strength-bar" id="pwStrengthBar"></div></div>
          <p class="pw-strength-label" id="pwStrengthLabel">Enter a password</p>
        </div>
        @error('password')
          <div class="small mt-1" style="color:#ff6b6b; font-weight:500;">{{ $message }}</div>
        @enderror
      </div>

      {{-- Confirm Password --}}
      <div class="mb-4">
        <label class="field-label" for="password_confirmation">Confirm Password</label>
        <div class="input-pw-wrap">
          <input
            id="password_confirmation"
            class="form-control auth-custom-input pe-5"
            type="password"
            name="password_confirmation"
            required autocomplete="new-password"
            placeholder="Re-enter your password"
          >
          <button type="button" class="pw-toggle-btn" onclick="togglePw('password_confirmation', this)" tabindex="-1" aria-label="Show confirm password">
            <svg class="eye-open" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            <svg class="eye-closed" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
          </button>
        </div>
        @error('password_confirmation')
          <div class="small mt-1" style="color:#ff6b6b; font-weight:500;">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="btn btn-orange-lg w-100 shadow-sm" id="resetBtn">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="me-2">
          <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
        </svg>
        Reset Password
      </button>

      <p class="text-center mt-3 mb-0" style="font-size:0.85rem; color:rgba(255,255,255,0.4);">
        Remembered it?
        <a href="{{ route('login') }}" style="color:#ff8c00; text-decoration:none; font-weight:600;">Sign In</a>
      </p>
    </form>
  </div>
</div>

<x-footer />

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<x-auth-modal />

<script>
  // Password visibility toggle
  function togglePw(id, btn) {
    const input = document.getElementById(id);
    const isText = input.type === 'text';
    input.type = isText ? 'password' : 'text';
    btn.querySelector('.eye-open').style.display  = isText ? '' : 'none';
    btn.querySelector('.eye-closed').style.display = isText ? 'none' : '';
  }

  // Password strength checker
  function checkStrength(val) {
    const bar   = document.getElementById('pwStrengthBar');
    const label = document.getElementById('pwStrengthLabel');
    let score = 0;
    if (val.length >= 8)                          score++;
    if (/[A-Z]/.test(val))                        score++;
    if (/[0-9]/.test(val))                        score++;
    if (/[^A-Za-z0-9]/.test(val))                score++;

    const levels = [
      { pct: '0%',   color: 'transparent',         text: 'Enter a password',      labelColor: 'rgba(255,255,255,0.4)' },
      { pct: '25%',  color: '#ef4444',              text: 'Weak',                  labelColor: '#ef4444' },
      { pct: '50%',  color: '#f97316',              text: 'Fair',                  labelColor: '#f97316' },
      { pct: '75%',  color: '#eab308',              text: 'Good',                  labelColor: '#eab308' },
      { pct: '100%', color: '#22c55e',              text: 'Strong ✓',              labelColor: '#22c55e' },
    ];
    const lvl = val.length === 0 ? levels[0] : levels[score];
    bar.style.width      = lvl.pct;
    bar.style.background = lvl.color;
    label.textContent    = lvl.text;
    label.style.color    = lvl.labelColor;
  }

  // Loading state on submit
  document.getElementById('resetPwForm').addEventListener('submit', function() {
    const btn = document.getElementById('resetBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span> Resetting...';
  });
</script>

@if($errors->any() && !$errors->has('email') && !$errors->has('password') && !$errors->has('password_confirmation'))
<style>
  .err-toast { position:fixed; top:5.5rem; right:2rem; z-index:1060; display:flex; align-items:flex-start; gap:.85rem; background:#0d0d0d; border:1px solid rgba(220,53,69,.45); border-left:4px solid #dc3545; border-radius:14px; padding:1rem 1.25rem; max-width:360px; width:calc(100vw - 4rem); box-shadow:0 20px 60px rgba(0,0,0,.8); font-family:"Outfit",sans-serif; animation:errIn .45s cubic-bezier(.34,1.56,.64,1) both; overflow:hidden; }
  @keyframes errIn { from{opacity:0;transform:translateY(-20px) scale(.93)} to{opacity:1;transform:translateY(0) scale(1)} }
  .err-toast__icon { flex-shrink:0; margin-top:2px; width:38px; height:38px; border-radius:11px; background:rgba(220,53,69,.12); border:1px solid rgba(220,53,69,.3); display:flex; align-items:center; justify-content:center; color:#ff4d4d; }
  .err-toast__body { flex:1; min-width:0; }
  .err-toast__title { font-size:.88rem; font-weight:700; color:#ff4d4d; margin:0 0 .2rem; }
  .err-toast__msg   { font-size:.8rem; color:rgba(255,255,255,.6); margin:0; line-height:1.5; }
  .err-toast__bar { position:absolute; bottom:0; left:0; height:3px; background:linear-gradient(90deg,#dc3545,rgba(220,53,69,.1)); border-radius:0 0 0 14px; animation:errBar 6s linear both; }
  @keyframes errBar { from{width:100%} to{width:0%} }
</style>
<div class="err-toast" id="genErrToast">
  <div class="err-toast__icon">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
  </div>
  <div class="err-toast__body">
    <p class="err-toast__title">Something went wrong</p>
    <p class="err-toast__msg">{{ $errors->first() }}</p>
  </div>
  <div class="err-toast__bar"></div>
</div>
<script>setTimeout(()=>{const t=document.getElementById('genErrToast');if(t)t.remove();},6000);</script>
@endif

</body>
</html>

