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
          
          <div class="d-flex align-items-start mb-4">
            <div class="step-number">1</div>
            <div class="step-content pt-1">
              {{ __('To add profile, your account must be verified with following steps:') }}
            </div>
          </div>

          <div class="d-flex align-items-start mb-4">
            <div class="step-number">2</div>
            <div class="step-content pt-1">
              {!! __('Write <strong class="text-warning fs-4">857</strong> on a piece of paper and take a new photo of yourself holding that piece of paper.') !!}
            </div>
          </div>

          <div class="d-flex align-items-start mb-4">
            <div class="step-number">3</div>
            <div class="step-content pt-1">
              {{ __('Verification code must be hand written') }}
            </div>
          </div>

        </div>

        <div class="dash-card mb-4" style="background: rgba(220,53,69,0.05); border-color: rgba(220,53,69,0.3);">
          <div class="d-flex gap-3">
            <div class="text-danger mt-1">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            </div>
            <div>
              <h4 class="text-danger fw-bold fs-5 mb-2">{{ __('Important Rules') }}</h4>
              <ul class="text-secondary list-unstyled mb-0" style="line-height: 1.6;">
                <li class="mb-1">• {{ __('We do not accept passport or ID scans, photos with no face visible.') }}</li>
                <li>• {{ __('Any attempt to use different person’s photo.') }}</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="dash-card">
          <div class="text-center mb-4">
            <div class="d-inline-block bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill fw-bold small mb-3">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
              {{ __('100% Secure & Private') }}
            </div>
            <p class="text-secondary small">
              {{ __('The image you upload will never be published or shared.') }}
            </p>
          </div>

          <form action="#" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
              <label class="form-label fw-bold">{{ __('Upload File') }}</label>
              <input type="file" name="verification_photo" class="form-control py-3" accept=".jpg,.jpeg" required />
              <div class="mt-2 text-secondary small">{{ __('Allowed file types are JPEG, JPG.') }}</div>
            </div>
            
            <button type="submit" class="btn btn-orange w-100 fw-bold py-3 mt-2 shadow-lg">
              {{ __('Submit Verification') }}
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="ms-1"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            </button>
          </form>
        </div>

      </div>
    </div>
  </div>

  <x-footer />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
