<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Account Verification - Baddies Club</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing:border-box; }
    html, body { margin:0; padding:0; font-family:"Outfit",sans-serif; background:#0d0d0d; color:#fff; min-height:100vh; }

    /* DASHBOARD LAYOUT & CARDS */
    .dashboard-header { padding:3rem 0 2rem; border-bottom:1px solid rgba(255,140,0,0.12); margin-bottom:2.5rem; }
    .dashboard-title { font-size:clamp(1.8rem,4vw,2.5rem); font-weight:900; letter-spacing:-0.02em; line-height:1.1; margin-bottom:0.5rem; }
    .dashboard-title span { background:linear-gradient(135deg,#ff8c00,#ffb347); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
    .dashboard-sub { font-size:0.9rem; color:rgba(255,255,255,0.5); font-weight:400; }

    .dash-card {
      background:rgba(17,17,17,0.85); backdrop-filter:blur(15px);
      border:1px solid rgba(255,140,0,0.2); border-radius:18px; padding:2rem;
      box-shadow:0 8px 32px rgba(0,0,0,0.5); margin-bottom: 2rem;
    }
    .dash-card-title { font-size:1.2rem; font-weight:700; color:#fff; margin-bottom:0.5rem; }
    
    .step-number {
      display: inline-flex; align-items: center; justify-content: center;
      width: 36px; height: 36px; border-radius: 50%;
      background: rgba(255,140,0,0.1); border: 2px solid orange;
      color: orange; font-weight: 800; font-size: 1.1rem;
      margin-right: 1rem; flex-shrink: 0;
    }
    .step-content {
      font-size: 1.05rem; font-weight: 500; color: rgba(255,255,255,0.9);
      line-height: 1.6;
    }

    /* FORMS */
    .form-label { font-size: 0.9rem; font-weight: 500; color: rgba(255,255,255,0.8); margin-bottom: 0.4rem; }
    .form-control {
      background: rgba(0,0,0,0.3); border: 1px solid rgba(255,140,0,0.2);
      color: #fff; padding: 0.75rem 1rem; border-radius: 8px; font-size: 0.95rem;
    }
    .form-control:focus {
      background: rgba(0,0,0,0.5); border-color: orange; box-shadow: 0 0 0 3px rgba(255,165,0,0.15); color: #fff;
    }

    /* BUTTONS */
    .btn-orange {
      display:inline-flex; align-items:center; justify-content:center; gap:0.4rem;
      background:orange; border:2px solid orange; color:#000;
      padding:0.75rem 1.5rem; border-radius:8px; font-size:1rem; font-weight:700; font-family:"Outfit",sans-serif;
      text-decoration:none; transition:all 0.3s ease; border: none;
    }
    .btn-orange:hover { background:#fff; color:orange; box-shadow:0 0 15px rgba(255,165,0,0.5); }

    /* LIGHT THEME */
    [data-bs-theme="light"] body { background:#f9f9f9; color:#111; }
    [data-bs-theme="light"] .dashboard-header { border-color:rgba(0,0,0,0.1); }
    [data-bs-theme="light"] .dashboard-sub { color:rgba(0,0,0,0.6); }
    [data-bs-theme="light"] .dash-card { background:#fff; border-color:rgba(255,140,0,0.3); box-shadow:0 5px 20px rgba(0,0,0,0.05); }
    [data-bs-theme="light"] .dash-card-title { color:#000; }
    [data-bs-theme="light"] .step-content { color:#111; }
    [data-bs-theme="light"] .form-control { background: #fff; color: #000; border-color: rgba(0,0,0,0.1); }
  </style>
</head>
<body>

  <!-- NAVBAR -->
  <x-navbar :hideSearch="true" />

  <!-- HEADER -->
  <div class="dashboard-header">
    <div class="container text-center">
      <h1 class="dashboard-title">Exclusive <span>Memberships</span></h1>
      <p class="dashboard-sub">{{ __('Follow the steps below to verify your account and unlock premium access.') }}</p>
    </div>
  </div>

  <div class="container pb-5 mb-5">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-8 col-xl-7">
        
        <div class="dash-card mb-4" style="border-top: 4px solid orange;">
          
          <div class="mb-4 text-center">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="mb-3"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
            <h3 class="text-white mb-3 fw-bold">{{ __('Verify Your Email Address') }}</h3>
            <p class="text-secondary mx-auto" style="font-size: 1.05rem; max-width: 500px; line-height: 1.6;">
              {{ __('Thanks for signing up! Before getting started, you must verify your email address. Please click on the link we just emailed to you. If you didn\'t receive the email, we will gladly send you another.') }}
            </p>
          </div>

          <form method="POST" action="{{ route('verification.send') }}" class="mt-2">
            @csrf
            <button type="submit" class="btn btn-orange w-100 fw-bold py-3 shadow-lg">
              {{ __('Resend Verification Email') }}
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="ms-1"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
            </button>
          </form>

          <form method="POST" action="{{ route('logout') }}" class="mt-4 text-center">
            @csrf
            <button type="submit" class="btn btn-link text-secondary text-decoration-none p-0" style="font-size: 0.9rem;">
              {{ __('Log Out') }}
            </button>
          </form>

        </div>

      </div>
    </div>
  </div>

  <x-footer />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  @if (session('status') == 'verification-link-sent')
  <script>
    document.addEventListener("DOMContentLoaded", function() {
        const isMobile = window.innerWidth <= 768;
        const toast = document.createElement('div');
        
        toast.style.cssText = `
            position: fixed;
            top: 85px;
            ${isMobile ? 'left: 50%; transform: translate(-50%, -20px); width: 90%; max-width: 400px; justify-content: center;' : 'right: 25px; transform: translateY(-20px);'}
            background: #111;
            color: #4ade80;
            border: 1px solid #4ade80;
            padding: 12px 20px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 8px 30px rgba(74,222,128,0.2);
            z-index: 9999;
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: flex;
            align-items: center;
            gap: 10px;
        `;
        toast.innerHTML = `
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            {{ \App\Models\Setting::getSettings()->verification_toast_message ?? __('A new verification link has been sent to your email address.') }}
        `;
        document.body.appendChild(toast);

        // Animate in
        setTimeout(() => {
            toast.style.opacity = '1';
            toast.style.transform = isMobile ? 'translate(-50%, 0)' : 'translateY(0)';
        }, 100);

        // Animate out
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = isMobile ? 'translate(-50%, -20px)' : 'translateY(-20px)';
            setTimeout(() => toast.remove(), 400);
        }, 4500);
    });
  </script>
  @endif
</body>
</html>
