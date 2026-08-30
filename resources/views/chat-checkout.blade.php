<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Chat Membership Checkout - Baddies Club</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing:border-box; }
    html, body { margin:0; padding:0; font-family:"Outfit",sans-serif; background:#0d0d0d; color:#fff; min-height:100vh; }

    /* DASHBOARD LAYOUT */
    .dashboard-header { padding:3rem 0 2rem; border-bottom:1px solid rgba(255,140,0,0.12); margin-bottom:2.5rem; }
    .dashboard-title { font-size:clamp(1.8rem,4vw,2.5rem); font-weight:900; letter-spacing:-0.02em; line-height:1.1; margin-bottom:0.5rem; }
    .dashboard-title span { background:linear-gradient(135deg,#ff8c00,#ffb347); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
    
    /* CARDS */
    .dash-card {
      background:rgba(17,17,17,0.85); backdrop-filter:blur(15px);
      border:1px solid rgba(255,140,0,0.2); border-radius:18px; padding:2rem;
      box-shadow:0 8px 32px rgba(0,0,0,0.5); margin-bottom: 2rem;
    }
    .dash-card-title { font-size:1.2rem; font-weight:700; color:#fff; margin-bottom:0.5rem; }
    
    /* FORMS */
    .form-label { font-size: 0.95rem; font-weight: 600; color: rgba(255,255,255,0.8); margin-bottom: 0.5rem; }
    .form-select {
      background-color: rgba(0,0,0,0.3); border: 1px solid rgba(255,140,0,0.2);
      color: #fff; padding: 0.85rem 1rem; border-radius: 8px; font-size: 1rem;
    }
    .form-select:focus {
      background-color: rgba(0,0,0,0.5); border-color: orange; box-shadow: 0 0 0 3px rgba(255,165,0,0.15); color: #fff;
    }
    .form-select option { background-color: #111; color: #fff; }

    /* ── UNIFIED BUTTON STYLE (matches /profile & /dashboard) ── */
    .btn-orange {
      display: inline-flex; align-items: center; justify-content: center; gap: 0.45rem;
      background: transparent; border: 2px solid orange; color: orange;
      padding: 0.75rem 1.5rem; border-radius: 8px; font-size: 1rem; font-weight: 700;
      font-family: "Outfit", sans-serif; text-decoration: none; transition: all 0.3s ease;
      cursor: pointer; letter-spacing: 0.02em;
    }
    .btn-orange:hover {
      background: orange; color: #000; border-color: orange;
      box-shadow: 0 0 18px 4px rgba(255,165,0,0.55), 0 0 35px rgba(255,165,0,0.25);
      transform: translateY(-1px);
    }
    .btn-orange:active { transform: translateY(0); box-shadow: 0 0 10px 2px rgba(255,165,0,0.4); }

    /* SUMMARY LIST */
    .plan-list li { margin-bottom: 1rem; font-size: 1rem; color: rgba(255,255,255,0.7); }
    .plan-list li span { color: #fff; font-weight: 600; }

    /* LIGHT THEME */
    [data-bs-theme="light"] body { background:#f9f9f9; color:#111; }
    [data-bs-theme="light"] .dashboard-header { border-color:rgba(0,0,0,0.1); }
    [data-bs-theme="light"] .dash-card { background:#fff; border-color:rgba(255,140,0,0.3); box-shadow:0 5px 20px rgba(0,0,0,0.05); }
    [data-bs-theme="light"] .dash-card-title { color:#000; }
    [data-bs-theme="light"] .form-select { background: #fff; color: #000; border-color: rgba(0,0,0,0.1); }
    [data-bs-theme="light"] .plan-list li { color: rgba(0,0,0,0.7); }
    [data-bs-theme="light"] .plan-list li span { color: #000; }
  </style>
</head>
<body>

  {{-- ── TOAST NOTIFICATIONS ── --}}
  <style>
    .checkout-toast { position:fixed; top:5.5rem; right:2rem; z-index:99999; border-radius:14px; min-width:340px; max-width:500px; padding:0; backdrop-filter:blur(12px); box-shadow:0 12px 48px rgba(0,0,0,0.4); animation:toastSlide 0.45s cubic-bezier(0.175,0.885,0.32,1.275); transition:opacity 0.35s ease,top 0.35s ease; }
    @keyframes toastSlide { from { transform:translateY(-20px) scale(0.93); opacity:0; } to { transform:translateY(0) scale(1); opacity:1; } }
    .checkout-toast .toast-inner { display: flex; align-items: center; gap: 1rem; padding: 1rem 1.2rem; }
    .checkout-toast .toast-icon { flex-shrink: 0; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
    .checkout-toast .toast-msg { flex: 1; font-size: 0.95rem; font-weight: 600; letter-spacing: 0.01em; line-height: 1.4; }
    .checkout-toast .toast-close { flex-shrink: 0; background: none; border: none; color: inherit; opacity: 0.7; cursor: pointer; padding: 4px; border-radius: 50%; transition: opacity 0.2s; }
    .checkout-toast .toast-close:hover { opacity: 1; }
    .toast-success { background: rgba(25, 135, 84, 0.95); color: #fff; border: 1px solid rgba(40,167,69,0.5); }
    .toast-success .toast-icon { background: rgba(255,255,255,0.15); }
    .toast-error { background: rgba(220, 53, 69, 0.95); color: #fff; border: 1px solid rgba(220,53,69,0.5); }
    .toast-error .toast-icon { background: rgba(255,255,255,0.15); }
  </style>

  @if(session('success'))
    <div id="successToast" class="checkout-toast toast-success" role="alert">
      <div class="toast-inner">
        <div class="toast-icon">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <div class="toast-msg">
          <div style="font-size:0.78rem; opacity:0.8; text-transform:uppercase; letter-spacing:1px; margin-bottom:2px;">Success</div>
          {{ session('success') }}
        </div>
        <button class="toast-close" onclick="dismissToast('successToast')" aria-label="Close">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
      </div>
    </div>
  @endif

  @if($errors->has('wallet') || $errors->any())
    <div id="errorToast" class="checkout-toast toast-error" role="alert">
      <div class="toast-inner">
        <div class="toast-icon">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <div class="toast-msg">
          <div style="font-size:0.78rem; opacity:0.8; text-transform:uppercase; letter-spacing:1px; margin-bottom:2px;">Payment Failed</div>
          {{ $errors->first('wallet') ?: $errors->first() }}
        </div>
        <button class="toast-close" onclick="dismissToast('errorToast')" aria-label="Close">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
      </div>
    </div>
  @endif

  <script>
    function dismissToast(id) { const t=document.getElementById(id); if(t){t.style.opacity='0';t.style.transform='translateY(-20px) scale(0.93)';setTimeout(()=>t.style.display='none',350);} }
    ['successToast','errorToast'].forEach(id => setTimeout(()=>dismissToast(id),6000));
  </script>



  <!-- NAVBAR -->
  <x-navbar :hideSearch="true" />

  <!-- HEADER -->
  <div class="dashboard-header">
    <div class="container text-center">
      <h1 class="dashboard-title">Chat Membership <span>Checkout</span></h1>
      <nav aria-label="breadcrumb" class="d-flex justify-content-center mt-3">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="#" class="text-warning text-decoration-none fw-bold">{{ __('Home') }}</a></li>
          <li class="breadcrumb-item active text-secondary" aria-current="page">{{ __('Chat Membership Checkout') }}</li>
        </ol>
      </nav>
    </div>
  </div>

  <div class="container pb-5 mb-5">
    <div class="row g-4">
      
      <!-- Left Column: Plan Details -->
      <div class="col-12 col-lg-5 col-xl-4">
        <div class="dash-card h-100" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
          <div class="text-warning small fw-bold text-uppercase tracking-wider mb-2">{{ __('CHAT SUBSCRIPTION') }}</div>
          <h2 class="dash-card-title fs-3 mb-4">{{ __('Chat Subscription Plan') }}</h2>
          
          <ul class="list-unstyled plan-list mb-0">
            @foreach($chatPlan?->pricing ?? [] as $days => $price)
              <li class="d-flex align-items-center gap-2">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-secondary"><polyline points="20 6 9 17 4 12"></polyline></svg>
                {{ $days }} {{ (int)$days === 1 ? 'Day' : 'Days' }} Chat Plan = <span>{{ number_format($price) }} Ksh</span>
              </li>
            @endforeach
          </ul>
        </div>
      </div>

      <!-- Right Column: Checkout Form -->
      <div class="col-12 col-lg-7 col-xl-8">
        <div class="dash-card h-100" style="border-top: 4px solid orange;">
          <form action="{{ route('membership.process') }}" method="POST">
            @csrf
            <input type="hidden" name="plan_type" value="chat">
            
            <div class="row g-4 mb-4">
              <div class="col-12 col-md-6">
                <label class="form-label">{{ __('Select Plan') }}</label>
                <select class="form-select" name="plan" id="plan-select">
                @php
                  $chatPricing = $chatPlan?->pricing ?? [];
                  $lastKey = array_key_last($chatPricing);
                @endphp
                @foreach($chatPricing as $days => $price)
                  <option value="{{ $days }}" data-price="{{ $price }}" {{ $days == $lastKey ? 'selected' : '' }}>{{ $days }} {{ (int)$days === 1 ? 'Day' : 'Days' }} for KSh{{ number_format($price) }}</option>
                @endforeach
                </select>
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label">{{ __('Payment Methods') }}</label>
                <select class="form-select" name="payment_method">
                  <option value="mpesa">MPESA</option>
                  <option value="wallet">Wallet Balance (KSh {{ number_format(auth()->user()->wallet_balance ?? 0, 2) }})</option>
                </select>
              </div>
            </div>

            <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">

            <div class="p-4 rounded mb-4" style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.1);">
              <div class="d-flex justify-content-between mb-3 text-secondary">
                <span class="fs-5">{{ __('Plan Price:') }}</span>
                <span class="text-light fw-medium fs-5" id="plan-price">KSh1,500</span>
              </div>
              <div class="d-flex justify-content-between pt-3 mt-3 border-top" style="border-color:rgba(255,255,255,0.1) !important;">
                <span class="text-light fw-bold fs-4">{{ __('Total:') }}</span>
                <span class="text-warning fw-bold fs-3" id="plan-total">KSh1,500</span>
              </div>
            </div>

            <div class="d-flex flex-row gap-2 gap-sm-3 mt-4">
              <button type="submit" class="btn btn-orange py-2 py-sm-3 px-1 px-sm-3 fs-6 fs-sm-5 w-100 d-flex align-items-center justify-content-center text-center" style="border-radius:12px; line-height:1.2;">
                <span>{{ __('Pay & Subscribe') }}</span>
              </button>
            </div>

          </form>
        </div>
      </div>

    </div>
  </div>

  <x-footer />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const planSelect  = document.getElementById('plan-select');
    const planPrice   = document.getElementById('plan-price');
    const planTotal   = document.getElementById('plan-total');

    const prices = JSON.parse('@json($chatPlan?->pricing ?? [])');

    function formatKsh(amount) {
      return 'KSh' + Number(amount).toLocaleString();
    }

    function updatePrice() {
      const selected = planSelect.options[planSelect.selectedIndex];
      const price    = parseInt(selected.getAttribute('data-price'));
      planPrice.textContent = formatKsh(price);
      planTotal.textContent = formatKsh(price);
    }

    planSelect.addEventListener('change', updatePrice);
    updatePrice();
  </script>
</body>
</html>
