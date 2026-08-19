<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Checkout - MPESA - Baddies Club</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing:border-box; }
    html, body { margin:0; padding:0; font-family:"Outfit",sans-serif; background:#0d0d0d; color:#fff; min-height:100vh; }

    /* DASHBOARD LAYOUT */
    .dashboard-header { padding:3rem 0 2rem; border-bottom:1px solid rgba(255,140,0,0.12); margin-bottom:2.5rem; }
    .dashboard-title { font-size:clamp(1.8rem,4vw,2.5rem); font-weight:900; letter-spacing:-0.02em; line-height:1.1; margin-bottom:0.5rem; }
    .dashboard-title span { background:linear-gradient(135deg,#28a745,#5cb85c); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
    
    /* CARDS */
    .dash-card {
      background:rgba(17,17,17,0.85); backdrop-filter:blur(15px);
      border:1px solid rgba(40,167,69,0.2); border-radius:18px; padding:2.5rem;
      box-shadow:0 8px 32px rgba(0,0,0,0.5); margin-bottom: 2rem;
    }
    .dash-card-title { font-size:1.5rem; font-weight:800; color:#fff; margin-bottom:1rem; text-align: center; letter-spacing:1px; }
    
    /* FORMS */
    .form-label { font-size: 1rem; font-weight: 600; color: rgba(255,255,255,0.8); margin-bottom: 0.5rem; }
    .form-control {
      background-color: rgba(0,0,0,0.3); border: 1px solid rgba(40,167,69,0.3);
      color: #fff; padding: 1rem 1.25rem; border-radius: 8px; font-size: 1.1rem;
      text-align: center; letter-spacing: 2px;
    }
    .form-control:focus {
      background-color: rgba(0,0,0,0.5); border-color: #28a745; box-shadow: 0 0 0 4px rgba(40,167,69,0.15); color: #fff;
    }
    
    /* BUTTONS */
    .btn-mpesa {
      display:flex; align-items:center; justify-content:center; gap:0.5rem;
      background:#28a745; border:2px solid #28a745; color:#fff;
      padding:1rem 2rem; border-radius:12px; font-size:1.1rem; font-weight:800; font-family:"Outfit",sans-serif;
      text-decoration:none; transition:all 0.3s ease; width: 100%; text-transform: uppercase; letter-spacing:0.5px;
    }
    .btn-mpesa:hover { background:#218838; border-color:#218838; box-shadow:0 0 20px rgba(40,167,69,0.4); color:#fff; }

    /* INSTRUCTIONS */
    .instructions {
      background: rgba(255,255,255,0.03);
      border-radius: 12px;
      padding: 1.5rem;
      margin-top: 2rem;
      border: 1px solid rgba(255,255,255,0.1);
    }
    .instructions p {
      margin-bottom: 0.8rem;
      color: rgba(255,255,255,0.8);
      font-size: 0.95rem;
      display: flex;
      align-items: flex-start;
      gap: 0.5rem;
    }
    .instructions p:last-child { margin-bottom: 0; }
    .instructions p i { color: #28a745; margin-top: 3px; }

    /* LIGHT THEME */
    [data-bs-theme="light"] body { background:#f9f9f9; color:#111; }
    [data-bs-theme="light"] .dashboard-header { border-color:rgba(0,0,0,0.1); }
    [data-bs-theme="light"] .dash-card { background:#fff; border-color:rgba(40,167,69,0.3); box-shadow:0 5px 20px rgba(0,0,0,0.05); }
    [data-bs-theme="light"] .dash-card-title { color:#000; }
    [data-bs-theme="light"] .form-control { background: #fff; color: #000; border-color: rgba(0,0,0,0.2); }
    [data-bs-theme="light"] .instructions { background: #f8f9fa; border-color: rgba(0,0,0,0.1); }
    [data-bs-theme="light"] .instructions p { color: rgba(0,0,0,0.8); }
  </style>
</head>
<body>

  <!-- NAVBAR -->
  <x-navbar :hideSearch="true" />

  <!-- HEADER -->
  <div class="dashboard-header">
    <div class="container text-center">
      <h1 class="dashboard-title">Checkout - <span>MPESA</span></h1>
      <nav aria-label="breadcrumb" class="d-flex justify-content-center mt-3">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-success text-decoration-none fw-bold">{{ __('Home') }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('profile.edit') }}#tab-membership" class="text-success text-decoration-none fw-bold">{{ __('My Membership') }}</a></li>
          <li class="breadcrumb-item"><a href="javascript:history.back()" class="text-success text-decoration-none fw-bold">{{ __('Plan Checkout') }}</a></li>
          <li class="breadcrumb-item active text-secondary" aria-current="page">{{ __('Checkout - MPESA') }}</li>
        </ol>
      </nav>
    </div>
  </div>

  <div class="container pb-5 mb-5">
    <div class="row justify-content-center">
      <div class="col-12 col-md-8 col-lg-6">
        
        <div class="dash-card border-top border-4 border-success">
          
          <!-- Stepper -->
          <div class="stepper d-flex justify-content-between align-items-center mb-5 position-relative px-3">
            <div class="stepper-line position-absolute top-50 start-0 end-0 translate-middle-y" style="height: 2px; background: rgba(255,255,255,0.1); z-index: 1;"></div>
            
            <div class="step text-center position-relative" style="z-index: 2;">
              <div class="step-circle bg-success text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 40px; height: 40px; font-weight: bold; border: 4px solid #111;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
              </div>
              <div class="step-label text-success small fw-bold text-uppercase" style="letter-spacing:1px; font-size: 0.75rem;">Details</div>
            </div>

            <div class="step text-center position-relative" style="z-index: 2;">
              <div class="step-circle bg-success text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 40px; height: 40px; font-weight: bold; border: 4px solid #111; box-shadow: 0 0 15px rgba(40,167,69,0.5);">2</div>
              <div class="step-label text-success small fw-bold text-uppercase" style="letter-spacing:1px; font-size: 0.75rem;">M-PESA</div>
            </div>

            <div class="step text-center position-relative" style="z-index: 2;">
              <div class="step-circle bg-dark text-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 40px; height: 40px; font-weight: bold; border: 2px solid rgba(255,255,255,0.1); background: #111;">3</div>
              <div class="step-label text-secondary small fw-bold text-uppercase" style="letter-spacing:1px; font-size: 0.75rem;">Confirm</div>
            </div>
          </div>

          <div class="text-center mb-4">
            <h2 class="dash-card-title">{{ __('PAY WITH M-PESA') }}</h2>
            <p class="text-secondary">{{ __('Enter Your M-Pesa Number Below') }}</p>
          </div>

          <form action="#" method="POST">
            @csrf
            
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="mb-4">
              <input type="text" class="form-control form-control-lg" name="phone" placeholder="254722xxxxxx" required autofocus autocomplete="tel">
            </div>

            <button type="submit" class="btn btn-mpesa">
              {{ __('Send Payment Request to Phone') }}
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
            </button>
          </form>

          <div class="instructions">
            <p>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#28a745" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
              <span>Check your phone number for the M-PESA PIN prompt.</span>
            </p>
            <p>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#28a745" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
              <span>Key in your M-PESA PIN and submit.</span>
            </p>
            <p>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#28a745" stroke-width="2"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
              <span>Wait for this page to refresh to move you to the next page.</span>
            </p>
          </div>

        </div>

      </div>
    </div>
  </div>

  <x-footer />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
