
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
<?php
  $alLogo = \App\Models\SiteSetting::get('logo');
  $alLogoExists = !empty($alLogo) && \Illuminate\Support\Facades\Storage::disk('public')->exists($alLogo);
?>

<style>
  /* ── Auto-logout backdrop ── */
  #al-overlay {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 999999;
    background: rgba(0, 0, 0, 0.78);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    align-items: center;
    justify-content: center;
  }
  #al-overlay.al-show {
    display: flex;
    animation: al-fadeIn 0.3s ease forwards;
  }
  @keyframes al-fadeIn {
    from { opacity: 0; }
    to   { opacity: 1; }
  }

  /* ── Card — mirrors auth-modal-content exactly ── */
  #al-card {
    background: #000000;
    border: 1px solid rgba(255, 140, 0, 0.5) !important;
    box-shadow: 0 0 40px rgba(255, 140, 0, 0.25) !important;
    border-radius: 1.5rem;
    max-width: 420px;
    width: 92%;
    text-align: center;
    position: relative;
    overflow: hidden;
    animation: al-slideUp 0.35s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
  }
  @keyframes al-slideUp {
    from { opacity: 0; transform: translateY(28px) scale(0.97); }
    to   { opacity: 1; transform: translateY(0)    scale(1);    }
  }

  /* ── Card header (matches .modal-header) ── */
  #al-header {
    padding: 1.6rem 1.75rem 0.75rem;
    position: relative;
    border-bottom: none;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  #al-logo-wrap {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
    font-size: 1.35rem;
    font-weight: 800;
    font-family: "Outfit", sans-serif;
  }
  #al-logo-wrap img {
    max-height: 60px;
    width: auto;
    object-fit: contain;
  }
  .al-brand-orange { color: #ff8c00; }
  .al-brand-white  { color: #ffffff; }

  /* ── Card body ── */
  #al-body {
    padding: 0.5rem 2rem 2.2rem;
  }

  /* ── Divider ── */
  #al-divider {
    height: 1px;
    background: rgba(255, 140, 0, 0.15);
    margin: 0.6rem 1.75rem 1.4rem;
  }

  /* ── Session icon badge ── */
  #al-badge {
    width: 52px; height: 52px;
    background: rgba(255, 140, 0, 0.1);
    border: 1.5px solid rgba(255, 140, 0, 0.3);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
  }

  /* ── Title & copy ── */
  #al-card h2 {
    font-size: 1.4rem;
    font-weight: 800;
    color: #ffffff;
    margin: 0 0 0.4rem;
    font-family: "Outfit", sans-serif;
    letter-spacing: -0.01em;
  }
  #al-card p {
    font-size: 0.875rem;
    color: rgba(255, 255, 255, 0.6);
    margin: 0 0 1.4rem;
    line-height: 1.65;
    font-family: "Outfit", sans-serif;
  }

  /* ── Countdown ring ── */
  #al-countdown-ring {
    position: relative;
    width: 80px; height: 80px;
    margin: 0 auto 1.5rem;
  }
  #al-countdown-ring svg {
    transform: rotate(-90deg);
  }
  #al-countdown-ring circle.al-bg {
    fill: none;
    stroke: rgba(255, 140, 0, 0.12);
    stroke-width: 5;
  }
  #al-countdown-ring circle.al-prog {
    fill: none;
    stroke: #ff8c00;
    stroke-width: 5;
    stroke-linecap: round;
    stroke-dasharray: 219.9;
    stroke-dashoffset: 0;
    transition: stroke-dashoffset 1s linear, stroke 0.5s ease;
  }
  #al-countdown-number {
    position: absolute;
    inset: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem;
    font-weight: 800;
    color: #ff8c00;
    font-family: "Outfit", sans-serif;
    transition: color 0.5s ease;
  }

  /* ── Primary button (mirrors .btn-orange-lg) ── */
  #al-stay-btn {
    display: block;
    width: 100%;
    background: #ff8c00;
    border: 2px solid #ff8c00;
    color: #000;
    font-weight: 700;
    font-size: 1rem;
    padding: 0.75rem 2rem;
    border-radius: 0.75rem;
    cursor: pointer;
    font-family: "Outfit", sans-serif;
    letter-spacing: 0.02em;
    transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease,
                box-shadow 0.3s ease, transform 0.3s ease;
    margin-bottom: 0.75rem;
  }
  #al-stay-btn:hover {
    background-color: #000000 !important;
    border-color: #ff8c00 !important;
    color: #ffffff !important;
    box-shadow: 0 4px 15px rgba(255, 140, 0, 0.4) !important;
    transform: translateY(-1px);
  }
  #al-stay-btn:active { transform: translateY(0); }

  /* ── Secondary "logout now" link ── */
  #al-logout-now-btn {
    display: block;
    background: transparent;
    border: 2px solid #ff8c00;
    color: #fff;
    font-weight: 700;
    font-size: 0.92rem;
    padding: 0.65rem 2rem;
    border-radius: 0.75rem;
    cursor: pointer;
    font-family: "Outfit", sans-serif;
    letter-spacing: 0.02em;
    width: 100%;
    transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease,
                box-shadow 0.3s ease, transform 0.3s ease;
  }
  #al-logout-now-btn:hover {
    background-color: #000000 !important;
    border-color: #ff8c00 !important;
    color: #ffffff !important;
    box-shadow: 0 4px 15px rgba(255, 140, 0, 0.4) !important;
    transform: translateY(-1px);
  }
  #al-logout-now-btn:active { transform: translateY(0); }

  /* ── Light theme overrides (mirrors auth modal) ── */
  [data-bs-theme="light"] #al-card {
    background: #ffffff !important;
    border-color: rgba(0, 0, 0, 0.1) !important;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08) !important;
  }
  [data-bs-theme="light"] #al-card h2 { color: #111; }
  [data-bs-theme="light"] #al-card p  { color: rgba(0,0,0,0.55); }
  [data-bs-theme="light"] .al-brand-white { color: #111 !important; }
  [data-bs-theme="light"] #al-divider { background: rgba(0,0,0,0.08); }
  [data-bs-theme="light"] #al-badge  {
    background: rgba(255,140,0,0.08);
  }
  [data-bs-theme="light"] #al-logout-now-btn { color: #111; }
</style>


<div id="al-overlay" role="dialog" aria-modal="true" aria-labelledby="al-title">
  <div id="al-card">

    
    <div id="al-header">
      <div id="al-logo-wrap">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($alLogoExists): ?>
          <img src="<?php echo e(asset('storage/' . $alLogo)); ?>" alt="Baddies Club Logo">
        <?php else: ?>
          <span class="al-brand-orange">Baddies-</span><span class="al-brand-white">Club</span>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>
    </div>

    <div id="al-divider"></div>

    
    <div id="al-body">
      <div id="al-badge">⏱️</div>

      <h2 id="al-title">Still there?</h2>
      <p>You've been inactive for a while.<br>You'll be automatically logged out in:</p>

      
      <div id="al-countdown-ring">
        <svg width="80" height="80" viewBox="0 0 80 80">
          <circle class="al-bg"   cx="40" cy="40" r="35"/>
          <circle class="al-prog" id="al-ring-progress" cx="40" cy="40" r="35"/>
        </svg>
        <div id="al-countdown-number">60</div>
      </div>

      <button id="al-stay-btn" onclick="alKeepAlive()">I'm still here</button>
      <button id="al-logout-now-btn" onclick="alDoLogout()">Logout now</button>
    </div>

  </div>
</div>


<form id="al-logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display:none;">
  <?php echo csrf_field(); ?>
</form>

<script>
(function () {
  'use strict';

  const TIMEOUT_MS    = 10 * 60 * 1000;  // ⚠️ TEST: 10 min → change to 30 for prod
  const WARNING_MS    = 9  * 60 * 1000;  // ⚠️ TEST: 9 min  → change to 29 for prod
  const WARNING_SEC   = 60;
  const CIRCUMFERENCE = 2 * Math.PI * 35; // r=35 → ≈ 219.9

  let warningTimer   = null;
  let logoutTimer    = null;
  let countdownTimer = null;
  let countdownSec   = WARNING_SEC;
  let warningShown   = false;

  const overlay    = document.getElementById('al-overlay');
  const ringEl     = document.getElementById('al-ring-progress');
  const numEl      = document.getElementById('al-countdown-number');
  const logoutForm = document.getElementById('al-logout-form');

  // ── Activity events ──────────────────────────────────────────────────────
  const activityEvents = ['mousemove', 'mousedown', 'keydown', 'touchstart', 'scroll', 'click'];
  activityEvents.forEach(evt =>
    document.addEventListener(evt, onActivity, { passive: true })
  );

  function onActivity() {
    if (warningShown) {
      alKeepAlive();
    } else {
      resetTimers();
    }
  }

  // ── Timers ───────────────────────────────────────────────────────────────
  function resetTimers() {
    clearTimeout(warningTimer);
    clearTimeout(logoutTimer);
    warningTimer = setTimeout(showWarning, WARNING_MS);
    logoutTimer  = setTimeout(alDoLogout,  TIMEOUT_MS);
  }

  // ── Show warning ─────────────────────────────────────────────────────────
  function showWarning() {
    warningShown = true;
    countdownSec = WARNING_SEC;
    overlay.classList.add('al-show');
    updateRing(WARNING_SEC);
    numEl.textContent = WARNING_SEC;

    countdownTimer = setInterval(function () {
      countdownSec--;
      if (countdownSec <= 0) {
        clearInterval(countdownTimer);
        alDoLogout();
        return;
      }
      updateRing(countdownSec);
      numEl.textContent = countdownSec;

      // Urgent red at ≤10 s
      if (countdownSec <= 10) {
        ringEl.style.stroke = '#ff3333';
        numEl.style.color   = '#ff3333';
      }
    }, 1000);
  }

  function updateRing(sec) {
    const offset = CIRCUMFERENCE * (1 - sec / WARNING_SEC);
    ringEl.style.strokeDashoffset = offset;
  }

  // ── Keep alive ───────────────────────────────────────────────────────────
  window.alKeepAlive = function () {
    clearInterval(countdownTimer);
    clearTimeout(warningTimer);
    clearTimeout(logoutTimer);
    overlay.classList.remove('al-show');
    warningShown        = false;
    ringEl.style.stroke = '#ff8c00';
    numEl.style.color   = '#ff8c00';
    resetTimers();
  };

  // ── Logout ───────────────────────────────────────────────────────────────
  window.alDoLogout = function () {
    clearInterval(countdownTimer);
    clearTimeout(warningTimer);
    clearTimeout(logoutTimer);
    logoutForm.submit();
  };

  // ── Cross-tab sync (BroadcastChannel) ───────────────────────────────────
  try {
    const bc = new BroadcastChannel('al_activity');
    bc.onmessage = function (e) {
      if (e.data === 'active' && !warningShown) resetTimers();
      if (e.data === 'logout') alDoLogout();
    };
    activityEvents.forEach(evt =>
      document.addEventListener(evt, function () {
        try { bc.postMessage('active'); } catch(_) {}
      }, { passive: true })
    );
  } catch(_) {}

  // ── Boot ─────────────────────────────────────────────────────────────────
  resetTimers();
})();
</script>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH C:\Users\willi\Desktop\Kenyan Baddies Club\resources\views\components\auto-logout.blade.php ENDPATH**/ ?>