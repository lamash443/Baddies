<!DOCTYPE html>
<html lang="en">
<head>
    <script>
        (function() {
            function applyTheme() {
                var theme = localStorage.getItem('theme') || 'dark';
                document.documentElement.setAttribute('data-bs-theme', theme);
            }
            applyTheme();
            document.addEventListener('livewire:navigated', applyTheme);
        })();
    </script>
    <meta charset="utf-8">
    <x-site-favicon />
    <meta name="viewport" content="width=device-width, initial-scale=1, interactive-widget=resizes-content">
    <title>Messages - Baddies Club</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @livewireStyles
    <style>
        *, *::before, *::after { box-sizing:border-box; }
        html, body { margin:0; padding:0; font-family:"Outfit",sans-serif; min-height:100vh; overflow-x: hidden; }
        [data-bs-theme="dark"] body, .dark body { background: #0d0d0d; color: #fff; }
        [data-bs-theme="light"] body, .light body { background: #f4f6f9; color: #111; }
        .nr-navbar { background:linear-gradient(160deg,#0d0d0d 0%,#1a0f00 50%,#0d0d0d 100%) !important; border-bottom:2px solid rgba(255,140,0,0.6); box-shadow:inset 0 -2px 30px rgba(255,140,0,0.06); padding-top:1.25rem !important; padding-bottom:1.25rem !important; }
        .nr-navbar .nav-link { font-weight:500; font-size:0.82rem; color:rgba(255,140,0,0.92) !important; text-decoration:none !important; display:inline-block !important; position:relative !important; padding-bottom:3px !important; box-shadow:none !important; transition:color 0.3s ease !important; }
        .nr-navbar .nav-link::after { content:"" !important; position:absolute !important; left:0 !important; bottom:0 !important; width:100% !important; height:1.5px !important; background:linear-gradient(90deg,rgba(255,255,255,0) 0%,rgba(255,255,255,0.9) 50%,rgba(255,255,255,0) 100%) !important; border-radius:2px !important; transform:scaleX(0) !important; transform-origin:center !important; transition:transform 0.35s cubic-bezier(0.4,0,0.2,1) !important; }
        .nr-navbar .nav-link.active, .nr-navbar .nav-link:hover, .nr-navbar .nav-link:focus { color:#ffffff !important; text-decoration:none !important; box-shadow:none !important; }
        .nr-navbar .nav-link.active::after, .nr-navbar .nav-link:hover::after, .nr-navbar .nav-link:focus::after { transform:scaleX(1) !important; }
        
        .chat-container { margin-top: 2rem; margin-bottom: 2rem; border-radius: 12px; overflow: hidden; border: 1px solid rgba(255,140,0,0.3); height: 75vh; max-width: 100%; }
        .chat-list, .chat-box { height: 100% !important; overflow-x: hidden; }
        
        @media (max-width: 767px) {
            html, body {
                height: 100dvh !important;
                overflow: hidden !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .nr-topbar, .nr-navbar, x-footer, footer, .site-footer, .nr-footer { display: none !important; }
            .container { padding: 0 !important; max-width: 100% !important; height: 100dvh !important; }
            .pb-5 { padding-bottom: 0 !important; }
            .chat-container {
                margin: 0 !important;
                border-radius: 0 !important;
                border: none !important;
                height: 100dvh !important;
                width: 100vw !important;
            }
            /* The chat-box inner component fills the full container */
            .chat-box {
                height: 100dvh !important;
                position: fixed !important;
                top: 0 !important; left: 0 !important;
                width: 100vw !important;
                z-index: 9999 !important;
            }
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
    
    <script>
    function showCallsDisabledToast() {
      const toastHtml = `
      <div class="warning-toast" id="callsDisabledToast" role="alert" aria-live="assertive" style="z-index: 999999;">
        <div class="warning-toast__icon">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <div class="warning-toast__body">
          <p class="warning-toast__title">Calls Disabled</p>
          <p class="warning-toast__msg">This user has disabled calls. Only chat is enabled.</p>
        </div>
        <button class="warning-toast__close" onclick="this.closest('.warning-toast').remove();" aria-label="Dismiss">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
          </svg>
        </button>
        <div class="warning-toast__bar"></div>
      </div>`;
      
      const existing = document.getElementById('callsDisabledToast');
      if (existing) existing.remove();
      
      document.body.insertAdjacentHTML('beforeend', toastHtml);
      setTimeout(() => {
        const t = document.getElementById('callsDisabledToast');
        if (t) t.remove();
      }, 6000);
    }

    // ── Mobile keyboard: keep chat-box pinned to the visible viewport ──
    // This runs at page level so it's never wiped by Livewire re-renders.
    if (window.innerWidth <= 767 && window.visualViewport) {
      function syncChatToViewport() {
        var chatBox = document.querySelector('.chat-box');
        if (chatBox) {
          chatBox.style.height = window.visualViewport.height + 'px';
          chatBox.style.top    = window.visualViewport.offsetTop + 'px';
        }
      }
      window.visualViewport.addEventListener('resize', syncChatToViewport);
      window.visualViewport.addEventListener('scroll', syncChatToViewport);
      // Also re-sync after every Livewire update in case DOM re-renders
      document.addEventListener('livewire:update', function() {
        requestAnimationFrame(syncChatToViewport);
      });
      syncChatToViewport();
    }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>
</html>
