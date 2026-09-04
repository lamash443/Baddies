<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Chat Memberships - Baddies Club</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; }
    html, body { margin: 0; padding: 0; font-family: "Outfit", sans-serif; background: #0d0d0d; color: #fff; min-height: 100vh; }

    /* HEADER */
    .page-header { padding: 3rem 0 2rem; border-bottom: 1px solid rgba(255,140,0,0.12); margin-bottom: 3rem; }
    .page-title { font-size: clamp(2rem, 5vw, 3rem); font-weight: 900; letter-spacing: -0.03em; line-height: 1.1; margin-bottom: 0.5rem; }
    .page-title span { background: linear-gradient(135deg,#ff8c00,#ffb347); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    .page-sub { font-size: 1rem; color: rgba(255,255,255,0.5); }

    /* INFO CARDS (balance + active plan) */
    .info-card {
      background: rgba(17,17,17,0.9); backdrop-filter: blur(15px);
      border: 1px solid rgba(255,140,0,0.2); border-radius: 18px; padding: 1.75rem;
      box-shadow: 0 8px 32px rgba(0,0,0,0.4); height: 100%;
    }
    .info-card-label { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: rgba(255,255,255,0.45); margin-bottom: 0.35rem; }
    .info-card-value { font-size: 2rem; font-weight: 900; color: #fff; line-height: 1.1; }

    /* PLAN CARDS */
    .plan-card {
      background: rgba(17,17,17,0.85); backdrop-filter: blur(12px);
      border: 1px solid rgba(255,255,255,0.08); border-radius: 18px;
      padding: 2rem 1.5rem; position: relative; overflow: hidden;
      transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
      display: flex; flex-direction: column;
    }
    .plan-card:hover {
      transform: translateY(-6px);
      border-color: rgba(255,140,0,0.45);
      box-shadow: 0 20px 60px rgba(255,140,0,0.12);
    }
    .plan-card.featured {
      border-color: rgba(255,140,0,0.5);
      background: linear-gradient(145deg, rgba(255,140,0,0.08), rgba(17,17,17,0.95));
      box-shadow: 0 8px 40px rgba(255,140,0,0.15);
    }
    .plan-card.featured::before {
      content: 'POPULAR';
      position: absolute; top: 16px; right: -26px;
      background: linear-gradient(135deg,#ff8c00,#ffb347);
      color: #000; font-size: 0.6rem; font-weight: 900; letter-spacing: 1.5px;
      padding: 4px 36px; transform: rotate(45deg); transform-origin: center;
    }

    .plan-days {
      font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 2px;
      color: rgba(255,140,0,0.8); margin-bottom: 0.5rem;
    }
    .plan-price {
      font-size: 2.4rem; font-weight: 900; line-height: 1; color: #fff; margin-bottom: 0.25rem;
    }
    .plan-price sup { font-size: 1rem; font-weight: 600; vertical-align: super; color: orange; }
    .plan-per { font-size: 0.8rem; color: rgba(255,255,255,0.45); margin-bottom: 1.5rem; }

    .plan-feature { font-size: 0.87rem; color: rgba(255,255,255,0.7); display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.6rem; }
    .plan-feature svg { flex-shrink: 0; color: #28a745; }

    .btn-plan {
      display: flex; align-items: center; justify-content: center; gap: 0.4rem;
      background: transparent; border: 2px solid orange; color: orange;
      padding: 0.7rem 1.2rem; border-radius: 10px; font-size: 0.9rem; font-weight: 700;
      font-family: "Outfit", sans-serif; text-decoration: none; transition: all 0.3s ease;
      cursor: pointer; margin-top: auto;
    }
    .btn-plan:hover { background: orange; color: #000; box-shadow: 0 0 20px rgba(255,165,0,0.4); transform: translateY(-1px); }
    .plan-card.featured .btn-plan { background: orange; color: #000; }
    .plan-card.featured .btn-plan:hover { background: #ffb347; box-shadow: 0 0 24px rgba(255,165,0,0.55); }

    /* Active plan card */
    .active-plan-card {
      background: linear-gradient(135deg, rgba(40,167,69,0.1), rgba(40,167,69,0.04));
      border: 1px solid rgba(40,167,69,0.4);
      border-radius: 18px; padding: 1.75rem;
      box-shadow: 0 8px 32px rgba(40,167,69,0.1);
      height: 100%;
    }

    /* Section heading */
    .section-label {
      font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 2px;
      color: rgba(255,140,0,0.7); margin-bottom: 0.5rem;
    }
    .section-title { font-size: 1.7rem; font-weight: 900; color: #fff; margin-bottom: 0.4rem; }
    .section-sub { font-size: 0.9rem; color: rgba(255,255,255,0.5); }

    /* Divider */
    .orange-divider { height: 3px; width: 48px; background: linear-gradient(90deg,#ff8c00,#ffb347); border-radius: 2px; margin-bottom: 2rem; }

    /* LIGHT THEME OVERRIDES */
    [data-bs-theme="light"] body {
      background: #f4f5f8 !important;
      color: #111111 !important;
    }
    [data-bs-theme="light"] .page-header {
      border-bottom-color: rgba(0,0,0,0.08) !important;
    }
    [data-bs-theme="light"] .page-title {
      color: #111111 !important;
    }
    [data-bs-theme="light"] .page-sub {
      color: rgba(0,0,0,0.6) !important;
    }
    [data-bs-theme="light"] .info-card {
      background: #ffffff !important;
      border: 1px solid rgba(0,0,0,0.08) !important;
      box-shadow: 0 4px 20px rgba(0,0,0,0.04) !important;
      color: #111111 !important;
    }
    [data-bs-theme="light"] .info-card-label {
      color: rgba(0,0,0,0.5) !important;
    }
    [data-bs-theme="light"] .info-card-value {
      color: #111111 !important;
    }
    [data-bs-theme="light"] .active-plan-card {
      background: linear-gradient(135deg, rgba(40,167,69,0.08), rgba(40,167,69,0.02)) !important;
      border-color: rgba(40,167,69,0.3) !important;
      color: #111111 !important;
    }
    [data-bs-theme="light"] .plan-card {
      background: #ffffff !important;
      border: 1px solid rgba(0,0,0,0.08) !important;
      box-shadow: 0 4px 20px rgba(0,0,0,0.04) !important;
      color: #111111 !important;
    }
    [data-bs-theme="light"] .plan-card:hover {
      border-color: rgba(255,140,0,0.5) !important;
      box-shadow: 0 12px 40px rgba(255,140,0,0.12) !important;
    }
    [data-bs-theme="light"] .plan-card.featured {
      background: linear-gradient(145deg, rgba(255,140,0,0.06), #ffffff) !important;
      border-color: rgba(255,140,0,0.5) !important;
    }
    [data-bs-theme="light"] .plan-price {
      color: #111111 !important;
    }
    [data-bs-theme="light"] .plan-per {
      color: rgba(0,0,0,0.55) !important;
    }
    [data-bs-theme="light"] .plan-feature {
      color: rgba(0,0,0,0.75) !important;
    }
    [data-bs-theme="light"] .section-title {
      color: #111111 !important;
    }
    [data-bs-theme="light"] .section-sub {
      color: rgba(0,0,0,0.6) !important;
    }
    [data-bs-theme="light"] .text-secondary {
      color: #666666 !important;
    }
    [data-bs-theme="light"] div[style*="background:rgba(255,255,255,0.03)"] {
      background: rgba(0,0,0,0.03) !important;
      border-color: rgba(0,0,0,0.08) !important;
    }
    [data-bs-theme="light"] svg[stroke="rgba(255,255,255,0.3)"] {
      stroke: rgba(0,0,0,0.3) !important;
    }
  </style>
</head>
<body>

  <x-navbar :hideSearch="true" />

  <!-- HEADER -->
  <div class="page-header">
    <div class="container text-center">
      <h1 class="page-title">Chat <span>Memberships</span></h1>
      <p class="page-sub">{{ __('Unlock unlimited conversations. Choose the plan that fits you.') }}</p>
    </div>
  </div>

  <div class="container pb-5 mb-5">

    <!-- TOP ROW: Wallet Balance + Active Plan -->
    <div class="row g-4 mb-5">
      <!-- Wallet Balance Card -->
      <div class="col-12 col-md-6">
        <div class="info-card">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div style="width:44px;height:44px;border-radius:12px;background:rgba(255,140,0,0.12);border:1.5px solid rgba(255,140,0,0.3);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
            </div>
            <div>
              <div class="info-card-label">Available Balance</div>
              <div class="info-card-value">KSh {{ Auth::check() ? number_format(Auth::user()->wallet_balance ?? 0, 2) : '0.00' }}</div>
            </div>
          </div>
          <p class="text-secondary small mb-3">Use your wallet balance to subscribe instantly — no MPESA needed.</p>
          <a href="{{ route('wallet.add') }}" class="btn btn-plan w-100">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Funds
          </a>
        </div>
      </div>

      <!-- Active Chat Plan -->
      <div class="col-12 col-md-6">
        @if(Auth::check() && Auth::user()->hasActiveChatSubscription())
          <div class="active-plan-card">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div style="width:44px;height:44px;border-radius:12px;background:rgba(40,167,69,0.15);border:1.5px solid rgba(40,167,69,0.4);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#28a745" stroke-width="2.5" stroke-linecap="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
              </div>
              <div>
                <div class="info-card-label" style="color:rgba(40,167,69,0.8);">Active Chat Plan</div>
                <div class="info-card-value" style="color:#28a745;">{{ ucwords(str_replace('_',' ', Auth::user()->chat_plan)) }}</div>
              </div>
            </div>
            <div class="d-flex align-items-center gap-2 text-secondary small">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              Expires: <span class="text-warning fw-bold ms-1">{{ Auth::user()->chat_expires_at ? Auth::user()->chat_expires_at->format('d M Y, h:i A') : 'Never' }}</span>
            </div>
          </div>
        @else
          <div class="info-card d-flex flex-column align-items-center justify-content-center text-center" style="min-height:160px;">
            <div style="width:52px;height:52px;border-radius:50%;background:rgba(255,255,255,0.03);border:1.5px dashed rgba(255,255,255,0.12);display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.3)" stroke-width="1.5" stroke-linecap="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div class="text-secondary fw-medium">No Active Chat Plan</div>
            <div class="small text-secondary opacity-75 mt-1">Subscribe below to start chatting</div>
          </div>
        @endif
      </div>
    </div>

    <!-- PLAN CARDS -->
    <div class="mb-4">
      <div class="section-label">Choose a Plan</div>
      <h2 class="section-title">Chat Subscription Plans</h2>
      <div class="orange-divider"></div>
    </div>

    @php
      $chatPricing = $chatPlan?->pricing ?? [];
      $featuredDays = 7;
      $labels = [1 => '24-hour access', 3 => 'Weekend pass', 7 => 'Full week access', 15 => 'Half-month pass', 30 => 'Full month pass'];
      $chatFeatures = $chatPlan?->features ?? ['Full chat access', 'Instant activation'];
      $planKeys = array_keys($chatPricing);
      $maxDays = $planKeys ? max($planKeys) : 30;
    @endphp
    <div class="row g-3">
      @foreach($chatPricing as $days => $price)
        @php $isFeatured = (int)$days === $featuredDays; @endphp
        <div class="col-12 col-sm-6 col-lg d-flex">
          <div class="plan-card {{ $isFeatured ? 'featured' : '' }} w-100">
            <div class="plan-days">{{ $days }} {{ (int)$days === 1 ? 'Day' : 'Days' }}</div>
            <div class="plan-price"><sup>KSh</sup>{{ number_format($price) }}</div>
            <div class="plan-per">for {{ $days }} {{ (int)$days === 1 ? 'day' : 'days' }} · {{ (int)$days === $maxDays ? 'best value' : 'billed once' }}</div>
            @foreach($chatFeatures as $feature)
              <div class="plan-feature">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
                {{ $feature }}
              </div>
            @endforeach
            @if(isset($labels[$days]))
              <div class="plan-feature">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
                {{ $labels[$days] }}
              </div>
            @endif
            <a href="{{ route('chat.checkout') }}" class="btn-plan mt-3">Get Started</a>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  <x-footer />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
