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
    [data-bs-theme="light"] hr, [data-bs-theme="light"] .border-top, [data-bs-theme="light"] .border-bottom { border-color: rgba(0,0,0,0.1) !important; }
    [data-bs-theme="light"] div[style*="background:rgba(255,255,255,0.03)"] { background: #f8f9fa !important; border-color: rgba(0,0,0,0.08) !important; }
    [data-bs-theme="light"] .text-light, [data-bs-theme="light"] .text-white { color: #111 !important; }
  </style>
</head>
<body>

  <x-checkout-toast />



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
      <div class="col-12 col-lg-5 col-xl-4 d-none d-lg-block">
        <div class="dash-card h-100" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
          <div class="text-warning small fw-bold text-uppercase tracking-wider mb-2">{{ __('PRIME VIP MEMBERSHIP') }}</div>
          <h2 class="dash-card-title fs-3 mb-4">{{ __('Plan Details') }}</h2>
          
          <p class="dash-card-text text-light fw-medium mb-4">Listing On the Prime VIP Section of the website on respective Geo Locations. Can upload up to 15 Photos.</p>

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
        planPrice: {{ $plan?->pricing ? max(array_values($plan->pricing)) : 2000 }}, 
        planDays: {{ $plan?->pricing ? array_key_last($plan->pricing) : 30 }},
        paymentMethod: 'mpesa',
        mpesaPhone: '', 
        loading: false
      }">
        <div class="dash-card h-100" style="border-top: 4px solid orange;">
          <form action="{{ route('membership.process') }}" method="POST" id="primeVipCheckoutForm" @submit.prevent>
            @csrf



            <input type="hidden" name="plan_type" value="prime-vip">

            <!-- STEP 1: Plan Details -->
            <div x-show="step === 1" x-transition>
              <div class="row g-4 mb-4">
                <div class="col-12 col-md-6">
                  <label class="form-label">{{ __('Select Plan') }}</label>
                  <select class="form-select" name="plan" @change="planDays = parseInt($event.target.value); planPrice = parseInt($event.target.options[$event.target.selectedIndex].getAttribute('data-price'))">
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
              <div class="mt-2" x-show="paymentMethod === 'mpesa'">
                <span class="fee-note">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                  {{ __('Transaction Fee:') }} <strong>0% + 0</strong> &mdash; {{ __('No hidden charges on MPESA.') }}
                </span>
              </div>

              <!-- Plan Details (Mobile Only - Step 1) -->
              <div class="p-3 rounded my-3 d-lg-none" style="background:rgba(255,140,0,0.04); border:1px solid rgba(255,140,0,0.2); border-radius:12px;">
                <div class="text-warning small fw-bold text-uppercase tracking-wider mb-2" style="font-size:0.78rem;">{{ strtoupper($plan?->name ?? 'Membership') }} {{ __('Plan Details & Limits') }}</div>
                <ul class="list-unstyled mb-0" style="font-size:0.85rem; line-height:1.7;">
                  @foreach($plan?->pricing ?? [] as $days => $price)
                    <li class="d-flex align-items-center gap-2 text-secondary">
                      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#ff8c00" stroke-width="2.5" stroke-linecap="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                      <span class="text-light fw-medium">{{ $days }} {{ (int)$days === 1 ? 'Day' : 'Days' }} Listing</span> = <span class="text-warning">{{ number_format($price) }} Ksh</span>
                    </li>
                  @endforeach
                  @foreach($plan?->features ?? [] as $feature)
                    <li class="d-flex align-items-center gap-2 text-secondary">
                      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#ff8c00" stroke-width="2.5" stroke-linecap="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                      {{ $feature }}
                    </li>
                  @endforeach
                </ul>
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
                <!-- If wallet selected, submit directly. If MPESA, go to step 2 -->
                <button type="button" class="btn btn-orange py-2 py-sm-3 px-1 px-sm-3 fs-6 fs-sm-5 w-50 d-flex align-items-center justify-content-center text-center" style="border-radius:12px; line-height:1.2;"
                  @click="if(paymentMethod === 'wallet') { $el.closest('form').submit(); } else { step = 2; window.scrollTo({top: 0, behavior: 'smooth'}); }">
                  <span>{{ __('Pay & Subscribe') }}</span>
                </button>
              </div>
            </div>

            <!-- STEP 2: M-PESA Phone Input (AJAX) -->
            <div x-show="step === 2" style="display:none;" x-cloak x-transition>
              <!-- Stepper -->
              <div class="d-flex justify-content-between align-items-center mb-5 position-relative px-4">
                <div class="position-absolute top-50 start-0 end-0 translate-middle-y" style="height:2px; background:rgba(255,255,255,0.1); z-index:1;"></div>
                <div class="text-center position-relative" style="z-index:2;">
                  <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width:44px; height:44px; font-weight:800; background:orange; border:4px solid #111; color:#000;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                  </div>
                  <div class="fw-bold text-uppercase" style="font-size:0.68rem; letter-spacing:1px; color:orange;">Details</div>
                </div>
                <div class="text-center position-relative" style="z-index:2;">
                  <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width:44px; height:44px; font-weight:800; font-size:1.1rem; background:orange; border:4px solid #0d0d0d; color:#000; box-shadow:0 0 24px rgba(255,165,0,0.5);">2</div>
                  <div class="fw-bold text-uppercase" style="font-size:0.68rem; letter-spacing:1px; color:orange;">M-PESA</div>
                </div>
                <div class="text-center position-relative" style="z-index:2;">
                  <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width:44px; height:44px; font-weight:700; background:#1c1c1c; border:2px solid rgba(255,255,255,0.12); color:rgba(255,255,255,0.35);">3</div>
                  <div class="text-secondary fw-bold text-uppercase" style="font-size:0.68rem; letter-spacing:1px;">Confirm</div>
                </div>
              </div>

              <div class="text-center mb-4">
                <h3 class="text-light mb-1" style="font-weight:900; font-size:1.65rem; letter-spacing:1.5px;">PAY WITH M-PESA</h3>
                <p class="text-secondary mb-0" style="font-size:0.95rem;">Enter Your M-Pesa Number Below</p>
              </div>

              <div class="mb-4">
                <label class="form-label fw-bold" style="font-size:1rem;">M-PESA Phone Number</label>
                <div class="input-group input-group-lg">
                  <span class="input-group-text" style="background:rgba(255,140,0,0.12); border:1px solid rgba(255,140,0,0.3); border-right:none; color:orange; font-weight:800; font-size:1rem; border-radius:8px 0 0 8px; user-select:none; pointer-events:none;">+254</span>
                  <input id="rc-phone-suffix" type="tel" inputmode="numeric" pattern="[0-9]*" class="form-control form-control-lg" placeholder="Enter mobile number" x-model="mpesaPhone" @input="mpesaPhone = $event.target.value.replace(/\D/g, '')" maxlength="9" autocomplete="tel" @keydown.enter.prevent="if (mpesaPhone.length >= 9) document.getElementById('rc-submit-btn').click()" style="background:rgba(0,0,0,0.3); border-color:rgba(255,140,0,0.3); color:#fff; font-size:1rem; text-align:left; border-left:none; border-radius:0 8px 8px 0;">
                </div>
                <div class="text-secondary mt-2" style="font-size:0.8rem;">e.g. 722 123 456 &mdash; enter digits after +254</div>
              </div>

              <!-- Payment Result Panels -->
              <div id="rc-panel-waiting" class="pay-result waiting text-center" style="display:none;">
                <div class="pay-result-icon"><span class="spinner-border" style="width:24px;height:24px;border-width:3px;color:orange;" role="status"></span></div>
                <div class="pay-result-title">Waiting for Payment…</div>
                <div class="pay-result-sub">Check your phone — an M-Pesa PIN prompt has been sent. Enter your PIN to complete the payment.</div>
              </div>
              <div id="rc-panel-success" class="pay-result success text-center" style="display:none;">
                <div class="pay-result-icon"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#28a745" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
                <div class="pay-result-title">Payment Successful!</div>
                <div class="pay-result-sub">Your subscription has been activated. Redirecting…</div>
              </div>
              <div id="rc-panel-cancelled" class="pay-result cancelled text-center" style="display:none;">
                <div class="pay-result-icon"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#fd7e14" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg></div>
                <div class="pay-result-title">Transaction Cancelled</div>
                <div class="pay-result-sub">You cancelled the M-Pesa PIN prompt. No money was deducted.</div>
                <button class="btn-retry" id="rc-retry-cancelled"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.5"/></svg> Try Again</button>
              </div>
              <div id="rc-panel-failed" class="pay-result failed text-center" style="display:none;">
                <div class="pay-result-icon"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#dc3545" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div>
                <div class="pay-result-title">Payment Failed</div>
                <div id="rc-panel-failed-reason" class="pay-result-sub">The payment could not be completed. Please try again.</div>
                <button class="btn-retry" id="rc-retry-failed"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.5"/></svg> Try Again</button>
              </div>
              <div id="rc-panel-timeout" class="pay-result timeout text-center" style="display:none;">
                <div class="pay-result-icon"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#adb5bd" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                <div class="pay-result-title">Payment Timed Out</div>
                <div class="pay-result-sub">No confirmation received within 2 minutes. No money was deducted.</div>
                <button class="btn-retry" id="rc-retry-timeout"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.5"/></svg> Try Again</button>
              </div>

              <div class="mt-4">
                <button type="button" id="rc-submit-btn" class="btn py-2 fw-bold rounded-2 d-flex align-items-center justify-content-center gap-2 w-100 btn-orange" style="font-size:0.92rem; letter-spacing:0.4px; height:48px;" :disabled="mpesaPhone.length < 9" :class="{ 'opacity-75': mpesaPhone.length < 9 }">
                  <template x-if="!loading">
                    <span class="d-flex align-items-center gap-2">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                      Send Payment Request
                    </span>
                  </template>
                  <template x-if="loading">
                    <span class="d-flex align-items-center gap-2">
                      <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                      Sending Request…
                    </span>
                  </template>
                </button>
              </div>

              <!-- Instructions (moved to bottom) -->
              <div class="rounded p-4 mt-4" style="background:rgba(255,140,0,0.04); border:1px solid rgba(255,140,0,0.18);">
                <div class="d-flex align-items-start gap-3 mb-4">
                  <div class="flex-shrink-0 mt-1"><div class="rounded-circle d-flex align-items-center justify-content-center" style="width:30px; height:30px; background:rgba(255,140,0,0.12); border:1px solid rgba(255,140,0,0.4);"><span style="color:orange; font-weight:800; font-size:0.78rem;">1</span></div></div>
                  <div><div class="text-light fw-semibold mb-1" style="font-size:0.92rem;">Check your phone for the M-PESA PIN prompt</div><div class="text-secondary" style="font-size:0.82rem;">A payment request will be sent to your Safaricom number.</div></div>
                </div>
                <div class="d-flex align-items-start gap-3 mb-4">
                  <div class="flex-shrink-0 mt-1"><div class="rounded-circle d-flex align-items-center justify-content-center" style="width:30px; height:30px; background:rgba(255,140,0,0.12); border:1px solid rgba(255,140,0,0.4);"><span style="color:orange; font-weight:800; font-size:0.78rem;">2</span></div></div>
                  <div><div class="text-light fw-semibold mb-1" style="font-size:0.92rem;">Key in your M-PESA PIN and confirm</div><div class="text-secondary" style="font-size:0.82rem;">Enter your PIN on the Safaricom STK push popup to authorise.</div></div>
                </div>
                <div class="d-flex align-items-start gap-3">
                  <div class="flex-shrink-0 mt-1"><div class="rounded-circle d-flex align-items-center justify-content-center" style="width:30px; height:30px; background:rgba(255,140,0,0.12); border:1px solid rgba(255,140,0,0.4);"><span style="color:orange; font-weight:800; font-size:0.78rem;">3</span></div></div>
                  <div><div class="text-light fw-semibold mb-1" style="font-size:0.92rem;">Wait for this page to refresh</div><div class="text-secondary" style="font-size:0.82rem;">Once payment is confirmed you will be subscribed automatically.</div></div>
                </div>
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

  {{-- Pay-result panel styles --}}
  <style>
    .pay-result { border-radius:14px; padding:1.5rem 1.75rem; margin-top:1rem; animation:fadeSlideIn 0.35s ease; }
    @keyframes fadeSlideIn { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
    .pay-result-icon { width:52px;height:52px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem; }
    .pay-result-title { font-size:1.1rem;font-weight:800;margin-bottom:0.3rem; }
    .pay-result-sub { font-size:0.88rem;opacity:0.75;line-height:1.5; }
    .pay-result.waiting { background:rgba(255,140,0,0.08); border:1px solid rgba(255,140,0,0.25); }
    .pay-result.waiting .pay-result-icon { background:rgba(255,140,0,0.12); }
    .pay-result.waiting .pay-result-title { color:orange; }
    .pay-result.success { background:rgba(40,167,69,0.08); border:1px solid rgba(40,167,69,0.3); }
    .pay-result.success .pay-result-icon { background:rgba(40,167,69,0.15); }
    .pay-result.success .pay-result-title { color:#28a745; }
    .pay-result.cancelled { background:rgba(255,165,0,0.07); border:1px solid rgba(255,165,0,0.3); }
    .pay-result.cancelled .pay-result-icon { background:rgba(255,165,0,0.12); }
    .pay-result.cancelled .pay-result-title { color:#fd7e14; }
    .pay-result.failed { background:rgba(220,53,69,0.08); border:1px solid rgba(220,53,69,0.3); }
    .pay-result.failed .pay-result-icon { background:rgba(220,53,69,0.12); }
    .pay-result.failed .pay-result-title { color:#dc3545; }
    .pay-result.timeout { background:rgba(108,117,125,0.1); border:1px solid rgba(108,117,125,0.25); }
    .pay-result.timeout .pay-result-icon { background:rgba(108,117,125,0.15); }
    .pay-result.timeout .pay-result-title { color:#adb5bd; }
    .btn-retry { display:inline-flex;align-items:center;gap:0.4rem;margin-top:1rem;padding:0.55rem 1.25rem;border-radius:8px;font-size:0.88rem;font-weight:700;font-family:"Outfit",sans-serif;cursor:pointer;transition:all 0.25s;background:transparent;border:2px solid currentColor; }
    .pay-result.failed .btn-retry { color:#dc3545; }
    .pay-result.failed .btn-retry:hover { background:#dc3545;color:#fff; }
    .pay-result.cancelled .btn-retry { color:#fd7e14; }
    .pay-result.cancelled .btn-retry:hover { background:#fd7e14;color:#fff; }
    .pay-result.timeout .btn-retry { color:#adb5bd; }
    .pay-result.timeout .btn-retry:hover { background:#adb5bd;color:#000; }
  </style>

  <script>
    // MPESA fetch-based payment for regular-checkout
    (function() {
      const RC_PANELS = ['waiting','success','cancelled','failed','timeout'];
      function rcShowPanel(name) {
        RC_PANELS.forEach(p => {
          const el = document.getElementById('rc-panel-' + p);
          if (el) el.style.display = (p === name) ? 'block' : 'none';
        });
      }
      function rcHidePanels() {
        RC_PANELS.forEach(p => { const el = document.getElementById('rc-panel-' + p); if (el) el.style.display = 'none'; });
      }

      const submitBtn = document.getElementById('rc-submit-btn');
      const backBtn  = document.getElementById('rc-back-btn');

      function rcReset() {
        rcHidePanels();
        submitBtn.disabled = false;
        const alpine = submitBtn.closest('[x-data]').__x;
        if (alpine) alpine.$data.loading = false;
      }

      ['rc-retry-cancelled','rc-retry-failed','rc-retry-timeout'].forEach(id => {
        document.getElementById(id)?.addEventListener('click', rcReset);
      });

      submitBtn.addEventListener('click', function() {
        const alpineEl = submitBtn.closest('[x-data]');
        const alpineData = alpineEl.__x ? alpineEl.__x.$data : (alpineEl._x_dataStack ? alpineEl._x_dataStack[0] : null);
        if (!alpineData) return;

        const phoneSuffix = (alpineData.mpesaPhone || '').trim();
        if (phoneSuffix.length < 9) return;

        const phone    = '254' + phoneSuffix;
        const planDays = alpineData.planDays || document.querySelector('[name="plan"]')?.value;

        alpineData.loading = true;
        submitBtn.disabled = true;
        rcHidePanels();

        fetch("{{ route('payment.initiate') }}", {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
          body: JSON.stringify({ phone, purpose: 'membership', plan_type: 'prime-vip', plan_days: planDays })
        })
        .then(r => r.json())
        .then(data => {
          if (!data.success) {
            document.getElementById('rc-panel-failed-reason').textContent = data.message || 'Could not initiate payment.';
            rcShowPanel('failed');
            alpineData.loading = false;
            submitBtn.disabled = false;
            return;
          }
          rcShowPanel('waiting');
          alpineData.loading = false;
          let pollCount = 0;
          const maxPolls = 40;
          window._rcPoll = setInterval(() => {
            pollCount++;
            if (pollCount > maxPolls) {
              clearInterval(window._rcPoll);
              rcShowPanel('timeout');
              submitBtn.disabled = false;
              return;
            }
            fetch('/payment/status/' + data.reference)
            .then(r => r.json())
            .then(s => {
              if (s.status === 'completed') {
                clearInterval(window._rcPoll);
                rcShowPanel('success');
                setTimeout(() => window.location.href = "{{ route('profile.edit') }}#tab-membership", 2000);
              } else if (s.status === 'failed') {
                clearInterval(window._rcPoll);
                if (s.is_cancelled) {
                  rcShowPanel('cancelled');
                } else {
                  const raw = s.failure_reason || '';
                  document.getElementById('rc-panel-failed-reason').textContent = /insufficient|balance|funds/i.test(raw)
                    ? 'Your M-Pesa account has insufficient balance. Top up and try again.'
                    : (raw || 'The payment could not be completed.');
                  rcShowPanel('failed');
                }
                submitBtn.disabled = false;
              }
            })
            .catch(err => console.error('Poll error:', err));
          }, 3000);
        })
        .catch(err => {
          console.error(err);
          document.getElementById('rc-panel-failed-reason').textContent = 'An unexpected error occurred.';
          rcShowPanel('failed');
          alpineData.loading = false;
          submitBtn.disabled = false;
        });
      });
    })();
  </script>
</body>
</html>

