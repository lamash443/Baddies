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
      border:1px solid rgba(255,140,0,0.2); border-radius:18px; padding:2.5rem;
      box-shadow:0 8px 32px rgba(0,0,0,0.5); margin-bottom: 2rem;
    }
    .dash-card-title { font-size:1.5rem; font-weight:800; color:#fff; margin-bottom:1rem; text-align: center; letter-spacing:1px; }
    
    /* FORMS */
    .form-label { font-size: 1rem; font-weight: 600; color: rgba(255,255,255,0.8); margin-bottom: 0.5rem; }
    .form-control {
      background-color: rgba(0,0,0,0.3); border: 1px solid rgba(255,140,0,0.3);
      color: #fff; padding: 1rem 1.25rem; border-radius: 8px; font-size: 1.1rem;
      text-align: center; letter-spacing: 2px;
    }
    .form-control:focus {
      background-color: rgba(0,0,0,0.5); border-color: orange; box-shadow: 0 0 0 4px rgba(255,165,0,0.15); color: #fff;
    }
    @media (max-width: 576px) {
      .form-control {
        font-size: 0.85rem;
        padding: 0.6rem 0.75rem;
        letter-spacing: 1px;
      }
    }
    
    /* BUTTONS */
    .btn-mpesa {
      display:flex; align-items:center; justify-content:center; gap:0.5rem;
      background:orange; border:2px solid orange; color:#000;
      padding:0.75rem 1.5rem; border-radius:10px; font-size:0.95rem; font-weight:800; font-family:"Outfit",sans-serif;
      text-decoration:none; transition:all 0.3s ease; width: 100%; text-transform: uppercase; letter-spacing:0.5px;
      white-space: nowrap;
    }
    .btn-mpesa:hover { background:#e67e00; border-color:#e67e00; box-shadow:0 0 20px rgba(255,165,0,0.4); color:#000; }
    
    @media (max-width: 576px) {
      .btn-mpesa {
        font-size: 0.7rem;
        padding: 0.6rem 0.5rem;
        letter-spacing: 0;
      }
      .btn-mpesa svg { width: 16px; height: 16px; }
    }

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
    .instructions p i { color: orange; margin-top: 3px; }

    /* PAYMENT RESULT PANELS */
    .pay-result {
      border-radius: 14px; padding: 1.5rem 1.75rem;
      margin-top: 1.25rem; display: none;
      animation: fadeSlideIn 0.35s ease;
    }
    @keyframes fadeSlideIn {
      from { opacity: 0; transform: translateY(10px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .pay-result-icon {
      width: 52px; height: 52px; border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 1rem;
    }
    .pay-result-title { font-size: 1.1rem; font-weight: 800; margin-bottom: 0.3rem; }
    .pay-result-sub   { font-size: 0.88rem; opacity: 0.75; line-height: 1.5; }
    .pay-result.waiting  { background: rgba(255,140,0,0.08);  border: 1px solid rgba(255,140,0,0.25); }
    .pay-result.waiting  .pay-result-icon { background: rgba(255,140,0,0.12); }
    .pay-result.waiting  .pay-result-title { color: orange; }
    .pay-result.success  { background: rgba(40,167,69,0.08);  border: 1px solid rgba(40,167,69,0.3); }
    .pay-result.success  .pay-result-icon { background: rgba(40,167,69,0.15); }
    .pay-result.success  .pay-result-title { color: #28a745; }
    .pay-result.cancelled { background: rgba(255,165,0,0.07); border: 1px solid rgba(255,165,0,0.3); }
    .pay-result.cancelled .pay-result-icon { background: rgba(255,165,0,0.12); }
    .pay-result.cancelled .pay-result-title { color: #fd7e14; }
    .pay-result.failed   { background: rgba(220,53,69,0.08);  border: 1px solid rgba(220,53,69,0.3); }
    .pay-result.failed   .pay-result-icon { background: rgba(220,53,69,0.12); }
    .pay-result.failed   .pay-result-title { color: #dc3545; }
    .pay-result.timeout  { background: rgba(108,117,125,0.1); border: 1px solid rgba(108,117,125,0.25); }
    .pay-result.timeout  .pay-result-icon { background: rgba(108,117,125,0.15); }
    .pay-result.timeout  .pay-result-title { color: #adb5bd; }
    .btn-retry {
      display: inline-flex; align-items: center; gap: 0.4rem;
      margin-top: 1rem; padding: 0.55rem 1.25rem; border-radius: 8px;
      font-size: 0.88rem; font-weight: 700; font-family: "Outfit", sans-serif;
      cursor: pointer; transition: all 0.25s;
      background: transparent; border: 2px solid currentColor;
    }
    .pay-result.failed    .btn-retry { color: #dc3545; }
    .pay-result.failed    .btn-retry:hover { background: #dc3545; color: #fff; }
    .pay-result.cancelled .btn-retry { color: #fd7e14; }
    .pay-result.cancelled .btn-retry:hover { background: #fd7e14; color: #fff; }
    .pay-result.timeout   .btn-retry { color: #adb5bd; }
    .pay-result.timeout   .btn-retry:hover { background: #adb5bd; color: #000; }
    .btn-stop {
      display: inline-flex; align-items: center; gap: 0.4rem;
      margin-top: 1rem; padding: 0.45rem 1rem; border-radius: 8px;
      font-size: 0.82rem; font-weight: 600; font-family: "Outfit", sans-serif;
      cursor: pointer; transition: all 0.25s;
      background: transparent; border: 1.5px solid rgba(255,255,255,0.2); color: rgba(255,255,255,0.6);
    }
    .btn-stop:hover { border-color: rgba(255,255,255,0.5); color: #fff; }

    /* LIGHT THEME */
    [data-bs-theme="light"] body { background:#f9f9f9; color:#111; }
    [data-bs-theme="light"] .dashboard-header { border-color:rgba(0,0,0,0.1); }
    [data-bs-theme="light"] .dash-card { background:#fff; border-color:rgba(255,140,0,0.3); box-shadow:0 5px 20px rgba(0,0,0,0.05); }
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
        <ol class="breadcrumb mb-0 justify-content-center flex-wrap">
          <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-warning text-decoration-none fw-bold">{{ __('Home') }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('profile.edit') }}#tab-membership" class="text-warning text-decoration-none fw-bold">{{ __('My Membership') }}</a></li>
          <li class="breadcrumb-item"><a href="javascript:history.back()" class="text-warning text-decoration-none fw-bold">{{ __('Plan Checkout') }}</a></li>
          <li class="breadcrumb-item active text-secondary" aria-current="page">{{ __('Checkout - MPESA') }}</li>
        </ol>
      </nav>
    </div>
  </div>

  <div class="container pb-5 mb-5">
    <div class="row justify-content-center">
      <div class="col-12 col-md-8 col-lg-6">
        
        <div class="dash-card border-top border-4" style="border-color: orange !important;">
          
          <!-- Stepper -->
          <div class="stepper d-flex justify-content-between align-items-center mb-5 position-relative px-3">
            <div class="stepper-line position-absolute top-50 start-0 end-0 translate-middle-y" style="height: 2px; background: rgba(255,255,255,0.1); z-index: 1;"></div>
            
            <div class="step text-center position-relative" style="z-index: 2;">
              <div class="step-circle bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 40px; height: 40px; font-weight: bold; border: 4px solid #111;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
              </div>
              <div class="step-label text-warning small fw-bold text-uppercase" style="letter-spacing:1px; font-size: 0.75rem;">Details</div>
            </div>

            <div class="step text-center position-relative" style="z-index: 2;">
              <div class="step-circle bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 40px; height: 40px; font-weight: bold; border: 4px solid #111; box-shadow: 0 0 15px rgba(255,165,0,0.5);">2</div>
              <div class="step-label text-warning small fw-bold text-uppercase" style="letter-spacing:1px; font-size: 0.75rem;">M-PESA</div>
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

          <form id="mpesa-payment-form" action="#" method="POST">
            @csrf

            <div class="mb-4">
              <div class="input-group">
                <span class="input-group-text" style="background:rgba(255,140,0,0.12); border:1px solid rgba(255,140,0,0.3); border-right:none; color:orange; font-weight:800; font-size:1rem; border-radius:8px 0 0 8px; user-select:none; pointer-events:none;">+254</span>
                <input id="phone-suffix" type="tel" class="form-control form-control-lg" placeholder="7XXXXXXXX" maxlength="9" required autofocus autocomplete="tel" value="{{ session('checkout_prefilled_phone', '') }}" style="border-left:none; border-radius:0 8px 8px 0; text-align:left; letter-spacing:2px;">
              </div>
              <div class="mt-1 small text-secondary">e.g. 722 123 456 &mdash; enter digits after +254</div>
            </div>

            <button type="submit" class="btn btn-mpesa">
              {{ __('Send Payment Request to Phone') }}
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
            </button>
          </form>


          <!-- ── PAYMENT RESULT PANELS ── -->

          <!-- Waiting for PIN -->
          <div id="panel-waiting" class="pay-result waiting text-center">
            <div class="pay-result-icon">
              <span class="spinner-border" style="width:24px;height:24px;border-width:3px;color:orange;" role="status"></span>
            </div>
            <div class="pay-result-title">Waiting for Payment…</div>
            <div class="pay-result-sub">Check your phone — an M-Pesa PIN prompt has been sent. Enter your PIN to complete the payment.</div>
          </div>

          <!-- Success -->
          <div id="panel-success" class="pay-result success text-center">
            <div class="pay-result-icon">
              <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#28a745" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <div class="pay-result-title">Payment Successful!</div>
            <div class="pay-result-sub">Your payment has been confirmed. Redirecting you now…</div>
          </div>

          <!-- Cancelled by user -->
          <div id="panel-cancelled" class="pay-result cancelled text-center">
            <div class="pay-result-icon">
              <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#fd7e14" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            </div>
            <div class="pay-result-title">Transaction Cancelled</div>
            <div class="pay-result-sub">You cancelled the M-Pesa PIN prompt. No money was deducted from your account.</div>
            <button class="btn-retry" id="retry-btn-cancelled">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.5"/></svg>
              Try Again
            </button>
          </div>

          <!-- Failed (insufficient balance or other error) -->
          <div id="panel-failed" class="pay-result failed text-center">
            <div class="pay-result-icon">
              <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#dc3545" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div class="pay-result-title">Payment Failed</div>
            <div id="panel-failed-reason" class="pay-result-sub">The payment could not be completed. Please try again.</div>
            <button class="btn-retry" id="retry-btn-failed">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.5"/></svg>
              Try Again
            </button>
          </div>

          <!-- Timed out (no response in 2 min) -->
          <div id="panel-timeout" class="pay-result timeout text-center">
            <div class="pay-result-icon">
              <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#adb5bd" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="pay-result-title">Payment Timed Out</div>
            <div class="pay-result-sub">No confirmation was received within 2 minutes. No money was deducted from your account.</div>
            <button class="btn-retry" id="retry-btn-timeout">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.5"/></svg>
              Try Again
            </button>
          </div>

          <!-- Manually stopped -->
          <div id="panel-stopped" class="pay-result timeout text-center">
            <div class="pay-result-icon">
              <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#adb5bd" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="6" y="6" width="12" height="12" rx="2"/></svg>
            </div>
            <div class="pay-result-title">Waiting Stopped</div>
            <div class="pay-result-sub">You stopped waiting. If you already entered your PIN the payment may still go through in the background.</div>
            <button class="btn-retry" id="retry-btn-stopped">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.5"/></svg>
              Try Again
            </button>
          </div>

          <!-- Static instructions (always visible) -->
          <div class="instructions">
            <p>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
              <span>Check your phone screen for the M-PESA PIN prompt.</span>
            </p>
            <p>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
              <span>Key in your M-PESA PIN and submit.</span>
            </p>
            <p>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
              <span>Wait for the page to redirect automatically once the payment succeeds.</span>
            </p>
          </div>

        </div>

      </div>
    </div>
  </div>


  <x-footer />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const phoneInput = document.getElementById('phone-suffix');
    const submitBtn  = document.querySelector('#mpesa-payment-form button[type="submit"]');
    const PANELS     = ['waiting','success','cancelled','failed','timeout','stopped'];

    function showPanel(name) {
      PANELS.forEach(p => {
        const el = document.getElementById('panel-' + p);
        if (el) el.style.display = (p === name) ? 'block' : 'none';
      });
    }
    function hideAllPanels() {
      PANELS.forEach(p => { const el = document.getElementById('panel-' + p); if (el) el.style.display = 'none'; });
    }
    function resetForm() {
      phoneInput.disabled = false;
      submitBtn.disabled  = false;
      submitBtn.innerHTML = '{{ __("Send Payment Request to Phone") }} <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>';
    }

    // Retry / stop buttons
    ['retry-btn-cancelled','retry-btn-failed','retry-btn-timeout','retry-btn-stopped'].forEach(id => {
      document.getElementById(id)?.addEventListener('click', () => { hideAllPanels(); resetForm(); phoneInput.focus(); });
    });
    document.getElementById('stop-waiting-btn')?.addEventListener('click', () => {
      if (window._mpesaPoll) { clearInterval(window._mpesaPoll); window._mpesaPoll = null; }
      showPanel('stopped');
      resetForm();
    });

    document.getElementById('mpesa-payment-form').addEventListener('submit', function(e) {
      e.preventDefault();

      const phone            = '254' + document.getElementById('phone-suffix').value.trim();
      const checkoutPlanType = "{{ session('checkout_plan_type') }}";
      const checkoutPlan     = "{{ session('checkout_plan') }}";
      const classifiedId     = "{{ session('classified_id') }}";
      const checkoutAmount   = "{{ session('checkout_amount') }}";

      let purpose = 'membership';
      if (checkoutPlanType === 'classified') purpose = 'classified';
      else if (checkoutPlanType === 'wallet') purpose = 'wallet';

      // Lock form
      phoneInput.disabled = true;
      submitBtn.disabled  = true;
      submitBtn.innerHTML = '{{ __("Sending Request…") }} <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
      hideAllPanels();

      fetch("{{ route('payment.initiate') }}", {
        method:  'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
        body: JSON.stringify({ phone, purpose, amount: checkoutAmount, plan_type: checkoutPlanType, plan_days: checkoutPlan, classified_id: classifiedId })
      })
      .then(r => r.json())
      .then(data => {
        if (!data.success) {
          document.getElementById('panel-failed-reason').textContent = data.message || 'Could not initiate payment. Please try again.';
          showPanel('failed');
          resetForm();
          return;
        }

        // STK push sent — show waiting panel and start polling
        showPanel('waiting');
        // Remove the button spinner — the waiting card has its own spinner
        submitBtn.innerHTML = `{{ __('Send Payment Request to Phone') }} <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>`;
        let pollCount = 0;
        const maxPolls = 40; // 40 × 3 s = 2 min

        window._mpesaPoll = setInterval(() => {
          pollCount++;

          if (pollCount > maxPolls) {
            clearInterval(window._mpesaPoll); window._mpesaPoll = null;
            showPanel('timeout');
            resetForm();
            return;
          }

          fetch('/payment/status/' + data.reference)
          .then(res => res.json())
          .then(s => {
            if (s.status === 'completed') {
              clearInterval(window._mpesaPoll); window._mpesaPoll = null;
              showPanel('success');
              setTimeout(() => {
                if (purpose === 'classified')  window.location.href = "{{ route('profile.edit') }}#tab-classifieds";
                else if (purpose === 'wallet') window.location.href = "{{ route('wallet.add') }}";
                else                           window.location.href = "{{ route('profile.edit') }}#tab-membership";
              }, 2000);

            } else if (s.status === 'failed') {
              clearInterval(window._mpesaPoll); window._mpesaPoll = null;

              if (s.is_cancelled) {
                showPanel('cancelled');
              } else {
                const raw = s.failure_reason || '';
                const isBalance = /insufficient|balance|funds/i.test(raw);
                document.getElementById('panel-failed-reason').textContent = isBalance
                  ? 'Your M-Pesa account has insufficient balance to complete this payment. Top up and try again.'
                  : (raw || 'The payment could not be completed. Please try again.');
                showPanel('failed');
              }
              resetForm();
            }
          })
          .catch(err => console.error('Polling error:', err));
        }, 3000);
      })
      .catch(err => {
        console.error('Payment initiation error:', err);
        document.getElementById('panel-failed-reason').textContent = 'An unexpected error occurred. Please check your connection and try again.';
        showPanel('failed');
        resetForm();
      });
    });
  </script>
</body>
</html>

