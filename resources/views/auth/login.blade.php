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
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <title>VIP Login - Kenyan Baddies Club</title>
  <meta name="description" content="Log in to your Kenyan Baddies Club account.">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; }
    html, body {
      margin: 0; padding: 0;
      font-family: "Outfit", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
      background: #0a0a0a;
      color: #fff;
      min-height: 100vh;
      display: flex; align-items: center; justify-content: center;
      -webkit-font-smoothing: antialiased;
    }

    /* Ambient Glow Background */
    body::before {
      content: '';
      position: fixed; inset: 0; z-index: 0;
      background:
        radial-gradient(ellipse 80% 50% at 50% -10%, rgba(255,140,0,0.12) 0%, transparent 65%),
        radial-gradient(ellipse 60% 50% at 80% 100%, rgba(255,140,0,0.06) 0%, transparent 70%);
      pointer-events: none;
    }
    .bg-grid {
      position: fixed; inset: 0; z-index: 0;
      background-size: 36px 36px;
      background-image:
        linear-gradient(to right, rgba(255,140,0,0.035) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(255,140,0,0.035) 1px, transparent 1px);
      mask-image: radial-gradient(ellipse 90% 90% at 50% 50%, black 30%, transparent 85%);
      -webkit-mask-image: radial-gradient(ellipse 90% 90% at 50% 50%, black 30%, transparent 85%);
      pointer-events: none;
    }

    /* Outer Wrapper & Responsive Card */
    .auth-page-wrap {
      position: relative; z-index: 1;
      width: 100%; max-width: 460px;
      padding: 1.25rem 1rem;
      margin: auto;
    }
    .auth-page-card {
      background: rgba(10, 10, 10, 0.85);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 140, 0, 0.4) !important;
      box-shadow: 0 16px 48px rgba(0, 0, 0, 0.9), 0 0 32px rgba(255, 140, 0, 0.15) !important;
      border-radius: 1.5rem;
      padding: 2.25rem 2rem 2.5rem;
      animation: cardIn 0.45s cubic-bezier(0.34, 1.4, 0.64, 1) forwards;
    }
    @keyframes cardIn {
      from { opacity: 0; transform: translateY(20px) scale(0.98); }
      to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* Mobile Phones Responsive Optimization */
    @media (max-width: 575.98px) {
      .auth-page-wrap {
        padding: 0.75rem 0.75rem;
        max-width: 100%;
      }
      .auth-page-card {
        padding: 1.6rem 1.25rem 2rem;
        border-radius: 1.25rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.95), 0 0 20px rgba(255, 140, 0, 0.12) !important;
      }
      .auth-title {
        font-size: 1.35rem !important;
        margin-bottom: 1.25rem !important;
      }
      .auth-brand {
        font-size: 1.3rem !important;
      }
    }

    /* Header & Logo */
    .auth-header {
      display: flex; align-items: center; justify-content: center;
      position: relative; margin-bottom: 1.5rem;
    }
    .auth-brand {
      font-size: 1.5rem; font-weight: 800; letter-spacing: -0.01em;
    }
    .auth-brand .orange { color: #ff8c00; }
    .auth-brand .white  { color: #fff; }
    .auth-back-link {
      position: absolute; left: 0;
      color: rgba(255, 255, 255, 0.55); text-decoration: none;
      font-size: 0.85rem; font-weight: 600; display: flex; align-items: center; gap: 0.35rem;
      padding: 0.4rem 0.6rem; border-radius: 0.5rem;
      background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.08);
      transition: all 0.2s ease;
    }
    .auth-back-link:hover, .auth-back-link:active {
      color: #ff8c00;
      background: rgba(255, 140, 0, 0.12);
      border-color: rgba(255, 140, 0, 0.3);
    }

    /* Referral Notice Badge */
    .ref-banner {
      background: linear-gradient(135deg, rgba(255, 140, 0, 0.15), rgba(255, 140, 0, 0.05));
      border: 1px solid rgba(255, 140, 0, 0.35);
      border-radius: 0.85rem;
      padding: 0.65rem 0.9rem;
      margin-bottom: 1.25rem;
      display: flex; align-items: center; gap: 0.6rem;
      font-size: 0.84rem; font-weight: 600; color: #ff8c00;
    }
    .ref-banner svg { flex-shrink: 0; }

    /* Title */
    .auth-title {
      font-size: 1.55rem; font-weight: 800;
      text-align: center; margin-bottom: 1.5rem; margin-top: 0.25rem;
      letter-spacing: -0.02em;
    }

    /* Form Inputs */
    .auth-label {
      display: block;
      font-size: 0.75rem; font-weight: 700;
      color: rgba(255, 140, 0, 0.95);
      letter-spacing: 0.05em; text-transform: uppercase;
      margin-bottom: 0.45rem;
    }
    .auth-custom-input {
      display: block; width: 100%;
      min-height: 48px;
      background: rgba(0, 0, 0, 0.5) !important;
      border: 1px solid rgba(255, 140, 0, 0.3) !important;
      color: #fff !important;
      border-radius: 0.75rem !important;
      padding: 0.65rem 1rem !important;
      font-size: 1rem !important; /* 16px prevents iOS zoom on tap */
      font-family: "Outfit", sans-serif;
      transition: all 0.25s ease;
      outline: none;
    }
    .auth-custom-input:focus {
      border-color: #ff8c00 !important;
      box-shadow: 0 0 0 3px rgba(255, 140, 0, 0.22) !important;
      background: rgba(0, 0, 0, 0.75) !important;
    }
    .auth-custom-input::placeholder { color: rgba(255, 255, 255, 0.3); }
    .field-error { font-size: 0.82rem; color: #ff6b6b; font-weight: 500; margin-top: 0.35rem; }

    /* Password Input & Eye Toggle */
    .input-wrap { position: relative; }
    .pw-toggle-btn {
      position: absolute; right: 0.75rem; top: 50%;
      transform: translateY(-50%);
      background: none; border: none; cursor: pointer;
      color: rgba(255, 255, 255, 0.4); padding: 0.4rem; display: flex;
      border-radius: 0.4rem;
      transition: all 0.2s ease;
    }
    .pw-toggle-btn:hover, .pw-toggle-btn:focus { color: #ff8c00; background: rgba(255, 140, 0, 0.1); }

    /* Buttons */
    .btn-orange-lg {
      display: flex; align-items: center; justify-content: center;
      width: 100%; min-height: 48px;
      background: linear-gradient(135deg, #ff8c00 0%, #e67e00 100%);
      border: none;
      color: #000; font-weight: 800; font-size: 1rem;
      padding: 0.75rem 1.5rem; border-radius: 0.75rem;
      transition: all 0.25s ease; letter-spacing: 0.02em;
      font-family: "Outfit", sans-serif; cursor: pointer;
      box-shadow: 0 4px 18px rgba(255, 140, 0, 0.3);
    }
    .btn-orange-lg:hover {
      background: linear-gradient(135deg, #ffa026 0%, #ff8c00 100%);
      color: #000;
      box-shadow: 0 6px 24px rgba(255, 140, 0, 0.45);
      transform: translateY(-1px);
    }
    .btn-orange-lg:active {
      transform: translateY(1px) scale(0.99);
      box-shadow: 0 2px 10px rgba(255, 140, 0, 0.3);
    }

    .auth-google-btn {
      background: rgba(255, 255, 255, 0.03); color: #fff; font-weight: 700;
      border-radius: 0.75rem; border: 1.5px solid rgba(255, 140, 0, 0.45);
      font-size: 0.98rem; min-height: 48px; padding: 0.75rem 1.5rem; width: 100%;
      transition: all 0.25s ease; display: flex; align-items: center; justify-content: center; gap: 0.6rem; text-decoration: none;
    }
    .auth-google-btn:hover, .auth-google-btn:active {
      background-color: rgba(255, 140, 0, 0.12) !important;
      border-color: #ff8c00 !important;
      color: #ffffff !important;
      box-shadow: 0 4px 18px rgba(255, 140, 0, 0.25) !important;
    }

    /* OR Divider */
    .or-divider {
      position: relative; text-align: center; margin: 1.35rem 0;
    }
    .or-divider hr { border-color: rgba(255, 140, 0, 0.25); margin: 0; }
    .or-divider span {
      position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
      background: #0a0a0a; padding: 0 0.85rem;
      color: rgba(255, 255, 255, 0.45); font-size: 0.8rem; font-weight: 700;
      border-radius: 1rem; border: 1px solid rgba(255, 140, 0, 0.15);
    }

    /* Footer Navigation */
    .auth-footer { text-align: center; margin-top: 1.5rem; font-size: 0.92rem; }
    .auth-footer a {
      color: #ff8c00; font-weight: 700; text-decoration: none;
      transition: color 0.2s;
    }
    .auth-footer a:hover { color: #fff; text-decoration: underline; }
    .auth-footer span { color: rgba(255, 255, 255, 0.6); }

    /* Light Theme Support */
    [data-bs-theme="light"] body { background: #f4f6f9; color: #111; }
    [data-bs-theme="light"] body::before { opacity: 0.4; }
    [data-bs-theme="light"] .auth-page-card {
      background: #ffffff !important;
      border-color: rgba(0, 0, 0, 0.12) !important;
      box-shadow: 0 12px 36px rgba(0, 0, 0, 0.08) !important;
    }
    [data-bs-theme="light"] .auth-brand .white { color: #111; }
    [data-bs-theme="light"] .auth-title { color: #111; }
    [data-bs-theme="light"] .auth-custom-input {
      background: #fdfdfd !important;
      border-color: rgba(0, 0, 0, 0.18) !important;
      color: #111 !important;
    }
    [data-bs-theme="light"] .auth-custom-input:focus { background: #fff !important; }
    [data-bs-theme="light"] .or-divider span { background: #ffffff; color: rgba(0, 0, 0, 0.5); }
    [data-bs-theme="light"] .auth-footer span { color: rgba(0, 0, 0, 0.65); }
    [data-bs-theme="light"] .auth-google-btn { color: #111; border-color: rgba(255, 140, 0, 0.5); }
  </style>
</head>
<body>
@php
  $siteLogo = \App\Models\SiteSetting::get('logo');
  $refCode  = session('ref_code') ?? request('ref') ?? request('referral_code');
  $referrer = null;
  if ($refCode) {
      $referrer = \App\Models\User::where('referral_code', trim($refCode))->first();
  }
@endphp

<div class="bg-grid"></div>

<div class="auth-page-wrap">
  <div class="auth-page-card">

    {{-- Header --}}
    <div class="auth-header">
      <a href="{{ url('/') }}" class="auth-back-link">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Home
      </a>
      <a href="{{ url('/') }}" style="text-decoration:none;">
        @if(!empty($siteLogo))
          <img src="{{ asset('storage/' . $siteLogo) }}" alt="Kenyan Baddies Club" style="max-height:56px;width:auto;">
        @else
          <div class="auth-brand"><span class="orange">Baddies-</span><span class="white">Club</span></div>
        @endif
      </a>
    </div>

    {{-- Referral Banner --}}
    @if($refCode)
      <div class="ref-banner">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        <div>
          Referred Member Invitation
          @if($referrer)
            <div style="font-size:0.75rem; color:rgba(255,255,255,0.7); font-weight:400;">Invited by {{ $referrer->name }}</div>
          @endif
        </div>
      </div>
    @endif

    {{-- Title --}}
    <h1 class="auth-title">Welcome back</h1>

    <a href="{{ route('auth.google') }}" class="auth-google-btn mb-3">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
      Log in with Google
    </a>
    
    <div class="or-divider mb-3"><hr><span>OR</span></div>

    {{-- Global errors --}}
    @if($errors->any() && !$errors->has('email') && !$errors->has('password'))
      <div class="mb-3 p-3 rounded" style="background:rgba(220,53,69,0.12);border:1px solid rgba(220,53,69,0.35);font-size:0.84rem;color:#ff6b6b;">
        {{ $errors->first() }}
      </div>
    @endif

    {{-- Form --}}
    <form method="POST" action="{{ route('login') }}" novalidate>
      @csrf

      {{-- Email --}}
      <div class="mb-3">
        <label class="auth-label" for="email">Email Address</label>
        <input id="email" type="email" name="email"
          class="auth-custom-input" placeholder="Enter your email address"
          value="{{ old('email') }}" autocomplete="email" required autofocus>
        @error('email')<div class="field-error">{{ $message }}</div>@enderror
      </div>

      {{-- Password --}}
      <div class="mb-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <label class="auth-label mb-0" for="password">Password</label>
          @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" style="color:#ff8c00; font-size:0.82rem; font-weight:600; text-decoration:none;">Forgot?</a>
          @endif
        </div>
        <div class="input-wrap">
          <input id="password" type="password" name="password"
            class="auth-custom-input" placeholder="Enter your password"
            autocomplete="current-password" required
            style="padding-right:2.8rem;">
          <button type="button" class="pw-toggle-btn" onclick="togglePw('password','eye1')" aria-label="Toggle Password Visibility" tabindex="-1">
            <svg id="eye1" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
        @error('password')<div class="field-error">{{ $message }}</div>@enderror
      </div>

      <div class="mb-4 mt-3">
        <div class="form-check d-flex align-items-center gap-2">
          <input type="checkbox" name="remember" id="remember" class="form-check-input" style="border-color:rgba(255,140,0,0.5); background-color:transparent; width:1.15rem; height:1.15rem; margin-top:0; cursor:pointer;">
          <label for="remember" class="form-check-label small" style="font-size:0.88rem; color:rgba(255,255,255,0.7); cursor:pointer;">Keep me logged in</label>
        </div>
      </div>

      <button type="submit" id="login-submit-btn" class="btn-orange-lg">Log in</button>
    </form>

    <div class="auth-footer mt-4">
      <span>Don't have an account?</span>
      <a href="{{ route('register', array_filter(['ref' => $refCode])) }}"> Sign up here</a>
    </div>

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
</script>
</body>
</html>
