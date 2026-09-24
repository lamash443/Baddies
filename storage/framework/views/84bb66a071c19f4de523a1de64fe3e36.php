<!DOCTYPE html>
<html lang="en">
<head>
  <script>
    (function() {
      const theme = localStorage.getItem('theme') || 'dark';
      document.documentElement.setAttribute('data-bs-theme', theme);
    })();
  </script>
  <meta charset="utf-8">
  <?php if (isset($component)) { $__componentOriginald9e77967a5438b63fd29d241808e49d9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9e77967a5438b63fd29d241808e49d9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.site-favicon','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('site-favicon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald9e77967a5438b63fd29d241808e49d9)): ?>
<?php $attributes = $__attributesOriginald9e77967a5438b63fd29d241808e49d9; ?>
<?php unset($__attributesOriginald9e77967a5438b63fd29d241808e49d9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald9e77967a5438b63fd29d241808e49d9)): ?>
<?php $component = $__componentOriginald9e77967a5438b63fd29d241808e49d9; ?>
<?php unset($__componentOriginald9e77967a5438b63fd29d241808e49d9); ?>
<?php endif; ?>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contact Support - Baddies Club</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing:border-box; }
    html, body { margin:0; padding:0; font-family:"Outfit",sans-serif; background:#0d0d0d; color:#fff; min-height:100vh; }

    /* DASHBOARD LAYOUT & CARDS */
    .dashboard-header { padding:3rem 0 2rem; border-bottom:1px solid rgba(255,140,0,0.12); margin-bottom:2.5rem; }
    .dashboard-title { font-size:clamp(1.8rem,4vw,2.5rem); font-weight:900; letter-spacing:-0.02em; line-height:1.1; margin-bottom:0.5rem; }
    .dashboard-title span { background:linear-gradient(135deg,#ff8c00,#ffb347); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
    .dashboard-sub { font-size:0.9rem; color:rgba(255,255,255,0.5); font-weight:400; }

    .dash-card {
      background:rgba(17,17,17,0.85); backdrop-filter:blur(15px);
      border:1px solid rgba(255,140,0,0.2); border-radius:18px; padding:2.5rem;
      box-shadow:0 8px 32px rgba(0,0,0,0.5); margin-bottom: 2rem;
    }
    .dash-card-title { font-size:1.4rem; font-weight:800; color:#fff; margin-bottom:1.5rem; display: flex; align-items: center; gap: 0.5rem; }
    .dash-card-title span { color: orange; }

    /* FORMS */
    .form-label { font-size: 0.9rem; font-weight: 600; color: rgba(255,255,255,0.85); margin-bottom: 0.4rem; text-transform: uppercase; letter-spacing: 0.05em; }
    .form-control {
      background: rgba(0,0,0,0.3); border: 2px solid rgba(255,140,0,0.2);
      color: #fff; padding: 0.8rem 1rem; border-radius: 8px; font-size: 0.95rem;
      transition: all 0.3s;
    }
    .form-control:focus {
      background: rgba(0,0,0,0.5); border-color: orange; box-shadow: 0 0 0 3px rgba(255,165,0,0.15); color: #fff;
    }
    .form-control::placeholder { color: rgba(255,255,255,0.35); }

    /* BUTTONS */
    .btn-orange {
      display:inline-flex; align-items:center; justify-content:center; gap:0.5rem;
      background:orange; border:2px solid orange; color:#000;
      padding:0.85rem 2rem; border-radius:8px; font-size:1rem; font-weight:800; font-family:"Outfit",sans-serif;
      text-decoration:none; transition:all 0.3s ease; border: none;
      letter-spacing: 0.03em;
    }
    .btn-orange:hover { background:#fff; color:orange; box-shadow:0 0 15px rgba(255,165,0,0.5); transform: translateY(-1px); }

    /* SUPPORT BADGE/INFO */
    .support-badge {
      display: inline-block; background: rgba(255,140,0,0.1); border: 1px solid rgba(255,140,0,0.25);
      color: orange; padding: 0.4rem 1rem; border-radius: 50px; font-size: 0.8rem; font-weight: 700;
      margin-bottom: 1.5rem;
    }
    .user-info-badge {
      background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
      border-radius: 10px; padding: 1rem; margin-bottom: 1.5rem;
    }

    /* LIGHT THEME */
    [data-bs-theme="light"] body { background:#f4f6f9; color:#111; }
    [data-bs-theme="light"] .dashboard-header { border-color:rgba(0,0,0,0.08); }
    [data-bs-theme="light"] .dashboard-sub { color:rgba(0,0,0,0.6); }
    [data-bs-theme="light"] .dash-card { background:#fff; border-color:rgba(255,140,0,0.3); box-shadow:0 5px 20px rgba(0,0,0,0.05); }
    [data-bs-theme="light"] .dash-card-title { color:#000; }
    [data-bs-theme="light"] .form-label { color: rgba(0,0,0,0.7); }
    [data-bs-theme="light"] .form-control { background: #fff; color: #000; border-color: rgba(0,0,0,0.15); }
    [data-bs-theme="light"] .form-control:focus { background: #fff; color: #000; border-color: orange; }
    [data-bs-theme="light"] .form-control::placeholder { color: rgba(0,0,0,0.4); }
    [data-bs-theme="light"] .user-info-badge { background: rgba(0,0,0,0.02); border-color: rgba(0,0,0,0.06); }

    /* CHAR COUNTER */
    .char-counter {
      font-size: 0.75rem; font-weight: 600;
      color: rgba(255,255,255,0.35);
      text-align: right; margin-top: 4px;
      transition: color 0.2s ease;
    }
    .char-counter.warn  { color: #ffc107; }
    .char-counter.limit { color: #dc3545; }
    [data-bs-theme="light"] .char-counter { color: rgba(0,0,0,0.35); }
    [data-bs-theme="light"] .char-counter.warn  { color: #e07a00; }
    [data-bs-theme="light"] .char-counter.limit { color: #dc3545; }

    /* PHONE BADGE */
    .contact-phone-badge {
      display: inline-flex; align-items: center; gap: 0.55rem;
      background: rgba(255,140,0,0.1); border: 1px solid rgba(255,140,0,0.4);
      color: orange; padding: 0.55rem 1.4rem; border-radius: 50px;
      font-size: 1rem; font-weight: 700; text-decoration: none;
      transition: all 0.3s ease; letter-spacing: 0.02em;
    }
    .contact-phone-badge:hover { background: orange; color: #000; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(255,165,0,0.35); }
  </style>
</head>
<body>
  <?php if (isset($component)) { $__componentOriginalfc3c7128ad5039337c318ebdcd975711 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc3c7128ad5039337c318ebdcd975711 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.site-preloader','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('site-preloader'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc3c7128ad5039337c318ebdcd975711)): ?>
<?php $attributes = $__attributesOriginalfc3c7128ad5039337c318ebdcd975711; ?>
<?php unset($__attributesOriginalfc3c7128ad5039337c318ebdcd975711); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc3c7128ad5039337c318ebdcd975711)): ?>
<?php $component = $__componentOriginalfc3c7128ad5039337c318ebdcd975711; ?>
<?php unset($__componentOriginalfc3c7128ad5039337c318ebdcd975711); ?>
<?php endif; ?>
  <?php if (isset($component)) { $__componentOriginala591787d01fe92c5706972626cdf7231 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala591787d01fe92c5706972626cdf7231 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar','data' => ['hideSearch' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['hideSearch' => true]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala591787d01fe92c5706972626cdf7231)): ?>
<?php $attributes = $__attributesOriginala591787d01fe92c5706972626cdf7231; ?>
<?php unset($__attributesOriginala591787d01fe92c5706972626cdf7231); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala591787d01fe92c5706972626cdf7231)): ?>
<?php $component = $__componentOriginala591787d01fe92c5706972626cdf7231; ?>
<?php unset($__componentOriginala591787d01fe92c5706972626cdf7231); ?>
<?php endif; ?>

  <div class="dashboard-header">
    <div class="container text-center">
      <h1 class="dashboard-title">Contact <span>Support</span></h1>
      <div class="dashboard-sub"><?php echo $sitePage?->content; ?></div>
    </div>
  </div>

  <div class="container pb-5 mb-5">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-8 col-xl-7">



        <div class="dash-card">

          <h2 class="dash-card-title justify-content-center">Create Support <span>Ticket</span></h2>

          <form action="<?php echo e(route('contact.submit')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
              <!-- For Logged In Users -->
              <div class="user-info-badge mb-4">
                <div class="row g-2 align-items-center">
                  <div class="col-auto">
                    <div style="width: 42px; height: 42px; border-radius: 50%; background: orange; color: #000; font-weight: 800; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                      <?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?>

                    </div>
                  </div>
                  <div class="col">
                    <div class="fw-bold text-light" style="font-size: 0.95rem;">Submitting as: <span style="color:orange;"><?php echo e(Auth::user()->name); ?></span></div>
                    <div class="small text-secondary" style="font-size: 0.8rem;"><?php echo e(Auth::user()->email); ?></div>
                  </div>
                  <div class="col-auto">
                    <span class="badge bg-orange text-dark fw-bold px-2.5 py-1.5" style="font-size: 0.75rem; text-transform: uppercase;">User Ticket</span>
                  </div>
                </div>
              </div>
              <input type="hidden" name="name" value="<?php echo e(Auth::user()->name); ?>">
              <input type="hidden" name="email" value="<?php echo e(Auth::user()->email); ?>">
            <?php else: ?>
              <!-- For Guests -->
              <div class="row g-3 mb-3">
                <div class="col-12 col-md-6">
                  <label class="form-label" for="name">Your Name</label>
                  <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name" required maxlength="50" value="<?php echo e(old('name')); ?>">
                  <div class="char-counter" id="name-counter">0 / 50</div>
                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                  <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div class="col-12 col-md-6">
                  <label class="form-label" for="email">Your Email Address</label>
                  <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required maxlength="100" value="<?php echo e(old('email')); ?>">
                  <div class="char-counter" id="email-counter">0 / 100</div>
                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                  <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
              </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div class="mb-3">
              <label class="form-label" for="subject">Subject / Purpose</label>
              <input type="text" name="subject" id="subject" class="form-control" placeholder="How can we help you?" required maxlength="80" value="<?php echo e(old('subject')); ?>">
              <div class="char-counter" id="subject-counter">0 / 80</div>
              <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="text-danger small mt-1"><?php echo e($message); ?></div>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div class="mb-4">
              <label class="form-label" for="message">Detailed Message</label>
              <textarea name="message" id="message" rows="5" class="form-control" placeholder="Please describe your issue or query in detail..." required maxlength="1000"><?php echo e(old('message')); ?></textarea>
              <div class="char-counter" id="message-counter">0 / 1000</div>
              <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="text-danger small mt-1"><?php echo e($message); ?></div>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <button type="submit" class="btn btn-orange w-100 fw-bold py-3 mt-2 shadow">
              Submit Support Request
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="ms-1"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
            </button>
          </form>

        </div>

      </div>
    </div>
  </div>

  <?php if (isset($component)) { $__componentOriginal8a8716efb3c62a45938aca52e78e0322 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8a8716efb3c62a45938aca52e78e0322 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.footer','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8a8716efb3c62a45938aca52e78e0322)): ?>
<?php $attributes = $__attributesOriginal8a8716efb3c62a45938aca52e78e0322; ?>
<?php unset($__attributesOriginal8a8716efb3c62a45938aca52e78e0322); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8a8716efb3c62a45938aca52e78e0322)): ?>
<?php $component = $__componentOriginal8a8716efb3c62a45938aca52e78e0322; ?>
<?php unset($__componentOriginal8a8716efb3c62a45938aca52e78e0322); ?>
<?php endif; ?>
  <?php if (isset($component)) { $__componentOriginale8a80adaa2cc6b8e6cd2379cf6b5d64b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale8a80adaa2cc6b8e6cd2379cf6b5d64b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth-modal','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale8a80adaa2cc6b8e6cd2379cf6b5d64b)): ?>
<?php $attributes = $__attributesOriginale8a80adaa2cc6b8e6cd2379cf6b5d64b; ?>
<?php unset($__attributesOriginale8a80adaa2cc6b8e6cd2379cf6b5d64b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale8a80adaa2cc6b8e6cd2379cf6b5d64b)): ?>
<?php $component = $__componentOriginale8a80adaa2cc6b8e6cd2379cf6b5d64b; ?>
<?php unset($__componentOriginale8a80adaa2cc6b8e6cd2379cf6b5d64b); ?>
<?php endif; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function initCounter(inputId, counterId, max) {
      var el = document.getElementById(inputId);
      var ct = document.getElementById(counterId);
      if (!el || !ct) return;
      function update() {
        var len = el.value.length;
        ct.textContent = len + ' / ' + max;
        ct.classList.remove('warn', 'limit');
        if (len >= max) ct.classList.add('limit');
        else if (len >= max * 0.85) ct.classList.add('warn');
      }
      el.addEventListener('input', update);
      update();
    }
    document.addEventListener('DOMContentLoaded', function() {
      initCounter('name',    'name-counter',    50);
      initCounter('email',   'email-counter',   100);
      initCounter('subject', 'subject-counter', 80);
      initCounter('message', 'message-counter', 1000);
    });
  </script>

  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1080; margin-top: 60px;">
      <div id="successToast" class="toast align-items-center border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true" style="background: rgba(17,17,17,0.95); backdrop-filter: blur(10px); border-radius: 12px; border: 1px solid rgba(40,167,69,0.4) !important;">
        <div class="d-flex">
          <div class="toast-body d-flex align-items-center gap-3 text-white">
            <div style="background: rgba(40,167,69,0.2); padding: 8px; border-radius: 50%; color: #28a745; display: flex;">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            </div>
            <div>
              <div class="fw-bold" style="font-size: 1rem; color: #28a745;">Message Sent!</div>
              <div class="small" style="opacity: 0.9;"><?php echo e(session('success')); ?></div>
            </div>
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var toastEl = document.getElementById('successToast');
        var toast = new bootstrap.Toast(toastEl, { delay: 5000 });
        toast.show();
      });
    </script>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('throttle_error')): ?>
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1080; margin-top: 60px;">
      <div id="throttleToast" class="toast align-items-center border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true" style="background: rgba(17,17,17,0.95); backdrop-filter: blur(10px); border-radius: 12px; border: 1px solid rgba(220,53,69,0.4) !important;">
        <div class="d-flex">
          <div class="toast-body d-flex align-items-center gap-3 text-white">
            <div style="background: rgba(220,53,69,0.2); padding: 8px; border-radius: 50%; color: #dc3545; display: flex;">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            </div>
            <div>
              <div class="fw-bold" style="font-size: 1rem; color: #dc3545;">Limit Reached</div>
              <div class="small" style="opacity: 0.9;"><?php echo e(session('throttle_error')); ?></div>
            </div>
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var toastEl = document.getElementById('throttleToast');
        var toast = new bootstrap.Toast(toastEl, { delay: 6000 });
        toast.show();
      });
    </script>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</body>
</html>

<?php /**PATH C:\Users\willi\Desktop\Kenyan Baddies Club\resources\views\contact.blade.php ENDPATH**/ ?>