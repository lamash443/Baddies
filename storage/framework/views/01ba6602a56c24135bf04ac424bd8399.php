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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Chat Membership Checkout - Baddies Club</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing:border-box; }
    html, body { margin:0; padding:0; font-family:"Outfit",sans-serif; background:#0d0d0d; color:#fff; min-height:100vh; }

    /* DASHBOARD LAYOUT */
    .dashboard-header { padding:3rem 0 2rem; border-bottom:1px solid rgba(255,140,0,0.12); margin-bottom:2.5rem; }
    .dashboard-title { font-size:clamp(1.8rem,4vw,2.5rem); font-weight:900; letter-spacing:-0.02em; line-height:1.1; margin-bottom:0.5rem; }
    .dashboard-title span { background:linear-gradient(135deg,#ff8c00,#ffb347); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
    
    /* CARDS */
    .dash-card {
      background:rgba(17,17,17,0.85); backdrop-filter:blur(15px);
      border:1px solid rgba(255,140,0,0.2); border-radius:18px; padding:2rem;
      box-shadow:0 8px 32px rgba(0,0,0,0.5); margin-bottom: 2rem;
    }
    .dash-card-title { font-size:1.2rem; font-weight:700; color:#fff; margin-bottom:0.5rem; }
    
    /* FORMS */
    .form-label { font-size: 0.95rem; font-weight: 600; color: rgba(255,255,255,0.8); margin-bottom: 0.5rem; }
    .form-select {
      background-color: rgba(0,0,0,0.3); border: 1px solid rgba(255,140,0,0.2);
      color: #fff; padding: 0.85rem 1rem; border-radius: 8px; font-size: 1rem;
    }
    .form-select:focus {
      background-color: rgba(0,0,0,0.5); border-color: orange; box-shadow: 0 0 0 3px rgba(255,165,0,0.15); color: #fff;
    }
    .form-select option { background-color: #111; color: #fff; }

    /* ── UNIFIED BUTTON STYLE (matches /profile & /dashboard) ── */
    .btn-orange {
      display: inline-flex; align-items: center; justify-content: center; gap: 0.45rem;
      background: transparent; border: 2px solid orange; color: orange;
      padding: 0.75rem 1.5rem; border-radius: 8px; font-size: 1rem; font-weight: 700;
      font-family: "Outfit", sans-serif; text-decoration: none; transition: all 0.3s ease;
      cursor: pointer; letter-spacing: 0.02em;
    }
    .btn-orange:hover {
      background: orange; color: #000; border-color: orange;
      box-shadow: 0 0 18px 4px rgba(255,165,0,0.55), 0 0 35px rgba(255,165,0,0.25);
      transform: translateY(-1px);
    }
    .btn-orange:active { transform: translateY(0); box-shadow: 0 0 10px 2px rgba(255,165,0,0.4); }

    /* SUMMARY LIST */
    .plan-list li { margin-bottom: 1rem; font-size: 1rem; color: rgba(255,255,255,0.7); }
    .plan-list li span { color: #fff; font-weight: 600; }

    /* LIGHT THEME */
    [data-bs-theme="light"] body { background:#f9f9f9; color:#111; }
    [data-bs-theme="light"] .dashboard-header { border-color:rgba(0,0,0,0.1); }
    [data-bs-theme="light"] .dash-card { background:#fff; border-color:rgba(255,140,0,0.3); box-shadow:0 5px 20px rgba(0,0,0,0.05); }
    [data-bs-theme="light"] .dash-card-title { color:#000; }
    [data-bs-theme="light"] .form-select { background: #fff; color: #000; border-color: rgba(0,0,0,0.1); }
    [data-bs-theme="light"] .plan-list li { color: rgba(0,0,0,0.7); }
    [data-bs-theme="light"] .plan-list li span { color: #000; }
    [data-bs-theme="light"] hr, [data-bs-theme="light"] .border-top, [data-bs-theme="light"] .border-bottom { border-color: rgba(0,0,0,0.1) !important; }
    [data-bs-theme="light"] div[style*="background:rgba(255,255,255,0.03)"] { background: #f8f9fa !important; border-color: rgba(0,0,0,0.08) !important; }
    [data-bs-theme="light"] .text-light, [data-bs-theme="light"] .text-white { color: #111 !important; }
  </style>
</head>
<body>

  <?php if (isset($component)) { $__componentOriginalcde7590e546e081006f026a28a698257 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcde7590e546e081006f026a28a698257 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.checkout-toast','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('checkout-toast'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcde7590e546e081006f026a28a698257)): ?>
<?php $attributes = $__attributesOriginalcde7590e546e081006f026a28a698257; ?>
<?php unset($__attributesOriginalcde7590e546e081006f026a28a698257); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcde7590e546e081006f026a28a698257)): ?>
<?php $component = $__componentOriginalcde7590e546e081006f026a28a698257; ?>
<?php unset($__componentOriginalcde7590e546e081006f026a28a698257); ?>
<?php endif; ?>



  <!-- NAVBAR -->
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

  <!-- HEADER -->
  <div class="dashboard-header">
    <div class="container text-center">
      <h1 class="dashboard-title">Chat Membership <span>Checkout</span></h1>
      <nav aria-label="breadcrumb" class="d-flex justify-content-center mt-3">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="#" class="text-warning text-decoration-none fw-bold"><?php echo e(__('Home')); ?></a></li>
          <li class="breadcrumb-item active text-secondary" aria-current="page"><?php echo e(__('Chat Membership Checkout')); ?></li>
        </ol>
      </nav>
    </div>
  </div>

  <div class="container pb-5 mb-5">
    <div class="row g-4">
      
      <!-- Left Column: Plan Details -->
      <div class="col-12 col-lg-5 col-xl-4">
        <div class="dash-card h-100" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
          <div class="text-warning small fw-bold text-uppercase tracking-wider mb-2"><?php echo e(__('CHAT SUBSCRIPTION')); ?></div>
          <h2 class="dash-card-title fs-3 mb-4"><?php echo e(__('Chat Subscription Plan')); ?></h2>
          
          <ul class="list-unstyled plan-list mb-0">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $chatPlan?->pricing ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $days => $price): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
              <li class="d-flex align-items-center gap-2">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-secondary"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <?php echo e($days); ?> <?php echo e((int)$days === 1 ? 'Day' : 'Days'); ?> Chat Plan = <span><?php echo e(number_format($price)); ?> Ksh</span>
              </li>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
          </ul>
        </div>
      </div>

      <!-- Right Column: Checkout Form -->
      <div class="col-12 col-lg-7 col-xl-8">
        <div class="dash-card h-100" style="border-top: 4px solid orange;">
          <form action="<?php echo e(route('membership.process')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="plan_type" value="chat">
            
            <div class="row g-4 mb-4">
              <div class="col-12 col-md-6">
                <label class="form-label"><?php echo e(__('Select Plan')); ?></label>
                <select class="form-select" name="plan" id="plan-select">
                <?php
                  $chatPricing = $chatPlan?->pricing ?? [];
                  $lastKey = array_key_last($chatPricing);
                ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $chatPricing; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $days => $price): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                  <option value="<?php echo e($days); ?>" data-price="<?php echo e($price); ?>" <?php echo e($days == $lastKey ? 'selected' : ''); ?>><?php echo e($days); ?> <?php echo e((int)$days === 1 ? 'Day' : 'Days'); ?> for KSh<?php echo e(number_format($price)); ?></option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label"><?php echo e(__('Payment Methods')); ?></label>
                <select class="form-select" name="payment_method">
                  <option value="mpesa">MPESA</option>
                  <option value="wallet">Wallet Balance (KSh <?php echo e(number_format(auth()->user()->wallet_balance ?? 0, 2)); ?>)</option>
                </select>
              </div>
            </div>

            <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">

            <div class="p-4 rounded mb-4" style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.1);">
              <div class="d-flex justify-content-between mb-3 text-secondary">
                <span class="fs-5"><?php echo e(__('Plan Price:')); ?></span>
                <span class="text-light fw-medium fs-5" id="plan-price">KSh1,500</span>
              </div>
              <div class="d-flex justify-content-between pt-3 mt-3 border-top" style="border-color:rgba(255,255,255,0.1) !important;">
                <span class="text-light fw-bold fs-4"><?php echo e(__('Total:')); ?></span>
                <span class="text-warning fw-bold fs-3" id="plan-total">KSh1,500</span>
              </div>
            </div>

            <div class="d-flex flex-row gap-2 gap-sm-3 mt-4">
              <button type="submit" class="btn btn-orange py-2 py-sm-3 px-1 px-sm-3 fs-6 fs-sm-5 w-100 d-flex align-items-center justify-content-center text-center" style="border-radius:12px; line-height:1.2;">
                <span><?php echo e(__('Pay & Subscribe')); ?></span>
              </button>
            </div>

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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const planSelect  = document.getElementById('plan-select');
    const planPrice   = document.getElementById('plan-price');
    const planTotal   = document.getElementById('plan-total');

    const prices = JSON.parse('<?php echo json_encode($chatPlan?->pricing ?? [], 15, 512) ?>');

    function formatKsh(amount) {
      return 'KSh' + Number(amount).toLocaleString();
    }

    function updatePrice() {
      const selected = planSelect.options[planSelect.selectedIndex];
      const price    = parseInt(selected.getAttribute('data-price'));
      planPrice.textContent = formatKsh(price);
      planTotal.textContent = formatKsh(price);
    }

    planSelect.addEventListener('change', updatePrice);
    updatePrice();
  </script>
</body>
</html>


<?php /**PATH C:\Users\willi\Desktop\Kenyan Baddies Club\resources\views\chat-checkout.blade.php ENDPATH**/ ?>