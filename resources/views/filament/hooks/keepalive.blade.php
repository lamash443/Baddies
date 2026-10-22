<script>
(function() {
    'use strict';

    // 1. Broadcast admin activity to all open tabs via BroadcastChannel
    try {
        const bc = new BroadcastChannel('al_activity');
        const events = ['mousemove', 'mousedown', 'keydown', 'touchstart', 'scroll', 'click'];
        let throttleTimer = null;
        events.forEach(function(evt) {
            document.addEventListener(evt, function() {
                if (!throttleTimer) {
                    throttleTimer = setTimeout(function() {
                        try { bc.postMessage('active'); } catch(_) {}
                        throttleTimer = null;
                    }, 5000);
                }
            }, { passive: true });
        });
    } catch (_) {}

    // 2. Periodic keep-alive heartbeat ping every 5 minutes so admin session never expires
    setInterval(function() {
        try {
            fetch('/visitor/heartbeat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ seconds: 15 })
            }).catch(function() {});
        } catch (_) {}
    }, 5 * 60 * 1000);
})();
</script>
