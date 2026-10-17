@php
  $toastMsg = null;
  $toastTitle = null;
  $toastType = 'success'; // 'success', 'warning', 'danger'

  if (session('toast_msg')) {
    $toastMsg   = session('toast_msg');
    $toastTitle = session('toast_title', 'Notice');
    $toastType  = session('toast_type', 'warning');
  } elseif (session('login_success')) {
    $toastTitle = 'Welcome';
    $toastMsg   = session('login_success');
    $toastType  = 'success';
  } elseif (session('status') === 'session-terminated') {
    $toastTitle = 'Session Terminated';
    $toastMsg   = 'The selected session has been signed out successfully.';
    $toastType  = 'success';
  } elseif (session('status') === 'other-sessions-terminated') {
    $toastTitle = 'Other Sessions Signed Out';
    $toastMsg   = 'All other active sessions have been terminated.';
    $toastType  = 'success';
  } elseif (session('status') === 'profile-updated') {
    $toastTitle = 'Profile Updated';
    $toastMsg   = 'Your profile information has been saved successfully.';
    $toastType  = 'success';
  } elseif (session('verification_upload_success')) {
    $toastTitle = 'Verification Submitted';
    $toastMsg   = session('verification_upload_success');
    $toastType  = 'success';
  } elseif (session('photo_upload_success') || session('status') === 'photo-updated') {
    $toastTitle = 'Photo Published';
    $toastMsg   = session('photo_upload_success') ?? 'Your profile photo has been successfully updated.';
    $toastType  = 'success';
  } elseif (session('photo_delete_success') || session('status') === 'photo-deleted') {
    $toastTitle = 'Photo Removed';
    $toastMsg   = session('photo_delete_success') ?? 'Your profile photo has been successfully removed.';
    $toastType  = 'success';
  } elseif (session('video_upload_success')) {
    $toastTitle = 'Video Published';
    $toastMsg   = session('video_upload_success');
    $toastType  = 'success';
  } elseif (session('video_delete_success')) {
    $toastTitle = 'Video Removed';
    $toastMsg   = session('video_delete_success');
    $toastType  = 'success';
  } elseif (session('success')) {
    $toastTitle = session('toast_title', 'Success');
    $toastMsg   = session('success');
    $toastType  = 'success';
  } elseif (session('error')) {
    $toastTitle = session('toast_title', 'Error');
    $toastMsg   = session('error');
    $toastType  = 'danger';
  } elseif (isset($errors) && $errors->has('email')) {
    $emailError = $errors->first('email');
    if (stripos($emailError, 'already registered') !== false || stripos($emailError, 'already been taken') !== false) {
      $toastTitle = 'Email Already Registered';
      $toastMsg   = 'This email address is already registered. Please log in instead or use another email.';
      $toastType  = 'warning';
    } elseif (stripos($emailError, 'not registered') !== false || stripos($emailError, 'No account exists') !== false) {
      $toastTitle = 'Email Not Registered';
      $toastMsg   = 'No account exists with this email address. Please check your spelling or sign up.';
      $toastType  = 'warning';
    } elseif (stripos($emailError, 'incorrect') !== false || stripos($emailError, 'credentials') !== false) {
      $toastTitle = 'Incorrect Password';
      $toastMsg   = 'The password you entered is incorrect. Please try again or click Forgot Password.';
      $toastType  = 'danger';
    } else {
      $toastTitle = 'Authentication Error';
      $toastMsg   = $emailError;
      $toastType  = 'danger';
    }
  }
@endphp

@if($toastMsg)
<style>
  .site-toast {
    position: fixed; top: 5.5rem; right: 2rem; z-index: 999999;
    display: flex; align-items: flex-start; gap: 0.85rem;
    background: #0d0d0d;
    border-radius: 14px;
    padding: 1rem 1.25rem;
    max-width: 380px; width: calc(100vw - 4rem);
    box-shadow: 0 20px 60px rgba(0,0,0,0.85), 0 0 0 1px rgba(255,255,255,0.04);
    font-family: "Outfit", ui-sans-serif, sans-serif;
    animation: siteToastIn 0.45s cubic-bezier(0.34,1.56,0.64,1) both;
    overflow: hidden;
  }
  @keyframes siteToastIn {
    from { opacity: 0; transform: translateY(-20px) scale(0.93); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
  }
  .site-toast--success {
    border: 1px solid rgba(40,167,69,0.45);
    border-left: 4px solid #28a745;
  }
  .site-toast--warning {
    border: 1px solid rgba(255,140,0,0.45);
    border-left: 4px solid #ff8c00;
  }
  .site-toast--danger {
    border: 1px solid rgba(220,53,69,0.45);
    border-left: 4px solid #dc3545;
  }
  .site-toast__icon {
    flex-shrink: 0; margin-top: 2px;
    width: 38px; height: 38px; border-radius: 11px;
    display: flex; align-items: center; justify-content: center;
  }
  .site-toast--success .site-toast__icon {
    background: rgba(40,167,69,0.12); border: 1px solid rgba(40,167,69,0.3); color: #28a745;
  }
  .site-toast--warning .site-toast__icon {
    background: rgba(255,140,0,0.12); border: 1px solid rgba(255,140,0,0.3); color: #ff8c00;
  }
  .site-toast--danger .site-toast__icon {
    background: rgba(220,53,69,0.12); border: 1px solid rgba(220,53,69,0.3); color: #dc3545;
  }
  .site-toast__body { flex: 1; min-width: 0; }
  .site-toast__title { font-size: .88rem; font-weight: 700; margin: 0 0 .25rem; line-height: 1.2; }
  .site-toast--success .site-toast__title { color: #28a745; }
  .site-toast--warning .site-toast__title { color: #ff8c00; }
  .site-toast--danger .site-toast__title  { color: #dc3545; }
  .site-toast__msg { font-size: .8rem; color: rgba(255,255,255,0.7); margin: 0; line-height: 1.5; }
  .site-toast__close {
    flex-shrink: 0; align-self: flex-start;
    background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
    border-radius: 7px; width: 26px; height: 26px;
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,0.45); cursor: pointer; padding: 0; transition: all .2s;
  }
  .site-toast--success .site-toast__close:hover { background: rgba(40,167,69,0.15); border-color: rgba(40,167,69,0.35); color: #28a745; }
  .site-toast--warning .site-toast__close:hover { background: rgba(255,140,0,0.15); border-color: rgba(255,140,0,0.35); color: #ff8c00; }
  .site-toast--danger .site-toast__close:hover  { background: rgba(220,53,69,0.15); border-color: rgba(220,53,69,0.35); color: #dc3545; }
  .site-toast__bar {
    position: absolute; bottom: 0; left: 0; height: 3px;
    border-radius: 0 0 0 14px;
    animation: siteToastBar 6s linear both;
  }
  .site-toast--success .site-toast__bar { background: linear-gradient(90deg, #28a745, rgba(40,167,69,0.1)); }
  .site-toast--warning .site-toast__bar { background: linear-gradient(90deg, #ff8c00, rgba(255,140,0,0.1)); }
  .site-toast--danger .site-toast__bar  { background: linear-gradient(90deg, #dc3545, rgba(220,53,69,0.1)); }
  @keyframes siteToastBar { from { width: 100%; } to { width: 0%; } }

  /* Light Theme */
  [data-bs-theme="light"] .site-toast { background: #ffffff; box-shadow: 0 12px 40px rgba(0,0,0,0.1); }
  [data-bs-theme="light"] .site-toast__msg { color: rgba(0,0,0,0.72); }
  [data-bs-theme="light"] .site-toast__close { background: rgba(0,0,0,0.04); border-color: rgba(0,0,0,0.08); color: rgba(0,0,0,0.5); }
</style>

<div class="site-toast site-toast--{{ $toastType }}" id="siteToast" role="alert" aria-live="assertive">
  <div class="site-toast__icon">
    @if($toastType === 'warning')
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
        <line x1="12" y1="9" x2="12" y2="13"></line>
        <line x1="12" y1="17" x2="12.01" y2="17"></line>
      </svg>
    @elseif($toastType === 'danger')
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"></circle>
        <line x1="15" y1="9" x2="9" y2="15"></line>
        <line x1="9" y1="9" x2="15" y2="15"></line>
      </svg>
    @else
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
        <polyline points="22 4 12 14.01 9 11.01"></polyline>
      </svg>
    @endif
  </div>
  <div class="site-toast__body">
    <p class="site-toast__title">{{ $toastTitle }}</p>
    <p class="site-toast__msg">{{ $toastMsg }}</p>
  </div>
  <button class="site-toast__close" onclick="document.getElementById('siteToast').remove();" aria-label="Dismiss">
    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
      <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
    </svg>
  </button>
  <div class="site-toast__bar"></div>
</div>
<script>
  setTimeout(function() {
    var t = document.getElementById('siteToast');
    if (t) t.remove();
  }, 6000);
</script>
@endif
