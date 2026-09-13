<!DOCTYPE html>
<html lang="en">
<head>
    <script>
        (function() {
            var theme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-bs-theme', theme);
        })();
    </script>
    <meta charset="utf-8">
    <x-site-favicon />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Messages - Baddies Club</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @livewireStyles
    <style>
        *, *::before, *::after { box-sizing:border-box; }
        html, body { margin:0; padding:0; font-family:"Outfit",sans-serif; background:#0d0d0d; color:#fff; min-height:100vh; overflow-x: hidden; }
        .nr-navbar { background:linear-gradient(160deg,#0d0d0d 0%,#1a0f00 50%,#0d0d0d 100%) !important; border-bottom:2px solid rgba(255,140,0,0.6); box-shadow:inset 0 -2px 30px rgba(255,140,0,0.06); padding-top:1.25rem !important; padding-bottom:1.25rem !important; }
        .nr-navbar .nav-link { font-weight:500; font-size:0.82rem; color:rgba(255,140,0,0.92) !important; text-decoration:none !important; display:inline-block !important; position:relative !important; padding-bottom:3px !important; box-shadow:none !important; transition:color 0.3s ease !important; }
        .nr-navbar .nav-link::after { content:"" !important; position:absolute !important; left:0 !important; bottom:0 !important; width:100% !important; height:1.5px !important; background:linear-gradient(90deg,rgba(255,255,255,0) 0%,rgba(255,255,255,0.9) 50%,rgba(255,255,255,0) 100%) !important; border-radius:2px !important; transform:scaleX(0) !important; transform-origin:center !important; transition:transform 0.35s cubic-bezier(0.4,0,0.2,1) !important; }
        .nr-navbar .nav-link.active, .nr-navbar .nav-link:hover, .nr-navbar .nav-link:focus { color:#ffffff !important; text-decoration:none !important; box-shadow:none !important; }
        .nr-navbar .nav-link.active::after, .nr-navbar .nav-link:hover::after, .nr-navbar .nav-link:focus::after { transform:scaleX(1) !important; }
        
        .chat-container { margin-top: 2rem; margin-bottom: 2rem; border-radius: 12px; overflow: hidden; border: 1px solid rgba(255,140,0,0.3); height: 75vh; max-width: 100%; }
        .chat-list, .chat-box { height: 100% !important; overflow-x: hidden; }
        
        @media (max-width: 767px) {
            html, body { height: 100%; overflow: hidden; padding-top: 0 !important; margin: 0 !important; } /* Prevent body scrolling when full screen and remove navbar padding */
            .nr-topbar, .nr-navbar, x-footer, footer, .site-footer, .nr-footer { display: none !important; }
            .container { padding: 0 !important; max-width: 100% !important; height: 100% !important; }
            .pb-5 { padding-bottom: 0 !important; }
            .chat-container { margin: 0 !important; border-radius: 0 !important; border: none !important; height: 100% !important; width: 100vw !important; }
        }
    </style>
</head>
<body>
    <x-navbar />

    <div class="container pb-5 h-100">
        <div class="chat-container shadow-lg">
            <div class="row g-0 h-100">
                <div class="col-md-4 col-lg-4 h-100 {{ isset($activeUserId) ? 'd-none d-md-block' : '' }}">
                    @livewire('chat.chat-list', ['activeUserId' => $activeUserId ?? null])
                </div>
                <div class="col-md-8 col-lg-8 h-100 {{ !isset($activeUserId) ? 'd-none d-md-block' : '' }}">
                    @livewire('chat.chat-box', ['activeUserId' => $activeUserId ?? null])
                </div>
            </div>
        </div>
    </div>

    <x-footer />
    
    {{-- Calls Disabled Toast Container --}}
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999; margin-top: 70px;">
      <div id="callsDisabledToast" class="toast align-items-center border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true" style="background: rgba(17,17,17,0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255,140,0,0.4) !important; border-radius: 12px;">
        <div class="d-flex">
          <div class="toast-body d-flex align-items-center gap-3 text-white">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ff8c00" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span style="font-family: 'Outfit', sans-serif; font-size: 0.95rem;">
              This user has disabled calls. Only chat is enabled.
            </span>
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
    </div>

    <script>
    function showCallsDisabledToast() {
      const toastEl = document.getElementById('callsDisabledToast');
      if (toastEl) {
        const toast = new bootstrap.Toast(toastEl, { delay: 4000 });
        toast.show();
      } else {
        alert('This user has disabled calls. Only chat is enabled.');
      }
    }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>
</html>
