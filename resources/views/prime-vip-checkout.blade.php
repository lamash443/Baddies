<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Prime VIP Membership Checkout - Baddies Club</title>
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
    .dash-card-text { font-size:0.9rem; color:rgba(255,255,255,0.6); margin-bottom:1rem; line-height:1.5; }
    
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
    .checkout-toast .toast-inner { display:flex; align-items:center; gap:1rem; padding:1rem 1.2rem; }
    .checkout-toast .toast-icon { flex-shrink:0; width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center; background:rgba(255,255,255,0.15); }
    .checkout-toast .toast-msg { flex:1; font-size:0.95rem; font-weight:600; letter-spacing:0.01em; line-height:1.4; }
    .checkout-toast .toast-close { flex-shrink:0; background:none; border:none; color:inherit; opacity:0.7; cursor:pointer; padding:4px; border-radius:50%; transition:opacity 0.2s; }
    .checkout-toast .toast-close:hover { opacity:1; }
    .toast-success { background:rgba(25,135,84,0.95); color:#fff; border:1px solid rgba(40,167,69,0.5); }
    .toast-error { background:rgba(220,53,69,0.95); color:#fff; border:1px solid rgba(220,53,69,0.5); }
  </style>

  @if(session('success'))
    <div id="successToast" class="checkout-toast toast-success" role="alert">
      <div class="toast-inner">
        <div class="toast-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg></div>
        <div class="toast-msg"><div style="font-size:0.78rem;opacity:0.8;text-transform:uppercase;letter-spacing:1px;margin-bottom:2px;">Success</div>{{ session('success') }}</div>
        <button class="toast-close" onclick="dismissToast('successToast')" aria-label="Close"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
      </div>
    </div>
  @endif

  @if($errors->has('wallet') || $errors->any())
    <div id="errorToast" class="checkout-toast toast-error" role="alert">
      <div class="toast-inner">
        <div class="toast-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div>
        <div class="toast-msg"><div style="font-size:0.78rem;opacity:0.8;text-transform:uppercase;letter-spacing:1px;margin-bottom:2px;">Payment Failed</div>{{ $errors->first('wallet') ?: $errors->first() }}</div>
        <button class="toast-close" onclick="dismissToast('errorToast')" aria-label="Close"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
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
      <h1 class="dashboard-title">Prime VIP Membership <span>Checkout</span></h1>
      <nav aria-label="breadcrumb" class="d-flex justify-content-center mt-3">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="#" class="text-warning text-decoration-none fw-bold">{{ __('Home') }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('profile.edit') }}#tab-membership" class="text-warning text-decoration-none fw-bold">{{ __('My Membership') }}</a></li>
          <li class="breadcrumb-item active text-secondary" aria-current="page">{{ __('Prime VIP Checkout') }}</li>
        </ol>
      </nav>
    </div>
  </div>

  <div class="container pb-5 mb-5">
    
    <!-- Available Wallet Balance -->
    <div class="row mb-4">
      <div class="col-12">
        <div class="dash-card mb-0 py-3 px-4">
          <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
              <div class="icon-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; border-radius: 50%; border: 2px solid orange; background: rgba(255,140,0,0.1);">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"></rect><line x1="2" y1="10" x2="22" y2="10"></line></svg>
              </div>
              <div>
                <div class="text-secondary small text-uppercase fw-bold" style="letter-spacing:1px;">{{ __('Available Balance') }}</div>
                <div class="fs-4 fw-bold text-light mt-1">KSh {{ number_format(auth()->user()->wallet_balance ?? 0, 2) }}</div>
              </div>
            </div>
            <a href="{{ route('wallet.add') }}" class="btn btn-orange btn-sm px-3 py-2" style="font-size: 0.9rem;">{{ __('Add Funds') }}</a>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-4">
      
      <!-- Left Column: Plan Details -->
      <div class="col-12 col-lg-5 col-xl-4">
        <div class="dash-card h-100" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
          <div class="text-warning small fw-bold text-uppercase tracking-wider mb-2">{{ __('PRIME VIP MEMBERSHIP') }}</div>
          <h2 class="dash-card-title fs-3 mb-4">{{ __('Plan Details') }}</h2>
          
          <p class="dash-card-text text-light fw-medium mb-4">Listing On the Prime Section of the Homepage and VIP sections of respective Geo Location. Can upload up to 10 Photos.</p>

          <ul class="list-unstyled plan-list mb-0">
            @foreach($plan?->pricing ?? [] as $days => $price)
              <li class="d-flex align-items-center gap-2">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-secondary"><polyline points="20 6 9 17 4 12"></polyline></svg>
                {{ $days }} {{ (int)$days === 1 ? 'Day' : 'Days' }} Listing = <span>{{ number_format($price) }} Ksh</span>
              </li>
            @endforeach
            @foreach($plan?->features ?? [] as $feature)
              <li class="d-flex align-items-center gap-2">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-secondary"><polyline points="20 6 9 17 4 12"></polyline></svg>
                {{ $feature }}
              </li>
            @endforeach
          </ul>
        </div>
      </div>

      <!-- Right Column: Checkout Form -->
      <div class="col-12 col-lg-7 col-xl-8" x-data="{ 
        step: 1, 
        planPrice: {{ $plan?->pricing ? max(array_values($plan->pricing)) : 4000 }}, 
        paymentMethod: 'mpesa',
        mpesaPhone: '', 
        loading: false 
      }">
        <div class="dash-card h-100" style="border-top: 4px solid orange;">
          <form action="{{ route('membership.process') }}" method="POST" id="primeVipCheckoutForm">
            @csrf
            


            <input type="hidden" name="plan_type" value="prime-vip">
            
            <!-- STEP 1: Plan Details -->
            <div x-show="step === 1" x-transition>
              <div class="row g-4 mb-4">
                <div class="col-12 col-md-6">
                  <label class="form-label">{{ __('Select Plan') }}</label>
                  <select class="form-select" name="plan" @change="planPrice = parseInt($event.target.options[$event.target.selectedIndex].getAttribute('data-price'))">
                  @php
                    $pricing = $plan?->pricing ?? [];
                    $lastKey = array_key_last($pricing);
                  @endphp
                  @foreach($pricing as $days => $price)
                    <option value="{{ $days }}" data-price="{{ $price }}" {{ $days == $lastKey ? 'selected' : '' }}>{{ $days }} {{ (int)$days === 1 ? 'Day' : 'Days' }} for KSh {{ number_format($price) }}</option>
                  @endforeach
                  </select>
                </div>
                <div class="col-12 col-md-6">
                  <label class="form-label">{{ __('Payment Methods') }}</label>
                  <select class="form-select" name="payment_method" x-model="paymentMethod">
                    <option value="mpesa">MPESA</option>
                    <option value="wallet">Wallet Balance (KSh {{ number_format(auth()->user()->wallet_balance ?? 0, 2) }})</option>
                  </select>
                </div>
              </div>

              <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">

              <div class="p-4 rounded mb-4" style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.1);">
                <div class="d-flex justify-content-between mb-3 text-secondary">
                  <span class="fs-5">{{ __('Plan Price:') }}</span>
                  <span class="text-light fw-medium fs-5" x-text="'KSh ' + planPrice.toLocaleString()"></span>
                </div>
                <div class="d-flex justify-content-between pt-3 mt-3 border-top" style="border-color:rgba(255,255,255,0.1) !important;">
                  <span class="text-light fw-bold fs-4">{{ __('Total:') }}</span>
                  <span class="text-warning fw-bold fs-3" x-text="'KSh ' + planPrice.toLocaleString()"></span>
                </div>
              </div>

              <div class="d-flex flex-row gap-2 gap-sm-3 mt-4">
                <button type="button" class="btn text-light py-2 py-sm-3 px-1 px-sm-3 fs-6 fs-sm-5 fw-medium w-50 d-flex align-items-center justify-content-center" style="border-radius:12px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); transition:all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='rgba(255,255,255,0.05)'" onclick="history.back()">
                  {{ __('Back') }}
                </button>
                <button type="button" class="btn btn-orange py-2 py-sm-3 px-1 px-sm-3 fs-6 fs-sm-5 w-50 d-flex align-items-center justify-content-center text-center" style="border-radius:12px; line-height:1.2;"
                  @click="if(paymentMethod === 'wallet') { $el.closest('form').submit(); } else { step = 2; window.scrollTo({top: 0, behavior: 'smooth'}); }">
                  <span>{{ __('Pay & Subscribe') }}</span>
                </button>
              </div>
            </div>

            <!-- STEP 2: M-PESA Phone Input -->
            <div x-show="step === 2" style="display:none;" x-cloak x-transition>
              <!-- Stepper -->
              <div class="d-flex justify-content-between align-items-center mb-5 position-relative px-4">
                <div class="position-absolute top-50 start-0 end-0 translate-middle-y" style="height:2px; background:rgba(255,255,255,0.1); z-index:1;"></div>
                <div class="text-center position-relative" style="z-index:2;">
                  <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width:44px; height:44px; font-weight:800; background:#28a745; border:4px solid #111; color:#fff;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                  </div>
                  <div class="text-success fw-bold text-uppercase" style="font-size:0.68rem; letter-spacing:1px;">Details</div>
                </div>
                <div class="text-center position-relative" style="z-index:2;">
                  <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width:44px; height:44px; font-weight:800; font-size:1.1rem; background:#28a745; border:4px solid #0d0d0d; color:#fff; box-shadow:0 0 24px rgba(40,167,69,0.5);">2</div>
                  <div class="text-success fw-bold text-uppercase" style="font-size:0.68rem; letter-spacing:1px;">M-PESA</div>
                </div>
                <div class="text-center position-relative" style="z-index:2;">
                  <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width:44px; height:44px; font-weight:700; background:#1c1c1c; border:2px solid rgba(255,255,255,0.12); color:rgba(255,255,255,0.35);">3</div>
                  <div class="text-secondary fw-bold text-uppercase" style="font-size:0.68rem; letter-spacing:1px;">Confirm</div>
                </div>
              </div>

              <div class="text-center mb-5">
                <h3 class="text-light mb-1" style="font-weight:900; font-size:1.65rem; letter-spacing:1.5px;">PAY WITH M-PESA</h3>
                <p class="text-secondary mb-0" style="font-size:0.95rem;">Enter Your M-Pesa Number Below</p>
              </div>

              <div class="mb-4">
                <label class="form-label fw-bold" style="font-size:1rem;">M-PESA Phone Number</label>
                <div class="input-group input-group-lg">
                  <span class="input-group-text" style="background:rgba(40,167,69,0.08); border-color:rgba(40,167,69,0.3); color:#28a745;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                  </span>
                  <input type="tel" class="form-control form-control-lg" name="mpesaPhone" placeholder="254722xxxxxx" x-model="mpesaPhone" pattern="^254[0-9]{9}$" maxlength="12" autocomplete="tel" style="background:rgba(0,0,0,0.3); border-color:rgba(40,167,69,0.3); color:#fff; font-size:1.15rem; letter-spacing:3px; text-align:center;">
                </div>
                <div class="text-center text-secondary mt-2" style="font-size:0.8rem;">Format: 254XXXXXXXXX &nbsp;·&nbsp; e.g. 254722123456</div>
              </div>

              <div class="rounded p-4 mb-5" style="background:rgba(40,167,69,0.04); border:1px solid rgba(40,167,69,0.18);">
                <div class="d-flex align-items-start gap-3 mb-4">
                  <div class="flex-shrink-0 mt-1"><div class="rounded-circle d-flex align-items-center justify-content-center" style="width:30px; height:30px; background:rgba(40,167,69,0.12); border:1px solid rgba(40,167,69,0.4);"><span class="text-success fw-bold" style="font-size:0.78rem;">1</span></div></div>
                  <div><div class="text-light fw-semibold mb-1" style="font-size:0.92rem;">Check your phone for the M-PESA PIN prompt</div><div class="text-secondary" style="font-size:0.82rem;">A payment request will be sent to your Safaricom number.</div></div>
                </div>
                <div class="d-flex align-items-start gap-3 mb-4">
                  <div class="flex-shrink-0 mt-1"><div class="rounded-circle d-flex align-items-center justify-content-center" style="width:30px; height:30px; background:rgba(40,167,69,0.12); border:1px solid rgba(40,167,69,0.4);"><span class="text-success fw-bold" style="font-size:0.78rem;">2</span></div></div>
                  <div><div class="text-light fw-semibold mb-1" style="font-size:0.92rem;">Key in your M-PESA PIN and confirm</div><div class="text-secondary" style="font-size:0.82rem;">Enter your PIN on the Safaricom STK push popup to authorise.</div></div>
                </div>
                <div class="d-flex align-items-start gap-3">
                  <div class="flex-shrink-0 mt-1"><div class="rounded-circle d-flex align-items-center justify-content-center" style="width:30px; height:30px; background:rgba(40,167,69,0.12); border:1px solid rgba(40,167,69,0.4);"><span class="text-success fw-bold" style="font-size:0.78rem;">3</span></div></div>
                  <div><div class="text-light fw-semibold mb-1" style="font-size:0.92rem;">Wait for this page to refresh</div><div class="text-secondary" style="font-size:0.82rem;">Once payment is confirmed you will be moved to the next step automatically.</div></div>
                </div>
              </div>

              <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-outline-secondary px-4 py-3" @click="step = 1; window.scrollTo({top: 0, behavior: 'smooth'});">{{ __('Back') }}</button>
                <button type="submit" class="btn py-3 fw-bold rounded-2 d-flex align-items-center justify-content-center gap-2 flex-grow-1 ms-3" style="background:#28a745; border:2px solid #28a745; color:#fff; font-size:1.05rem; letter-spacing:0.5px; transition:all 0.3s ease; cursor:pointer;" :disabled="loading || mpesaPhone.length < 12" :class="{ 'opacity-75': loading || mpesaPhone.length < 12 }" @click="if(mpesaPhone.length >= 12) loading = true">
                  <template x-if="!loading">
                    <span class="d-flex align-items-center gap-2">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                      Send Payment Request to Phone
                    </span>
                  </template>
                  <template x-if="loading">
                    <span class="d-flex align-items-center gap-2">
                      <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                      Sending Payment Request…
                    </span>
                  </template>
                </button>
              </div>
            </div>

          </form>
        </div>
      </div>

    </div>
  </div>

  <x-footer />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
