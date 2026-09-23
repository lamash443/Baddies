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
  <title><?php echo e($classified->title); ?> - Adult Classifieds - Baddies Club</title>
  <meta name="description" content="Adult Classifieds: <?php echo e($classified->title); ?>">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; }
    html, body { margin:0; padding:0; font-family:"Outfit",sans-serif; background:#0d0d0d; color:#fff; min-height:100vh; }
    
    /* HEADER / HERO */
    .hero {
      position: relative;
      padding: 6rem 0 3rem;
      background: linear-gradient(180deg, rgba(255,140,0,0.05) 0%, #0d0d0d 100%);
      border-bottom: 1px solid rgba(255,140,0,0.1);
      margin-bottom: 3rem;
    }
    
    .classified-container {
      max-width: 900px;
      margin: 0 auto;
      padding: 2rem;
      background: rgba(17,17,17,0.7);
      border: 1px solid rgba(255,140,0,0.2);
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }
    
    .classified-image {
      width: 100%;
      max-height: 500px;
      object-fit: cover;
      border-radius: 12px;
      margin-bottom: 2rem;
      border: 1px solid rgba(255,140,0,0.3);
    }
    
    .classified-title {
      font-size: 2.5rem;
      font-weight: 800;
      color: #fff;
      margin-bottom: 1rem;
      line-height: 1.2;
    }
    
    .classified-meta {
      display: flex;
      flex-wrap: wrap;
      gap: 1.5rem;
      margin-bottom: 2rem;
      padding-bottom: 1.5rem;
      border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    
    .meta-item {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      color: rgba(255,255,255,0.7);
      font-size: 1rem;
    }
    
    .classified-description {
      font-size: 1.1rem;
      line-height: 1.7;
      color: rgba(255,255,255,0.85);
      margin-bottom: 3rem;
      white-space: pre-wrap;
    }
    
    .contact-box {
      background: linear-gradient(145deg, rgba(255,140,0,0.1) 0%, rgba(255,140,0,0.02) 100%);
      border: 1px solid rgba(255,140,0,0.3);
      border-radius: 12px;
      padding: 2rem;
      text-align: center;
    }
    
    .contact-box h3 {
      font-size: 1.5rem;
      font-weight: 700;
      color: #fff;
      margin-bottom: 1.5rem;
    }
    
    .btn-contact {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      background: orange;
      color: #000;
      font-weight: 700;
      font-size: 1.1rem;
      padding: 1rem 2rem;
      border-radius: 8px;
      text-decoration: none;
      transition: all 0.3s ease;
      border: 2px solid orange;
    }
    
    .btn-contact:hover {
      background: transparent;
      color: orange;
      box-shadow: 0 0 15px rgba(255,165,0,0.4);
    }
    
  </style>
</head>
<body>
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

  <section class="hero">
    <div class="container text-center">
      <a href="<?php echo e(route('classifieds')); ?>" class="btn btn-outline-warning mb-3" style="border-radius:8px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:5px;"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        Back to Classifieds
      </a>
    </div>
  </section>

  <div class="container mb-5">
    <div class="classified-container">
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($classified->image_path): ?>
      <img src="<?php echo e(asset('storage/' . $classified->image_path)); ?>" alt="<?php echo e($classified->title); ?>" class="classified-image">
      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      
      <div class="d-flex align-items-center gap-2 mb-3">
        <span class="badge bg-warning text-dark px-3 py-2 text-uppercase" style="font-size:0.9rem; font-weight:700;"><?php echo e($classified->category); ?></span>
      </div>
      
      <h1 class="classified-title"><?php echo e($classified->title); ?></h1>
      
      <div class="classified-meta">
        <div class="meta-item">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
          <?php echo e($classified->city ?? 'Location Not Specified'); ?>

        </div>
        <div class="meta-item">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
          Posted on <?php echo e($classified->created_at->format('M d, Y')); ?>

        </div>
      </div>
      
      <div class="classified-description">
<?php echo e($classified->description); ?>

      </div>
      
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($classified->phone || $classified->contact_name): ?>
      <div class="contact-box">
        <h3>Contact Details</h3>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($classified->contact_name): ?>
        <p class="mb-3" style="font-size:1.2rem; color:rgba(255,255,255,0.9);">Ask for <strong><?php echo e($classified->contact_name); ?></strong></p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($classified->phone): ?>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($classified->user && !($classified->user->calls_enabled ?? true)): ?>
            <button type="button" class="btn-contact border-0" onclick="showCallsDisabledToast()">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
              Number Hidden
            </button>
          <?php else: ?>
            <a href="tel:<?php echo e($classified->phone); ?>" class="btn-contact">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
              <?php echo e($classified->phone); ?>

            </a>
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>
      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      
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
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php /**PATH C:\Users\willi\Desktop\Kenyan Baddies Club\resources\views/classifieds-show.blade.php ENDPATH**/ ?>