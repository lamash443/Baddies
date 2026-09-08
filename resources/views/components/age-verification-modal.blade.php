<style>
  .age-modal-overlay {
    position: fixed;
    inset: 0;
    z-index: 999999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    background: rgba(0, 0, 0, 0.85);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
  }

  .age-modal-overlay.active {
    opacity: 1;
    visibility: visible;
  }

  .age-modal-card {
    position: relative;
    width: 100%;
    max-width: 480px;
    background: #000000 !important;
    border: 1px solid rgba(255, 140, 0, 0.5) !important;
    box-shadow: 0 0 40px rgba(255, 140, 0, 0.25) !important;
    border-radius: 1.5rem !important;
    padding: 2.25rem 2rem 2.5rem;
    text-align: center;
    color: #ffffff;
    font-family: "Outfit", ui-sans-serif, system-ui, -apple-system, sans-serif;
    transform: scale(0.95);
    transition: transform 0.3s ease;
    overflow: hidden;
  }

  @media (max-width: 767.98px) {
    .age-modal-card {
      border-radius: 1.25rem !important;
      padding: 1.75rem 1.5rem 2rem;
    }
  }

  .age-modal-overlay.active .age-modal-card {
    transform: scale(1);
  }

  .age-brand-header {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.25rem;
    font-weight: 800;
    font-size: 1.5rem;
    margin-bottom: 1.25rem;
  }

  .age-badge-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: rgba(255, 140, 0, 0.12);
    border: 1px solid rgba(255, 140, 0, 0.4);
    color: #ff8c00;
    margin-bottom: 1rem;
    box-shadow: 0 0 20px rgba(255, 140, 0, 0.2);
  }

  .age-modal-title {
    font-size: 1.5rem;
    font-weight: 800;
    color: #ffffff;
    margin-bottom: 0.65rem;
  }

  .age-modal-sub {
    font-size: 0.95rem;
    color: rgba(255, 255, 255, 0.7);
    line-height: 1.6;
    margin-bottom: 1.5rem;
  }

  .age-modal-sub strong {
    color: #ff8c00;
  }

  .age-requirements-box {
    background: rgba(0, 0, 0, 0.4) !important;
    border: 1px solid rgba(255, 140, 0, 0.25) !important;
    border-radius: 0.75rem !important;
    padding: 1rem 1.15rem;
    margin-bottom: 1.75rem;
    text-align: left;
    display: flex;
    flex-direction: column;
    gap: 0.65rem;
  }

  .age-req-item {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    font-size: 0.88rem;
    color: rgba(255, 255, 255, 0.85);
  }

  .age-req-item svg {
    flex-shrink: 0;
    color: #ff8c00;
  }

  .age-modal-actions {
    display: flex;
    flex-direction: column;
    gap: 0.85rem;
  }

  .btn-age-confirm-lg {
    background: #ff8c00;
    border: 2px solid #ff8c00;
    color: #000;
    font-weight: 700;
    font-size: 1rem;
    padding: 0.75rem 1.5rem;
    border-radius: 0.75rem;
    transition: all 0.3s ease;
    letter-spacing: 0.02em;
    cursor: pointer;
    width: 100%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
  }

  .btn-age-confirm-lg:hover {
    background-color: #000000 !important;
    border-color: #ff8c00 !important;
    color: #ffffff !important;
    box-shadow: 0 4px 15px rgba(255, 140, 0, 0.4) !important;
    transform: translateY(-1px);
  }

  .btn-age-decline-lg {
    background: transparent;
    border: 2px solid #ff8c00;
    color: #fff;
    font-weight: 700;
    font-size: 1rem;
    padding: 0.75rem 1.5rem;
    border-radius: 0.75rem;
    transition: all 0.3s ease;
    letter-spacing: 0.02em;
    cursor: pointer;
    width: 100%;
  }

  .btn-age-decline-lg:hover {
    background-color: #000000 !important;
    border-color: #ff8c00 !important;
    color: #ffffff !important;
    box-shadow: 0 4px 15px rgba(255, 140, 0, 0.4) !important;
    transform: translateY(-1px);
  }

  .age-denied-box {
    display: none;
    padding: 1.25rem 0.5rem;
    text-align: center;
  }

  .age-denied-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: rgba(220, 53, 69, 0.15);
    border: 1px solid rgba(220, 53, 69, 0.4);
    color: #ff4d4d;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
  }

  .age-denied-title {
    font-size: 1.4rem;
    font-weight: 800;
    color: #ff4d4d;
    margin-bottom: 0.5rem;
  }

  .age-denied-text {
    font-size: 0.92rem;
    color: rgba(255, 255, 255, 0.75);
    line-height: 1.6;
    margin-bottom: 1.5rem;
  }
</style>

<div id="ageVerificationOverlay" class="age-modal-overlay" role="dialog" aria-modal="true" aria-labelledby="ageModalTitle">
  <div class="age-modal-card">
    
    <div id="ageModalMainContent">
      <!-- Brand Logo Header matching uploaded admin logo -->
      <div class="age-brand-header">
        @php
          $ageModalLogo = \App\Models\SiteSetting::get('logo');
        @endphp
        @if(!empty($ageModalLogo) && \Illuminate\Support\Facades\Storage::disk('public')->exists($ageModalLogo))
          <img src="{{ asset('storage/' . $ageModalLogo) }}" alt="Logo" style="max-height:45px;width:auto;object-fit:contain;">
        @else
          <span style="color:#ff8c00;">Baddies-</span><span style="color:#fff;">Club</span>
        @endif
      </div>

      <div class="age-badge-icon">
        <span style="font-size: 2.1rem; font-weight: 900; line-height: 1;">18+</span>
      </div>

      <h2 id="ageModalTitle" class="age-modal-title">Age Verification</h2>
      
      <p class="age-modal-sub">
        This website contains adult-themed material strictly intended for consenting adults. You must be at least <strong>18 years of age</strong> to enter.
      </p>

      <div class="age-requirements-box">
        <div class="age-req-item">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
          </svg>
          <span>I am 18 years of age or older.</span>
        </div>
        <div class="age-req-item">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
          </svg>
          <span>I agree to view adult listings voluntarily.</span>
        </div>
        <div class="age-req-item">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
          </svg>
          <span>Viewing adult material is legal in my area.</span>
        </div>
      </div>

      <div class="age-modal-actions">
        <button type="button" id="btnAgeConfirm" class="btn-age-confirm-lg">
          <span>I Am 18 or Older – Enter Website</span>
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="5" y1="12" x2="19" y2="12"></line>
            <polyline points="12 5 19 12 12 19"></polyline>
          </svg>
        </button>

        <button type="button" id="btnAgeDecline" class="btn-age-decline-lg">
          I Am Under 18 – Exit
        </button>
      </div>
    </div>

    <!-- Denied state -->
    <div id="ageModalDeniedContent" class="age-denied-box">
      <div class="age-denied-icon">
        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="10"></circle>
          <line x1="15" y1="9" x2="9" y2="15"></line>
          <line x1="9" y1="9" x2="15" y2="15"></line>
        </svg>
      </div>
      <h3 class="age-denied-title">Access Denied</h3>
      <p class="age-denied-text">
        You must be at least 18 years old to access this website. Redirecting you to safety...
      </p>
      <button type="button" onclick="window.location.href='https://www.google.com'" class="btn-age-decline-lg">
        Leave Website Now
      </button>
    </div>

  </div>
</div>

<script>
  (function() {
    const STORAGE_KEY = 'baddies_club_age_verified';
    
    function initAgeVerification() {
      const overlay = document.getElementById('ageVerificationOverlay');
      const btnConfirm = document.getElementById('btnAgeConfirm');
      const btnDecline = document.getElementById('btnAgeDecline');
      const mainContent = document.getElementById('ageModalMainContent');
      const deniedContent = document.getElementById('ageModalDeniedContent');

      if (!overlay || !btnConfirm || !btnDecline) return;

      const isVerified = localStorage.getItem(STORAGE_KEY) === 'true';

      if (!isVerified) {
        document.body.style.overflow = 'hidden';
        overlay.classList.add('active');
      }

      btnConfirm.addEventListener('click', function() {
        localStorage.setItem(STORAGE_KEY, 'true');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
      });

      btnDecline.addEventListener('click', function() {
        if (mainContent && deniedContent) {
          mainContent.style.display = 'none';
          deniedContent.style.display = 'block';
        }
        setTimeout(function() {
          window.location.href = 'https://www.google.com';
        }, 2200);
      });
    }

    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', initAgeVerification);
    } else {
      initAgeVerification();
    }
  })();
</script>
