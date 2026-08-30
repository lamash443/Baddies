<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Funds - Baddies Club</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing:border-box; }
    html, body { margin:0; padding:0; font-family:"Outfit",sans-serif; background:#0d0d0d; color:#fff; min-height:100vh; }

    /* HEADER */
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
    .dash-card-text  { font-size:0.9rem; color:rgba(255,255,255,0.6); margin-bottom:1.5rem; line-height:1.5; }

    /* FORMS */
    .form-label { font-size:0.95rem; font-weight:600; color:rgba(255,255,255,0.85); margin-bottom:0.5rem; }
    .form-control, .form-select {
      background-color:rgba(0,0,0,0.35); border:1px solid rgba(255,140,0,0.25);
      color:#fff; padding:0.85rem 1rem; border-radius:10px; font-size:1rem; font-family:"Outfit",sans-serif;
      transition: border-color 0.25s, box-shadow 0.25s;
    }
    .form-control:focus, .form-select:focus {
      background-color:rgba(0,0,0,0.55); border-color:orange;
      box-shadow:0 0 0 3px rgba(255,165,0,0.18); color:#fff;
    }
    .form-control::placeholder { color:rgba(255,255,255,0.35); }
    .form-control option, .form-select option { background-color:#111; color:#fff; }

    /* AMOUNT FIELD PREFIX */
    .input-group-text {
      background: rgba(255,140,0,0.12); border:1px solid rgba(255,140,0,0.25);
      border-right:none; color:orange; font-weight:700; font-size:1rem; border-radius:10px 0 0 10px;
    }
    .input-group .form-control { border-left:none; border-radius:0 10px 10px 0; }

    /* ── UNIFIED BUTTON STYLE (matches /profile & /dashboard) ── */
    .btn-orange {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.45rem;
      background: transparent;
      border: 2px solid orange;
      color: orange;
      padding: 0.85rem 1.5rem;
      border-radius: 10px;
      font-size: 1rem;
      font-weight: 700;
      font-family: "Outfit", sans-serif;
      text-decoration: none;
      transition: all 0.3s ease;
      cursor: pointer;
      letter-spacing: 0.02em;
      width: 100%;
    }
    .btn-orange:hover {
      background: orange;
      color: #000;
      border-color: orange;
      box-shadow: 0 0 18px 4px rgba(255,165,0,0.55), 0 0 35px rgba(255,165,0,0.25);
      transform: translateY(-1px);
    }
    .btn-orange:active {
      transform: translateY(0);
      box-shadow: 0 0 10px 2px rgba(255,165,0,0.4);
    }

    /* FEE NOTE */
    .fee-note {
      display:inline-flex; align-items:center; gap:0.4rem;
      background:rgba(255,140,0,0.07); border:1px solid rgba(255,140,0,0.2);
      border-radius:8px; padding:0.5rem 0.9rem; font-size:0.85rem; color:rgba(255,255,255,0.6);
    }
    .fee-note strong { color:orange; }

    /* SUMMARY ROWS */
    .summary-row { display:flex; justify-content:space-between; align-items:center; padding:0.75rem 0; }
    .summary-row:not(:last-child) { border-bottom:1px solid rgba(255,255,255,0.07); }
    .summary-label { font-size:0.95rem; color:rgba(255,255,255,0.6); }
    .summary-value { font-size:1rem; font-weight:600; color:#fff; }
    .summary-total-label { font-size:1.1rem; font-weight:700; color:#fff; }
    .summary-total-value { font-size:1.4rem; font-weight:800; color:orange; }

    /* SIDEBAR NAV CARD */
    .side-nav-card {
      background: rgba(17,17,17,0.85); backdrop-filter: blur(15px);
      border: 1px solid rgba(255,140,0,0.2); border-radius: 18px;
      padding: 1.25rem; box-shadow: 0 8px 32px rgba(0,0,0,0.5);
      position: sticky; top: 1.5rem;
    }
    .side-nav-title {
      font-size: 0.7rem; font-weight: 800; letter-spacing: 2px;
      text-transform: uppercase; color: rgba(255,255,255,0.35);
      padding: 0 0.5rem 0.75rem; margin-bottom: 0.5rem;
      border-bottom: 1px solid rgba(255,140,0,0.12);
    }
    .side-nav-link {
      display: flex; align-items: center; gap: 0.75rem;
      padding: 0.7rem 0.85rem; border-radius: 10px;
      color: rgba(255,255,255,0.72); text-decoration: none;
      font-size: 0.92rem; font-weight: 500;
      transition: background 0.2s, color 0.2s;
      margin-bottom: 2px;
    }
    .side-nav-link:hover {
      background: rgba(255,140,0,0.1); color: orange;
    }
    .side-nav-link svg { flex-shrink: 0; opacity: 0.8; }
    .side-nav-link:hover svg { opacity: 1; }
    .side-nav-link.active {
      background: rgba(255,140,0,0.15); color: orange;
      font-weight: 700;
    }
    .side-nav-link.active svg { opacity: 1; }

    /* LIGHT THEME */
    [data-bs-theme="light"] body { background:#f9f9f9; color:#111; }
    [data-bs-theme="light"] .dash-card { background:#fff; border-color:rgba(255,140,0,0.3); box-shadow:0 5px 20px rgba(0,0,0,0.05); }
    [data-bs-theme="light"] .dash-card-title { color:#000; }
    [data-bs-theme="light"] .dash-card-text { color:rgba(0,0,0,0.6); }
    [data-bs-theme="light"] .form-control, [data-bs-theme="light"] .form-select { background:#fff; color:#000; }
    [data-bs-theme="light"] .summary-label { color:rgba(0,0,0,0.6); }
    [data-bs-theme="light"] .summary-value { color:#000; }
    [data-bs-theme="light"] .summary-total-label { color:#000; }
    [data-bs-theme="light"] .side-nav-card { background:#fff; border-color:rgba(255,140,0,0.3); }
    [data-bs-theme="light"] .side-nav-link { color:rgba(0,0,0,0.65); }
    [data-bs-theme="light"] .side-nav-link:hover { background:rgba(255,140,0,0.08); color:orange; }
  </style>
</head>
<body>

  <!-- NAVBAR -->
  <x-navbar :hideSearch="true" />

  <!-- HEADER -->
  <div class="dashboard-header">
    <div class="container text-center">
      <h1 class="dashboard-title">My <span>Wallet</span></h1>
      <nav aria-label="breadcrumb" class="d-flex justify-content-center mt-3">
        <ol class="breadcrumb mb-0 justify-content-center flex-wrap text-center">
          <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-warning text-decoration-none fw-bold">{{ __('Home') }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('profile.edit') }}#tab-membership" class="text-warning text-decoration-none fw-bold">{{ __('My Membership') }}</a></li>
          <li class="breadcrumb-item active text-secondary" aria-current="page">{{ __('Add Fund/Checkout - MPESA') }}</li>
        </ol>
      </nav>
    </div>
  </div>

  <div class="container pb-5 mb-5">
    <div class="row g-4 align-items-start">

      <!-- SIDEBAR NAV -->
      <div class="col-12 col-lg-3 mb-4 mb-lg-0">
        <div class="side-nav-card">
          <div class="side-nav-title">My Account</div>

          <a href="{{ route('dashboard') }}" class="side-nav-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            Dashboard
          </a>

          <a href="{{ route('chat.index') }}" class="side-nav-link d-flex justify-content-between align-items-center">
            <span>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
              Messages
            </span>
            @php
              $unreadCount = auth()->user()->messagesReceived()->where('is_read', false)->count();
            @endphp
            @if($unreadCount > 0)
              <span class="badge bg-danger rounded-pill">{{ $unreadCount }}</span>
            @endif
          </a>

          <a href="{{ route('profile.edit') }}" class="side-nav-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
            My Profile
          </a>

          <a href="{{ route('wallet.add') }}" class="side-nav-link active">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
            My Wallet
          </a>

          <a href="{{ route('profile.edit') }}#tab-membership" class="side-nav-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2Z"/></svg>
            My Membership
          </a>

          <a href="{{ url('/classifieds') }}" class="side-nav-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            My Classifieds
          </a>

          <a href="{{ route('profile.edit') }}#tab-photos" class="side-nav-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            Publish Photos &amp; Videos
          </a>

          <a href="{{ route('profile.edit') }}#tab-settings" class="side-nav-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
            My Settings
          </a>

          <a href="{{ route('profile.edit') }}#tab-verification" class="side-nav-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>
            Photo Verification
          </a>
        </div>
      </div>

      <!-- MAIN CONTENT -->
      <div class="col-12 col-lg-9" id="main-content-area">

        <!-- Available Balance Card -->
        <div class="dash-card mb-4">
          <header>
            <h2 class="dash-card-title">{{ __('Available Wallet Balance') }}</h2>
            <p class="dash-card-text mb-0">{{ __('Your current funds available for memberships and features.') }}</p>
          </header>
          <div class="d-flex align-items-center justify-content-between p-4 mt-3 rounded" style="background:rgba(255,140,0,0.05); border:1px solid rgba(255,140,0,0.2);">
            <div>
              <div class="text-secondary small text-uppercase fw-bold" style="letter-spacing:1px;">{{ __('Balance') }}</div>
              <div class="fs-1 fw-bold text-light mt-1">KSh {{ number_format(auth()->user()->wallet_balance ?? 0, 2) }}</div>
            </div>
            <div class="d-flex align-items-center justify-content-center rounded-circle" style="width:64px;height:64px;background:rgba(255,140,0,0.1);border:2px solid rgba(255,140,0,0.3);">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
            </div>
          </div>
        </div>

        <!-- Add Funds Form -->
        <div class="dash-card" style="border-top: 4px solid orange;">
          <!-- Stepper -->
          <div class="stepper d-flex justify-content-between align-items-center mb-5 position-relative px-3 mt-2">
            <div class="stepper-line position-absolute top-50 start-0 end-0 translate-middle-y" style="height: 2px; background: rgba(255,255,255,0.1); z-index: 1;"></div>
            
            <div class="step text-center position-relative" style="z-index: 2;">
              <div class="step-circle bg-orange text-dark rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 40px; height: 40px; font-weight: bold; border: 4px solid #111; box-shadow: 0 0 15px rgba(255,165,0,0.5); background: orange;">1</div>
              <div class="step-label text-warning small fw-bold text-uppercase" style="letter-spacing:1px; font-size: 0.75rem;">Amount</div>
            </div>

            <div class="step text-center position-relative" style="z-index: 2;">
              <div class="step-circle bg-dark text-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 40px; height: 40px; font-weight: bold; border: 2px solid rgba(255,255,255,0.1); background: #111;">2</div>
              <div class="step-label text-secondary small fw-bold text-uppercase" style="letter-spacing:1px; font-size: 0.75rem;">PIN Prompt</div>
            </div>

            <div class="step text-center position-relative" style="z-index: 2;">
              <div class="step-circle bg-dark text-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 40px; height: 40px; font-weight: bold; border: 2px solid rgba(255,255,255,0.1); background: #111;">3</div>
              <div class="step-label text-secondary small fw-bold text-uppercase" style="letter-spacing:1px; font-size: 0.75rem;">Confirm</div>
            </div>
          </div>

          <header class="mb-4 text-center">
            <h2 class="dash-card-title">{{ __('Add Funds to your Wallet') }}</h2>
            <p class="dash-card-text mb-0">{{ __('Enter the amount you wish to add. Funds are credited instantly upon payment.') }}</p>
          </header>

          <form action="{{ url('/wallet/add-funds') }}" method="POST" id="add-funds-form">
            @csrf

            <div class="mb-4">
              <label class="form-label">{{ __('Amount') }} <span class="text-secondary fw-normal" style="font-size:0.85rem;">({{ __('Minimum: KSh 10') }})</span></label>
              <div class="input-group">
                <span class="input-group-text">KSh</span>
                <input type="number" id="amount-input" name="amount" class="form-control" min="10" step="1" placeholder="e.g. 500" required />
              </div>
              <div id="amount-error" class="mt-2 text-danger small" style="display:none;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="me-1"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ __('Minimum deposit amount is KSh 10.') }}
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label">{{ __('Payment Method') }}</label>
              <select class="form-select" name="payment_method">
                <option value="mpesa">MPESA</option>
              </select>
              <div class="mt-2">
                <span class="fee-note">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                  {{ __('Transaction Fee:') }} <strong>0% + 0</strong> &mdash; {{ __('No hidden charges on MPESA.') }}
                </span>
              </div>
            </div>

            <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">

            <!-- Live Summary -->
            <div class="p-4 rounded mb-4" style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.1);">
              <div class="summary-row">
                <span class="summary-label">{{ __('Transaction Fee:') }}</span>
                <span class="summary-value" id="fee-display">KSh 0.00</span>
              </div>
              <div class="summary-row">
                <span class="summary-total-label">{{ __('Total:') }}</span>
                <span class="summary-total-value" id="total-display">KSh 0.00</span>
              </div>
            </div>

            <div class="d-flex justify-content-end">
              <button type="submit" class="btn-orange px-5 py-3 fs-5 w-100" style="border-radius:12px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                {{ __('Add Funds') }}
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
    document.addEventListener("DOMContentLoaded", function() {
      // On mobile (less than 992px), scroll down to the main content area on load
      if (window.innerWidth < 992) {
        const mainContent = document.getElementById('main-content-area');
        if (mainContent) {
          setTimeout(() => {
            mainContent.scrollIntoView({ behavior: 'smooth', block: 'start' });
          }, 200);
        }
      }
    });

    const amountInput  = document.getElementById('amount-input');
    const feeDisplay   = document.getElementById('fee-display');
    const totalDisplay = document.getElementById('total-display');
    const amountError  = document.getElementById('amount-error');
    const addFundsForm = document.getElementById('add-funds-form');
    const MIN_AMOUNT   = 10;

    function formatKsh(amount) {
      return 'KSh ' + parseFloat(amount).toLocaleString('en-KE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function updateSummary() {
      const amount = parseFloat(amountInput.value) || 0;
      const fee    = 0; // 0% + 0
      const total  = amount + fee;

      feeDisplay.textContent   = formatKsh(fee);
      totalDisplay.textContent = formatKsh(total);

      if (amountInput.value !== '' && amount < MIN_AMOUNT) {
        amountError.style.display = 'block';
        amountInput.style.borderColor = '#ff4d4d';
        amountInput.style.boxShadow   = '0 0 0 3px rgba(255,77,77,0.15)';
      } else {
        amountError.style.display = 'none';
        amountInput.style.borderColor = '';
        amountInput.style.boxShadow   = '';
      }
    }

    addFundsForm.addEventListener('submit', function(e) {
      const amount = parseFloat(amountInput.value) || 0;
      if (amount < MIN_AMOUNT) {
        e.preventDefault();
        amountError.style.display = 'block';
        amountInput.focus();
      }
    });

    amountInput.addEventListener('input', updateSummary);
    updateSummary();
  </script>
</body>
</html>
