<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Create Account - Kenyan Baddies Club</title>
  <meta name="description" content="Join Kenyan Baddies Club. Create your account today.">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; }
    html, body {
      margin: 0; padding: 0;
      font-family: "Outfit", sans-serif;
      background: #0a0a0a;
      color: #fff;
      min-height: 100vh;
      display: flex; align-items: center; justify-content: center;
    }

    /* Radial glow background */
    body::before {
      content: '';
      position: fixed; inset: 0; z-index: 0;
      background:
        radial-gradient(ellipse 70% 50% at 30% 10%, rgba(255,140,0,0.07) 0%, transparent 55%),
        radial-gradient(ellipse 60% 50% at 75% 90%, rgba(255,140,0,0.05) 0%, transparent 60%);
      pointer-events: none;
    }
    .bg-grid {
      position: fixed; inset: 0; z-index: 0;
      background-size: 44px 44px;
      background-image:
        linear-gradient(to right, rgba(255,140,0,0.04) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(255,140,0,0.04) 1px, transparent 1px);
      mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 20%, transparent 80%);
      -webkit-mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 20%, transparent 80%);
      pointer-events: none;
    }

    /* Card — exact same as auth modal */
    .auth-page-wrap {
      position: relative; z-index: 1;
      width: 100%; max-width: 480px;
      padding: 1rem;
    }
    .auth-page-card {
      background: #000000;
      border: 1px solid rgba(255,140,0,0.5) !important;
      box-shadow: 0 0 40px rgba(255,140,0,0.25) !important;
      border-radius: 1.5rem;
      padding: 2rem 2rem 2.5rem;
      animation: cardIn 0.5s cubic-bezier(0.34,1.56,0.64,1) forwards;
    }
    @keyframes cardIn {
      from { opacity: 0; transform: translateY(28px) scale(0.97); }
      to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* Header */
    .auth-header {
      display: flex; align-items: center; justify-content: center;
      position: relative; margin-bottom: 1.25rem;
    }
    .auth-brand {
      font-size: 1.5rem; font-weight: 800; letter-spacing: -0.01em;
    }
    .auth-brand .orange { color: #ff8c00; }
    .auth-brand .white  { color: #fff; }
    .auth-back-link {
      position: absolute; left: 0;
      color: rgba(255,255,255,0.45); text-decoration: none;
      font-size: 0.82rem; font-weight: 600; display: flex; align-items: center; gap: 0.3rem;
      transition: color 0.2s;
    }
    .auth-back-link:hover { color: #ff8c00; }

    /* Title */
    .auth-title {
      font-size: 1.5rem; font-weight: 800;
      text-align: center; margin-bottom: 1.75rem; margin-top: 0.5rem;
    }

    /* Referral badge */
    .referral-badge {
      display: flex; align-items: flex-start; gap: 0.6rem;
      background: rgba(255,140,0,0.1); border: 1px solid rgba(255,140,0,0.3);
      border-radius: 0.75rem; padding: 0.7rem 1rem;
      font-size: 0.82rem; color: #ffb347; font-weight: 500;
      margin-bottom: 1.25rem; line-height: 1.4;
    }
    .referral-badge svg { flex-shrink: 0; margin-top: 1px; }

    /* Inputs — exact match */
    .auth-label {
      display: block;
      font-size: 0.75rem; font-weight: 700;
      color: rgba(255,140,0,0.9);
      letter-spacing: 0.03em; text-transform: uppercase;
      margin-bottom: 0.5rem;
    }
    .auth-custom-input {
      display: block; width: 100%;
      background: rgba(0,0,0,0.4) !important;
      border: 1px solid rgba(255,140,0,0.25) !important;
      color: #fff !important;
      border-radius: 0.75rem !important;
      padding: 0.6rem 1rem !important;
      font-size: 1rem !important;
      font-family: "Outfit", sans-serif;
      transition: all 0.3s ease;
      outline: none;
    }
    .auth-custom-input:focus {
      border-color: #ff8c00 !important;
      box-shadow: 0 0 0 0.2rem rgba(255,140,0,0.2) !important;
      background: rgba(0,0,0,0.6) !important;
    }
    .auth-custom-input::placeholder { color: rgba(255,255,255,0.25); }
    .field-error { font-size: 0.8rem; color: #ff6b6b; font-weight: 500; margin-top: 0.3rem; }

    /* Password input wrap for toggle */
    .input-wrap { position: relative; }
    .pw-toggle-btn {
      position: absolute; right: 0.85rem; top: 50%;
      transform: translateY(-50%);
      background: none; border: none; cursor: pointer;
      color: rgba(255,255,255,0.3); padding: 0; display: flex;
      transition: color 0.2s;
    }
    .pw-toggle-btn:hover { color: #ff8c00; }

    /* Password strength */
    .pwd-req { color: rgba(255,255,255,0.4); transition: color 0.3s ease; }
    .pwd-req svg { opacity: 0.3; transition: opacity 0.3s ease, color 0.3s ease; }
    .pwd-req.valid { color: #198754 !important; }
    .pwd-req.valid svg { opacity: 1; color: #198754; }

    /* Submit button — exact match to btn-orange-lg */
    .btn-orange-lg {
      display: block; width: 100%;
      background: #ff8c00; border: 2px solid #ff8c00;
      color: #000; font-weight: 700; font-size: 1rem;
      padding: 0.75rem 2rem; border-radius: 0.75rem;
      transition: all 0.3s ease; letter-spacing: 0.02em;
      font-family: "Outfit", sans-serif; cursor: pointer;
    }
    .btn-orange-lg:hover {
      background-color: #000000 !important;
      border-color: #ff8c00 !important;
      color: #ffffff !important;
      box-shadow: 0 4px 15px rgba(255,140,0,0.4) !important;
      transform: translateY(-1px);
    }
    .btn-orange-lg:disabled {
      opacity: 0.6; cursor: not-allowed; transform: none !important;
      box-shadow: none !important;
    }

    /* Divider */
    .or-divider {
      position: relative; text-align: center; margin: 1.25rem 0;
    }
    .or-divider hr { border-color: rgba(255,140,0,0.2); margin: 0; }
    .or-divider span {
      position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
      background: #000; padding: 0 0.75rem;
      color: rgba(255,255,255,0.4); font-size: 0.82rem; font-weight: 700;
      border-radius: 1rem;
    }

    /* Back link bottom */
    .auth-footer { text-align: center; margin-top: 1.25rem; font-size: 0.9rem; }
    .auth-footer a {
      color: #ff8c00; font-weight: 700; text-decoration: none;
      cursor: pointer; transition: color 0.2s;
    }
    .auth-footer a:hover { color: #fff; }
    .auth-footer span { color: rgba(255,255,255,0.6); }

    /* Light mode support */
    [data-bs-theme="light"] body { background: #f4f6f9; }
    [data-bs-theme="light"] body::before { opacity: 0.5; }
    [data-bs-theme="light"] .auth-page-card { background: #fff !important; border-color: rgba(0,0,0,0.1) !important; box-shadow: 0 10px 40px rgba(0,0,0,0.08) !important; }
    [data-bs-theme="light"] .auth-brand .white { color: #111; }
    [data-bs-theme="light"] .auth-title { color: #111; }
    [data-bs-theme="light"] .auth-custom-input { background: #fff !important; border-color: rgba(0,0,0,0.2) !important; color: #111 !important; }
    [data-bs-theme="light"] .auth-custom-input:focus { background: #fff !important; }
    [data-bs-theme="light"] .or-divider span { background: #fff; color: rgba(0,0,0,0.45); }
    [data-bs-theme="light"] .auth-footer span { color: rgba(0,0,0,0.6); }
    [data-bs-theme="light"] .pwd-req { color: rgba(0,0,0,0.5); }
  </style>
</head>
<body>
@php
  $siteLogo = \App\Models\SiteSetting::get('logo');
  $refCode  = request()->query('ref') ?? session('ref_code');
  $referrer = $refCode ? \App\Models\User::where('referral_code', trim($refCode))->first() : null;
@endphp

<div class="bg-grid"></div>

<div class="auth-page-wrap">
  <div class="auth-page-card">

    {{-- Header --}}
    <div class="auth-header">
      <a href="{{ url('/') }}" class="auth-back-link">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Home
      </a>
      <a href="{{ url('/') }}" style="text-decoration:none;">
        @if(!empty($siteLogo))
          <img src="{{ asset('storage/' . $siteLogo) }}" alt="Kenyan Baddies Club" style="max-height:44px;width:auto;">
        @else
          <div class="auth-brand"><span class="orange">Baddies-</span><span class="white">Club</span></div>
        @endif
      </a>
    </div>

    {{-- Title --}}
    <h1 class="auth-title">Create your account</h1>

    {{-- Referral badge --}}
    @if($referrer)
      <div class="referral-badge">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ff8c00" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/><path d="M17 11l2 2 4-4"/></svg>
        <span>You were invited by <strong style="color:#fff;">{{ $referrer->name }}</strong> — sign up &amp; top up to unlock your welcome bonus!</span>
      </div>
    @endif

    {{-- Global errors --}}
    @if($errors->any() && !$errors->has('name') && !$errors->has('email') && !$errors->has('password'))
      <div class="mb-3 p-3 rounded" style="background:rgba(220,53,69,0.12);border:1px solid rgba(220,53,69,0.35);font-size:0.82rem;color:#ff6b6b;">
        {{ $errors->first() }}
      </div>
    @endif

    {{-- Form --}}
    <form method="POST" action="{{ route('register') }}" novalidate>
      @csrf
      @if($refCode)
        <input type="hidden" name="ref" value="{{ $refCode }}">
      @endif

      {{-- Name --}}
      <div class="mb-3">
        <label class="auth-label" for="name">Full Name</label>
        <input id="name" type="text" name="name"
          class="auth-custom-input" placeholder="Enter your name"
          value="{{ old('name') }}" autocomplete="name" required>
        @error('name')<div class="field-error">{{ $message }}</div>@enderror
      </div>

      {{-- Email --}}
      <div class="mb-3">
        <label class="auth-label" for="email">Email Address</label>
        <input id="email" type="email" name="email"
          class="auth-custom-input" placeholder="Enter a valid email"
          value="{{ old('email') }}" autocomplete="email" required>
        @error('email')<div class="field-error">{{ $message }}</div>@enderror
      </div>

      {{-- Password --}}
      <div class="mb-3">
        <label class="auth-label" for="password">Password</label>
        <div class="input-wrap">
          <input id="password" type="password" name="password"
            class="auth-custom-input" placeholder="Min 8 characters"
            autocomplete="new-password" required
            style="padding-right:2.8rem;">
          <button type="button" class="pw-toggle-btn" onclick="togglePw('password','eye1')" tabindex="-1">
            <svg id="eye1" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>

        {{-- Password strength --}}
        <div class="mt-2 d-none" id="password-strength-container">
          <div class="d-flex justify-content-between align-items-center mb-1">
            <span id="password-strength-text" style="font-size:0.75rem;font-weight:700;letter-spacing:0.02em;color:rgba(255,255,255,0.5);">Password Strength</span>
          </div>
          <div class="progress mb-2" style="height:4px;background-color:rgba(255,255,255,0.1);border-radius:2px;">
            <div id="password-strength-bar" class="progress-bar" role="progressbar" style="width:0%;transition:width 0.3s ease,background-color 0.3s ease;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <ul class="list-unstyled mb-0" style="display:grid;grid-template-columns:1fr 1fr;gap:6px;font-size:0.75rem;">
            <li id="req-length" class="pwd-req"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="me-1"><polyline points="20 6 9 17 4 12"/></svg>8+ characters</li>
            <li id="req-upper"  class="pwd-req"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="me-1"><polyline points="20 6 9 17 4 12"/></svg>Uppercase</li>
            <li id="req-lower"  class="pwd-req"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="me-1"><polyline points="20 6 9 17 4 12"/></svg>Lowercase</li>
            <li id="req-number" class="pwd-req"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="me-1"><polyline points="20 6 9 17 4 12"/></svg>Number/Symbol</li>
          </ul>
        </div>

        @error('password')<div class="field-error">{{ $message }}</div>@enderror
      </div>

      {{-- Confirm password --}}
      <div class="mb-4">
        <label class="auth-label" for="password_confirmation">Confirm Password</label>
        <div class="input-wrap">
          <input id="password_confirmation" type="password" name="password_confirmation"
            class="auth-custom-input" placeholder="Repeat password"
            autocomplete="new-password" required
            style="padding-right:2.8rem;">
          <button type="button" class="pw-toggle-btn" onclick="togglePw('password_confirmation','eye2')" tabindex="-1">
            <svg id="eye2" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
      </div>

      <button type="submit" id="reg-submit-btn" class="btn-orange-lg" disabled>Sign Up</button>
    </form>

    <div class="or-divider my-3"><hr><span>OR</span></div>

    <div class="auth-footer">
      <span>Already have an account?</span>
      <a href="{{ url('/') }}"> Back to Homepage →</a>
    </div>

    <p class="text-center mt-3 mb-0" style="color:rgba(255,255,255,0.4);font-size:0.78rem;line-height:1.5;">
      By signing up, you agree to the Terms and Conditions and Privacy Notice, including Cookie Use.
    </p>

  </div>
</div>

<script>
  // ── Password show/hide ──
  function togglePw(inputId, iconId) {
    var input = document.getElementById(inputId);
    var icon  = document.getElementById(iconId);
    if (!input) return;
    if (input.type === 'password') {
      input.type = 'text';
      icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
    } else {
      input.type = 'password';
      icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    }
  }

  // ── Password strength ──
  document.addEventListener('DOMContentLoaded', function () {
    var passwordInput   = document.getElementById('password');
    var strengthContainer = document.getElementById('password-strength-container');
    var strengthText    = document.getElementById('password-strength-text');
    var strengthBar     = document.getElementById('password-strength-bar');
    var submitBtn       = document.getElementById('reg-submit-btn');
    var reqLength       = document.getElementById('req-length');
    var reqUpper        = document.getElementById('req-upper');
    var reqLower        = document.getElementById('req-lower');
    var reqNumber       = document.getElementById('req-number');

    function setReq(el, valid) {
      if (!el) return;
      valid ? el.classList.add('valid') : el.classList.remove('valid');
    }

    if (passwordInput && strengthContainer && submitBtn) {
      passwordInput.addEventListener('input', function () {
        var val = passwordInput.value;
        if (!val.length) {
          strengthContainer.classList.add('d-none');
          submitBtn.disabled = true; return;
        }
        strengthContainer.classList.remove('d-none');

        var hasLength = val.length >= 8;
        var hasLower  = /[a-z]/.test(val);
        var hasUpper  = /[A-Z]/.test(val);
        var hasNum    = /[0-9$@#&!%*?]/.test(val);

        setReq(reqLength, hasLength);
        setReq(reqLower,  hasLower);
        setReq(reqUpper,  hasUpper);
        setReq(reqNumber, hasNum);

        var allValid = hasLength && hasLower && hasUpper && hasNum;
        submitBtn.disabled = !allValid;
        submitBtn.style.opacity = allValid ? '1' : '0.6';
        submitBtn.style.cursor  = allValid ? 'pointer' : 'not-allowed';

        var strength = [hasLength, hasLower, hasUpper, hasNum].filter(Boolean).length * 25;
        strengthBar.style.width = strength + '%';
        strengthBar.setAttribute('aria-valuenow', strength);
        strengthBar.className = 'progress-bar';

        if (strength <= 25) {
          strengthBar.classList.add('bg-danger');
          strengthText.textContent = 'Weak'; strengthText.style.color = '#dc3545';
        } else if (strength <= 50) {
          strengthBar.classList.add('bg-warning');
          strengthText.textContent = 'Fair'; strengthText.style.color = '#ffc107';
        } else if (strength <= 75) {
          strengthBar.classList.add('bg-info');
          strengthText.textContent = 'Good'; strengthText.style.color = '#0dcaf0';
        } else {
          strengthBar.classList.add('bg-success');
          strengthText.textContent = 'Strong'; strengthText.style.color = '#198754';
        }
      });
    }
  });
</script>
</body>
</html>
