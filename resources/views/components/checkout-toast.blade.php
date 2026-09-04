  {{-- ── TOAST NOTIFICATIONS ── --}}
  <style>
    .checkout-toast {
      position: fixed; top: 5.5rem; right: 2rem; z-index: 99999;
      display: flex; align-items: flex-start; gap: 0.85rem;
      background: #0d0d0d;
      border-radius: 14px;
      padding: 1rem 1.25rem;
      max-width: 360px; width: calc(100vw - 4rem);
      box-shadow: 0 20px 60px rgba(0,0,0,0.8), 0 0 0 1px rgba(255,255,255,0.04);
      font-family: "Outfit", ui-sans-serif, sans-serif;
      animation: checkoutToastIn 0.45s cubic-bezier(0.34,1.56,0.64,1) both;
      overflow: hidden;
    }
    @keyframes checkoutToastIn {
      from { opacity:0; transform: translateY(-20px) scale(0.93); }
      to   { opacity:1; transform: translateY(0) scale(1); }
    }
    .checkout-toast.toast-success {
      border: 1px solid rgba(40,167,69,0.45);
      border-left: 4px solid #28a745;
    }
    .checkout-toast.toast-error {
      border: 1px solid rgba(220,53,69,0.45);
      border-left: 4px solid #dc3545;
    }
    .checkout-toast__icon {
      flex-shrink:0; margin-top:2px;
      width:38px; height:38px; border-radius:11px;
      display:flex; align-items:center; justify-content:center;
    }
    .toast-success .checkout-toast__icon {
      background:rgba(40,167,69,0.12); border:1px solid rgba(40,167,69,0.3); color:#28a745;
    }
    .toast-error .checkout-toast__icon {
      background:rgba(220,53,69,0.12); border:1px solid rgba(220,53,69,0.3); color:#dc3545;
    }
    .checkout-toast__body { flex:1; min-width:0; }
    .checkout-toast__title { font-size:.88rem; font-weight:700; margin:0 0 .2rem; line-height:1.2; }
    .toast-success .checkout-toast__title { color:#28a745; }
    .toast-error .checkout-toast__title { color:#dc3545; }
    
    .checkout-toast__msg { font-size:.8rem; color:rgba(255,255,255,.6); margin:0; line-height:1.5; }
    .checkout-toast__close {
      background:none; border:none; padding:4px; margin:-4px -4px 0 0;
      color:rgba(255,255,255,0.4); cursor:pointer; border-radius:6px; transition:all 0.2s;
    }
    .checkout-toast__close:hover { background:rgba(255,255,255,0.1); color:#fff; }
  </style>

  @if(session('success'))
    <div id="successToast" class="checkout-toast toast-success" role="alert">
      <div class="checkout-toast__icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
      </div>
      <div class="checkout-toast__body">
        <p class="checkout-toast__title">Success</p>
        <p class="checkout-toast__msg">{{ session('success') }}</p>
      </div>
      <button class="checkout-toast__close" onclick="dismissToast('successToast')" aria-label="Close">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
  @endif

  @if($errors->has('wallet') || $errors->any())
    <div id="errorToast" class="checkout-toast toast-error" role="alert">
      <div class="checkout-toast__icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      </div>
      <div class="checkout-toast__body">
        <p class="checkout-toast__title">Payment Failed</p>
        <p class="checkout-toast__msg">{{ $errors->first('wallet') ?: $errors->first() }}</p>
      </div>
      <button class="checkout-toast__close" onclick="dismissToast('errorToast')" aria-label="Close">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
  @endif

  <script>
    function dismissToast(id) { const t=document.getElementById(id); if(t){t.style.opacity='0';t.style.transform='translateY(-20px) scale(0.93)';setTimeout(()=>t.style.display='none',350);} }
    ['successToast','errorToast'].forEach(id => setTimeout(()=>dismissToast(id),6000));
  </script>
<style>
.fee-note {
  display:inline-flex; align-items:center; gap:0.4rem;
  background:rgba(255,140,0,0.07); border:1px solid rgba(255,140,0,0.2);
  border-radius:8px; padding:0.5rem 0.9rem; font-size:0.85rem; color:rgba(255,255,255,0.6);
}
.fee-note strong { color:orange; }
</style>
