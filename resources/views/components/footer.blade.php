<style>
    /* FOOTER */
    .nr-footer {
      background:linear-gradient(160deg,#0d0d0d 0%,#1a0f00 50%,#0d0d0d 100%);
      color:rgba(255,255,255,0.78);
      border-top:2px solid rgba(255,140,0,0.6);
      box-shadow:inset 0 2px 30px rgba(255,140,0,0.06);
    }
    .nr-footer__brand,.nr-footer__title{color:#fff;}
    .nr-footer a {
      color:rgba(255,140,0,0.92); text-decoration:none;
      display:inline-block; position:relative; padding-bottom:3px; transition:color 0.3s ease;
    }
    .nr-footer a::after {
      content:""; position:absolute; left:0; bottom:0;
      width:100%; height:1.5px;
      background:linear-gradient(90deg,rgba(255,255,255,0) 0%,rgba(255,255,255,0.9) 50%,rgba(255,255,255,0) 100%);
      border-radius:2px; transform:scaleX(0); transform-origin:center;
      transition:transform 0.35s cubic-bezier(0.4,0,0.2,1);
    }
    .nr-footer a:hover,.nr-footer a:focus{color:#fff;text-decoration:none;}
    .nr-footer a:hover::after,.nr-footer a:focus::after{transform:scaleX(1);}
    .nr-footer__logo-text {
      font-size:1.6rem; font-weight:800; letter-spacing:-0.5px; line-height:1;
      background:linear-gradient(135deg,#ff8c00,#ffb347);
      -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
      display:inline-block;
    }
    hr.border-light-subtle{border-color:rgba(255,255,255,0.1) !important;}
</style>

<!-- FOOTER -->
<footer class="nr-footer mt-0">
  <div class="container py-5">
    <div class="row g-4">
      <div class="col-12 col-lg-4 text-center text-lg-start">
        <div class="nr-footer__logo mb-3">
          <a href="/" class="text-decoration-none">
            @if(!empty($siteSettings['logo']))
                <img src="{{ asset('storage/' . $siteSettings['logo']) }}" alt="Baddies Club Logo" style="max-height:45px;width:auto;object-fit:contain;">
            @else
                <span class="nr-footer__logo-text">Baddies Club</span>
            @endif
          </a>
        </div>
        <p class="mb-3">Browse trusted local listings, discover providers, and connect faster.</p>
      </div>
      <div class="col-6 col-lg-2">
        <h3 class="nr-footer__title h6">Explore</h3>
        <ul class="list-unstyled mb-0">
          <li class="mb-2"><a href="/#vip-escorts">Escort Girls</a></li>
          <li class="mb-2"><a href="/category/call-boys">Call Boys</a></li>
          <li class="mb-2"><a href="/videos">Videos</a></li>
          <li class="mb-2"><a href="/classifieds">Adult Classifieds</a></li>
        </ul>
      </div>
      <div class="col-6 col-lg-2">
        <h3 class="nr-footer__title h6">Pages</h3>
        <ul class="list-unstyled mb-0">
          <li class="mb-2"><a href="/terms">Terms</a></li>
          <li class="mb-2"><a href="/privacy">Privacy Policy</a></li>
        </ul>
      </div>
      <div class="col-12 col-lg-4">
        <h3 class="nr-footer__title h6">Contact</h3>
        <ul class="list-unstyled mb-3">
          @php $contactPage = \App\Models\Page::where('slug','contact')->first(); @endphp
          @if(!empty($contactPage?->phone))
            <li class="mb-2"><a href="tel:{{ $contactPage->phone }}">{{ $contactPage->phone }}</a></li>
          @endif
          <li class="mb-2"><a href="{{ route('contact') }}">Contact Support</a></li>
        </ul>
      </div>
    </div>
    <hr class="border-light-subtle my-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 small">
      <div>Copyright 2026 Baddies-Club.</div>
      <div>All rights reserved.</div>
    </div>
  </div>
</footer>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    var scrollPosition = 0;
    
    // Function to lock body scroll on mobile
    function lockBodyScroll() {
      if (window.innerWidth <= 768) {
        scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
        document.body.style.position = 'fixed';
        document.body.style.top = '-' + scrollPosition + 'px';
        document.body.style.width = '100%';
        document.body.style.overflow = 'hidden';
      }
    }

    // Function to unlock body scroll on mobile
    function unlockBodyScroll() {
      if (document.body.style.position === 'fixed') {
        document.body.style.removeProperty('position');
        document.body.style.removeProperty('top');
        document.body.style.removeProperty('width');
        document.body.style.removeProperty('overflow');
        window.scrollTo(0, scrollPosition);
      }
    }

    // Attach to all bootstrap modals
    var modals = document.querySelectorAll('.modal');
    modals.forEach(function(modal) {
      modal.addEventListener('show.bs.modal', lockBodyScroll);
      modal.addEventListener('hidden.bs.modal', unlockBodyScroll);
    });

    // Password visibility toggle (Eye Icon) for both themes
    var passwordInputs = document.querySelectorAll('input[type="password"]');
    passwordInputs.forEach(function(input) {
      // Create a wrapper div
      var wrapper = document.createElement('div');
      wrapper.className = 'position-relative';
      // Insert wrapper before input in the DOM
      input.parentNode.insertBefore(wrapper, input);
      // Move input into the wrapper
      wrapper.appendChild(input);

      // Create the eye icon toggle button
      var toggleBtn = document.createElement('span');
      // SVG for eye (open)
      var iconOpen = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/></svg>';
      // SVG for eye-slash (closed)
      var iconClosed = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486z"/><path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829"/><path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z"/></svg>';

      toggleBtn.innerHTML = iconClosed; // Start closed (password hidden)
      toggleBtn.style.position = 'absolute';
      toggleBtn.style.right = '12px';
      toggleBtn.style.top = '50%';
      toggleBtn.style.transform = 'translateY(-50%)';
      toggleBtn.style.cursor = 'pointer';
      toggleBtn.style.color = 'var(--bs-body-color, #999)';
      toggleBtn.style.opacity = '0.7';
      toggleBtn.style.zIndex = '10';

      wrapper.appendChild(toggleBtn);

      // Add padding to input so text doesn't hide behind the icon
      input.style.paddingRight = '40px';

      // Toggle functionality
      toggleBtn.addEventListener('click', function() {
        if (input.type === 'password') {
          input.type = 'text';
          toggleBtn.innerHTML = iconOpen;
        } else {
          input.type = 'password';
          toggleBtn.innerHTML = iconClosed;
        }
      });
      
      // Add hover effect
      toggleBtn.addEventListener('mouseenter', function() { toggleBtn.style.opacity = '1'; });
      toggleBtn.addEventListener('mouseleave', function() { toggleBtn.style.opacity = '0.7'; });
    });
  });
</script>
