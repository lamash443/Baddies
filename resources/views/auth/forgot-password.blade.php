<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <x-site-favicon />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <title>Forgot Password - Kenyan Baddies Club</title>
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  
  <style>
    *, *::before, *::after { box-sizing: border-box; }
    html, body { 
        margin:0; padding:0; 
        font-family:"Outfit",sans-serif; 
        background:#000000; 
        color:#fff; 
        min-height:100vh; 
        display: flex; 
        flex-direction: column; 
    }
    
    /* Input & Button Styles */
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
      box-shadow: 0 4px 15px rgba(255, 140, 0, 0.4) !important;
      transform: translateY(-1px);
    }
    
    /* Main Content Area */
    .auth-page-wrapper {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 4rem 1.5rem;
        position: relative;
        overflow: hidden;
    }
    .auth-page-bg {
        position: absolute; inset: 0;
        background: linear-gradient(160deg, #000000 0%, #1a0f00 40%, #000000 100%);
        z-index: 0;
    }
    .auth-card {
        position: relative; z-index: 2;
        background: #111;
        border: 1px solid rgba(255,140,0,0.25);
        border-radius: 1.25rem;
        padding: 2.5rem;
        max-width: 480px;
        width: 100%;
        box-shadow: 0 10px 40px rgba(0,0,0,0.5);
    }
    .auth-title {
        font-size: 1.6rem;
        font-weight: 800;
        color: #fff;
        margin-bottom: 1rem;
        text-align: center;
    }
    .auth-title span { color: #ff8c00; }
    .auth-desc {
        font-size: 0.95rem;
        color: rgba(255,255,255,0.65);
        text-align: center;
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    /* LIGHT THEME OVERRIDES */
    [data-bs-theme="light"] body { background: #f4f6f9; color: #111; }
    [data-bs-theme="light"] .auth-page-bg { background: linear-gradient(160deg, #f4f6f9 0%, #fff4e6 40%, #f4f6f9 100%); }
    [data-bs-theme="light"] .auth-card { background: #ffffff; border-color: rgba(255,140,0,0.3); box-shadow: 0 10px 40px rgba(0,0,0,0.08); }
    [data-bs-theme="light"] .auth-title { color: #111; }
    [data-bs-theme="light"] .auth-desc { color: rgba(0,0,0,0.65); }
    [data-bs-theme="light"] .auth-custom-input:focus { border-color: #ff8c00 !important; box-shadow: 0 0 0 0.2rem rgba(255,140,0,0.2) !important; }
    
    /* Back Button */
    .auth-back-arrow {
        position: absolute; left: 1.5rem; top: 1.5rem;
        color: #ff8c00; transition: color 0.3s ease, transform 0.2s ease;
        background: transparent; border: none; padding: 0;
        z-index: 10;
    }
    .auth-back-arrow:hover { color: #fff; transform: translateX(-2px); }
    [data-bs-theme="light"] .auth-back-arrow:hover { color: #111; }
  </style>
</head>
<body>

<x-navbar :hideSearch="true" />

<div class="auth-page-wrapper">
    <div class="auth-page-bg"></div>
    <div class="auth-card">
        <!-- Back Arrow -->
        <a href="/?auth=login" class="auth-back-arrow" title="Back to Login">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
        </a>

        <h1 class="auth-title mt-2">Reset <span>Password</span></h1>
        
        <div class="auth-desc">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <!-- Session Status is now handled via toast below -->

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <label class="form-label small fw-bold mb-2" style="color:rgba(255,140,0,0.9); letter-spacing:.03em; text-transform:uppercase;">{{ __('Email Address') }}</label>
                <input id="email" class="form-control auth-custom-input" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter your email">
                @error('email')
                    <div class="small mt-1" style="color:#ff6b6b; font-weight:500;">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-orange-lg w-100 shadow-sm mt-2">
                {{ __('Email Password Reset Link') }}
            </button>
        </form>
    </div>
</div>

<x-footer />

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- AUTH MODAL (in case it is triggered from navbar) -->
<x-auth-modal />

@if(session('status'))
<style>
  .success-toast {
    position: fixed; top: 5.5rem; right: 2rem; z-index: 1060;
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
  
  [data-bs-theme="light"] .success-toast { background: #ffffff; border-color: rgba(40,167,69,0.3); box-shadow: 0 10px 40px rgba(0,0,0,0.08); }
  [data-bs-theme="light"] .success-toast__title { color: #28a745; }
  [data-bs-theme="light"] .success-toast__msg { color: rgba(0,0,0,0.7); }
  [data-bs-theme="light"] .success-toast__close { background: rgba(0,0,0,0.04); border-color: rgba(0,0,0,0.08); color: rgba(0,0,0,0.5); }
  [data-bs-theme="light"] .success-toast__close:hover { background: rgba(40,167,69,0.1); color: #28a745; border-color: rgba(40,167,69,0.2); }
</style>
<div class="success-toast" id="pwdSuccessToast" role="alert" aria-live="assertive">
  <div class="success-toast__icon">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
      <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>
    </svg>
  </div>
  <div class="success-toast__body">
    <p class="success-toast__title">Success</p>
    <p class="success-toast__msg">{{ session('status') }}</p>
  </div>
  <button class="success-toast__close" onclick="document.getElementById('pwdSuccessToast').remove();" aria-label="Dismiss">
    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
      <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
    </svg>
  </button>
  <div class="success-toast__bar"></div>
</div>
<script>setTimeout(()=>{const t=document.getElementById('pwdSuccessToast');if(t)t.remove();},6000);</script>
@endif

@if(session('throttle_error'))
<style>
  .err-toast {
    position: fixed; top: 5.5rem; right: 2rem; z-index: 1060;
    display: flex; align-items: flex-start; gap: 0.85rem;
    background: #0d0d0d;
    border: 1px solid rgba(220,53,69,0.45);
    border-left: 4px solid #dc3545;
    border-radius: 14px;
    padding: 1rem 1.25rem;
    max-width: 360px; width: calc(100vw - 4rem);
    box-shadow: 0 20px 60px rgba(0,0,0,0.8), 0 0 0 1px rgba(255,255,255,0.04);
    font-family: "Outfit", ui-sans-serif, sans-serif;
    animation: errToastIn 0.45s cubic-bezier(0.34,1.56,0.64,1) both;
    overflow: hidden;
  }
  @keyframes errToastIn {
    from { opacity:0; transform: translateY(-20px) scale(0.93); }
    to   { opacity:1; transform: translateY(0) scale(1); }
  }
  .err-toast__icon {
    flex-shrink:0; margin-top:2px;
    width:38px; height:38px; border-radius:11px;
    background:rgba(220,53,69,0.12); border:1px solid rgba(220,53,69,0.3);
    display:flex; align-items:center; justify-content:center; color:#ff4d4d;
  }
  .err-toast__body { flex:1; min-width:0; }
  .err-toast__title { font-size:.88rem; font-weight:700; color:#ff4d4d; margin:0 0 .2rem; line-height:1.2; }
  .err-toast__msg   { font-size:.8rem;  color:rgba(255,255,255,.6); margin:0; line-height:1.5; }
  .err-toast__close {
    flex-shrink:0; align-self:flex-start;
    background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.1);
    border-radius:7px; width:26px; height:26px;
    display:flex; align-items:center; justify-content:center;
    color:rgba(255,255,255,.45); cursor:pointer; padding:0; transition:all .2s;
  }
  .err-toast__close:hover { background:rgba(220,53,69,.15); border-color:rgba(220,53,69,.35); color:#ff4d4d; }
  .err-toast__bar {
    position:absolute; bottom:0; left:0; height:3px;
    background:linear-gradient(90deg,#dc3545,rgba(220,53,69,.1));
    border-radius:0 0 0 14px;
    animation:errToastBar 6s linear both;
  }
  @keyframes errToastBar { from{width:100%} to{width:0%} }
  
  [data-bs-theme="light"] .err-toast { background: #ffffff; border-color: rgba(220,53,69,0.3); box-shadow: 0 10px 40px rgba(0,0,0,0.08); }
  [data-bs-theme="light"] .err-toast__title { color: #dc3545; }
  [data-bs-theme="light"] .err-toast__msg { color: rgba(0,0,0,0.7); }
  [data-bs-theme="light"] .err-toast__close { background: rgba(0,0,0,0.04); border-color: rgba(0,0,0,0.08); color: rgba(0,0,0,0.5); }
  [data-bs-theme="light"] .err-toast__close:hover { background: rgba(220,53,69,0.1); color: #dc3545; border-color: rgba(220,53,69,0.2); }
</style>
<div class="err-toast" id="pwdErrToast" role="alert" aria-live="assertive">
  <div class="err-toast__icon">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
      <circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line>
    </svg>
  </div>
  <div class="err-toast__body">
    <p class="err-toast__title">Limit Reached</p>
    <p class="err-toast__msg">{{ session('throttle_error') }}</p>
  </div>
  <button class="err-toast__close" onclick="document.getElementById('pwdErrToast').remove();" aria-label="Dismiss">
    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
      <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
    </svg>
  </button>
  <div class="err-toast__bar"></div>
</div>
<script>setTimeout(()=>{const t=document.getElementById('pwdErrToast');if(t)t.remove();},6000);</script>
@endif

</body>
</html>
