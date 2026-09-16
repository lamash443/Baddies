<div x-data="{
  step: sessionStorage.getItem('hookup_step') ? parseInt(sessionStorage.getItem('hookup_step')) : 1,
  planDays: sessionStorage.getItem('hookup_planDays') || '3',
  mpesaPhone: sessionStorage.getItem('hookup_mpesaPhone') || '',
  loading: false,
  prices: { '3': 400, '7': 700, '15': 1300, '30': 2000 }
}" 
x-init="
  $watch('step', value => sessionStorage.setItem('hookup_step', value));
  $watch('planDays', value => sessionStorage.setItem('hookup_planDays', value));
  $watch('mpesaPhone', value => sessionStorage.setItem('hookup_mpesaPhone', value));
"
x-cloak>

  
  <nav x-show="step === 3" x-transition class="mb-4" aria-label="breadcrumb">
    <ol class="breadcrumb mb-0" style="font-size:0.85rem;">
      <li class="breadcrumb-item">
        <a href="<?php echo e(url('/')); ?>" class="text-warning text-decoration-none fw-bold">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#" @click.prevent="step=2" class="text-warning text-decoration-none fw-bold">My Hookup Listing</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#" @click.prevent="step=2" class="text-warning text-decoration-none fw-bold">Plan Checkout</a>
      </li>
      <li class="breadcrumb-item active text-secondary" aria-current="page">Checkout - MPESA</li>
    </ol>
  </nav>

  
  <div x-show="step < 3" x-transition
    class="dash-card mb-4"
    style="background:linear-gradient(135deg,rgba(255,140,0,0.15),rgba(17,17,17,0.9)); border:1px solid rgba(255,140,0,0.4);">
    <header class="d-flex align-items-center gap-3 mb-3">
      <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
        style="width:48px;height:48px;background:orange;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
          stroke-linecap="round" stroke-linejoin="round">
          <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
          <circle cx="9" cy="7" r="4"></circle>
          <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
          <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
        </svg>
      </div>
      <div>
        <h2 class="dash-card-title mb-1 text-warning" style="font-size:1.5rem;">
          <?php echo e(__('Get Listed for Hookups')); ?>

        </h2>
        <div class="badge bg-success text-dark fw-bold px-2 py-1"><?php echo e(__('MEET NEW PEOPLE')); ?></div>
      </div>
    </header>
    <p class="dash-card-text text-light" style="font-size:1.05rem;">
      <?php echo e(__('Want to offer hookup services or meet verified members? Create your listing profile below to start receiving requests directly from interested clients.')); ?>

    </p>
  </div>

  
  <div class="dash-card">

    
    <header class="mb-4" x-show="step < 3">
      <h3 class="dash-card-title"><?php echo e(__('Create Your Hookup Listing')); ?></h3>
      <p class="dash-card-text"><?php echo e(__('Fill out the details below to complete your profile.')); ?></p>
    </header>

    <form action="<?php echo e(route('membership.process')); ?>" method="POST"
      enctype="multipart/form-data" id="hookupForm">
      <?php echo csrf_field(); ?>
      
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert" style="background:rgba(40,167,69,0.1); border:1px solid #28a745; color:#fff;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#28a745" stroke-width="2" class="me-3 flex-shrink-0"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            <div>
              <strong><?php echo e(__('Success!')); ?></strong> <?php echo e(session('success')); ?>

            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      
      <input type="hidden" name="plan_type" value="hookup">
      <input type="hidden" name="mpesa_phone" x-bind:value="mpesaPhone">
      <input type="hidden" name="plan" x-bind:value="planDays">
      <input type="hidden" name="payment_method" value="mpesa">

      
      <div x-show="step === 1" x-transition>
        <div class="row g-4">

          <div class="col-12">
            <h5 class="text-warning fw-bold mb-3 border-bottom pb-2"
              style="border-color:rgba(255,255,255,0.1) !important;">
              <?php echo e(__('Personal Details')); ?>

            </h5>
          </div>

          <div class="col-md-6">
            <label class="form-label"><?php echo e(__('Display Name / Pseudonym')); ?> <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="hookup_name" placeholder="e.g. Sweet Candy" required>
          </div>

          <div class="col-md-6">
            <label class="form-label"><?php echo e(__('Age')); ?> <span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="hookup_age" placeholder="e.g. 24" min="18" max="99" required>
          </div>

          <div class="col-md-6">
            <label class="form-label"><?php echo e(__('Gender')); ?> <span class="text-danger">*</span></label>
            <select class="form-select text-secondary" name="hookup_gender" required>
              <option value="">Select Gender</option>
              <option value="female">Female</option>
              <option value="male">Male</option>
              <option value="trans">Transgender</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label"><?php echo e(__('Sexual Orientation')); ?></label>
            <select class="form-select text-secondary" name="hookup_orientation">
              <option value="">Select Orientation</option>
              <option value="straight">Straight</option>
              <option value="bisexual">Bisexual</option>
              <option value="gay">Gay / Lesbian</option>
            </select>
          </div>

          <div class="col-12 mt-5">
            <h5 class="text-warning fw-bold mb-3 border-bottom pb-2"
              style="border-color:rgba(255,255,255,0.1) !important;">
              <?php echo e(__('Location & Services')); ?>

            </h5>
          </div>

          <div class="col-md-6">
            <label class="form-label"><?php echo e(__('City / Neighborhood')); ?> <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="hookup_location" placeholder="e.g. Kilimani, Nairobi" required>
          </div>

          <div class="col-md-6">
            <label class="form-label"><?php echo e(__('Base Rate (KSh per hour)')); ?> <span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="hookup_rate" placeholder="e.g. 5000" min="0" required>
          </div>

          <div class="col-12">
            <label class="form-label d-block mb-3">
              <?php echo e(__('Service Types Offered')); ?> <span class="text-danger">*</span>
            </label>
            <div class="d-flex gap-4">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="services[]" value="incall" id="serviceIncall">
                <label class="form-check-label text-light" for="serviceIncall"><?php echo e(__('Incall (I host)')); ?></label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="services[]" value="outcall" id="serviceOutcall">
                <label class="form-check-label text-light" for="serviceOutcall"><?php echo e(__('Outcall (I travel)')); ?></label>
              </div>
            </div>
          </div>

          <div class="col-12 mt-5">
            <h5 class="text-warning fw-bold mb-3 border-bottom pb-2"
              style="border-color:rgba(255,255,255,0.1) !important;">
              <?php echo e(__('Bio & Media')); ?>

            </h5>
          </div>

          <div class="col-12">
            <label class="form-label"><?php echo e(__('About Me / Description')); ?> <span class="text-danger">*</span></label>
            <textarea class="form-control" name="hookup_bio" rows="5"
              placeholder="Tell potential clients what makes you special..." required></textarea>
            <div class="small text-secondary mt-1">
              <?php echo e(__('Include details about your personality, specific services offered, and boundaries.')); ?>

            </div>
          </div>

          <div class="col-md-6">
            <label class="form-label"><?php echo e(__('Profile Picture')); ?> <span class="text-danger">*</span></label>
            <input type="file" class="form-control text-secondary" name="hookup_profile_pic" accept="image/*" required>
          </div>

          <div class="col-md-6">
            <label class="form-label"><?php echo e(__('Gallery Images (Up to 5)')); ?></label>
            <input type="file" class="form-control text-secondary" name="hookup_gallery[]" accept="image/*" multiple>
          </div>

          <div class="col-12 mt-4 pt-3 border-top" style="border-color:rgba(255,255,255,0.1) !important;">
            <div class="form-check mb-4">
              <input class="form-check-input" type="checkbox" id="termsCheck" required>
              <label class="form-check-label text-light small" for="termsCheck">
                <?php echo e(__("I confirm that I am at least 18 years old and agree to the platform's Terms of Service and Privacy Policy regarding hookup listings.")); ?>

              </label>
            </div>
            <div class="d-flex justify-content-end">
              <button type="button"
                class="btn btn-orange px-5 py-3 fw-bold"
                style="border-radius:8px; font-size:1.1rem;"
                @click="if(document.getElementById('hookupForm').reportValidity()){ step=2; window.scrollTo({top:0,behavior:'smooth'}); }">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-2">
                  <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                  <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                <?php echo e(__('Continue to Payment')); ?>

              </button>
            </div>
          </div>

        </div>
      </div>

      
      <div x-show="step === 2" style="display:none;" x-cloak x-transition>

        <h4 class="text-warning fw-bold mb-4"><?php echo e(__('Select Payment Plan')); ?></h4>

        <div class="row g-4 mb-4">
          
          <div class="col-12 col-lg-5">
            <div class="p-4 rounded h-100 d-flex flex-column"
              style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.1);">
              <div class="mb-4">
                <div class="fs-4 fw-bold text-light mb-1">HOOKUP LISTING</div>
                <div class="fs-6 text-warning fw-bold">From KSh 400.00</div>
              </div>
              <ul class="list-unstyled text-secondary small mb-0 flex-grow-1" style="line-height:1.9;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['3 Day Listing' => '400', '7 Days Listing' => '700', '15 Days Listing' => '1,300', '30 Days Listing' => '2,000']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $price): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <li class="d-flex align-items-start gap-2 mb-2">
                  <svg class="mt-1 flex-shrink-0" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#28a745" stroke-width="3" stroke-linecap="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                  <span><span class="fw-medium text-light"><?php echo e($label); ?></span> = <?php echo e($price); ?> Ksh</span>
                </li>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <li class="d-flex align-items-start gap-2 mb-2">
                  <svg class="mt-1 flex-shrink-0" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#28a745" stroke-width="3" stroke-linecap="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                  <span>Listed on respective Geo Location section.</span>
                </li>
                <li class="d-flex align-items-start gap-2">
                  <svg class="mt-1 flex-shrink-0" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#28a745" stroke-width="3" stroke-linecap="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                  <span>Can upload up to 4 Photos.</span>
                </li>
              </ul>
            </div>
          </div>

          
          <div class="col-12 col-lg-7">
            <div class="p-4 rounded h-100"
              style="border:1px solid rgba(255,140,0,0.3); background:rgba(0,0,0,0.2);">

              <div class="mb-4">
                <label class="form-label"><?php echo e(__('Select Plan')); ?></label>
                <select class="form-select"
                  style="background:rgba(255,255,255,0.05); color:#fff; border-color:rgba(255,140,0,0.3);"
                  x-model="planDays">
                  <option value="3">3 Days — KSh 400</option>
                  <option value="7">7 Days — KSh 700</option>
                  <option value="15">15 Days — KSh 1,300</option>
                  <option value="30">30 Days — KSh 2,000</option>
                </select>
              </div>

              
              <div class="mb-4">
                <label class="form-label"><?php echo e(__('Payment Method')); ?></label>
                <div class="d-flex align-items-center gap-3 p-3 rounded"
                  style="background:rgba(40,167,69,0.08); border:1px solid rgba(40,167,69,0.3);">
                  <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                    style="width:40px; height:40px; background:#28a745;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2">
                      <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                    </svg>
                  </div>
                  <div class="flex-grow-1">
                    <div class="text-success fw-bold" style="font-size:0.95rem;">M-PESA</div>
                    <div class="text-secondary" style="font-size:0.8rem;">Lipa Na M-PESA · No transaction fee</div>
                  </div>
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#28a745" stroke-width="3" stroke-linecap="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                  </svg>
                </div>
              </div>

              
              <div class="p-3 rounded mb-4" style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.1);">
                <div class="d-flex justify-content-between mb-2 text-secondary small">
                  <span>Plan Price:</span>
                  <span class="text-light fw-medium">KSh <span x-text="prices[planDays].toLocaleString()"></span></span>
                </div>
                <div class="d-flex justify-content-between mb-2 text-secondary small">
                  <span>Transaction Fee:</span>
                  <span class="text-success fw-medium">KSh 0.00</span>
                </div>
                <div class="d-flex justify-content-between pt-2 mt-1 border-top" style="border-color:rgba(255,255,255,0.1) !important;">
                  <span class="text-light fw-bold">Total:</span>
                  <span class="text-warning fw-bold fs-5">KSh <span x-text="prices[planDays].toLocaleString()"></span></span>
                </div>
              </div>

              <div class="d-flex justify-content-between gap-3">
                <button type="button" class="btn btn-outline-secondary px-4 py-2 fw-bold" style="border-radius:8px;"
                  @click="step=1; window.scrollTo({top:0,behavior:'smooth'});">
                  ← Back
                </button>
                <button type="button" class="btn btn-orange px-4 py-2 fw-bold" style="border-radius:8px; flex:1;"
                  @click="step=3; window.scrollTo({top:0,behavior:'smooth'});">
                  Pay &amp; Publish
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="ms-1">
                    <path d="M5 12l5 5l10 -10"/>
                  </svg>
                </button>
              </div>

            </div>
          </div>
        </div>

      </div>

      
      <div x-show="step === 3" style="display:none;" x-cloak x-transition>

        
        <div class="position-relative d-flex justify-content-between align-items-center mb-5 px-2">
          
          <div class="position-absolute top-50 start-0 end-0 translate-middle-y"
            style="height:2px; background:rgba(255,255,255,0.08); z-index:1; margin:0 21px;"></div>

          
          <div class="text-center position-relative" style="z-index:2;">
            <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2"
              style="width:44px; height:44px; background:#28a745; border:4px solid #0d0d0d; color:#fff;">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
              </svg>
            </div>
            <div class="text-success fw-bold text-uppercase" style="font-size:0.68rem; letter-spacing:1px;">Details</div>
          </div>

          
          <div class="text-center position-relative" style="z-index:2;">
            <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2"
              style="width:44px; height:44px; font-weight:800; font-size:1.1rem; background:#28a745; border:4px solid #0d0d0d; color:#fff; box-shadow:0 0 24px rgba(40,167,69,0.5);">
              2
            </div>
            <div class="text-success fw-bold text-uppercase" style="font-size:0.68rem; letter-spacing:1px;">M-PESA</div>
          </div>

          
          <div class="text-center position-relative" style="z-index:2;">
            <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2"
              style="width:44px; height:44px; font-weight:700; background:#1c1c1c; border:2px solid rgba(255,255,255,0.12); color:rgba(255,255,255,0.35);">
              3
            </div>
            <div class="text-secondary fw-bold text-uppercase" style="font-size:0.68rem; letter-spacing:1px;">Confirm</div>
          </div>
        </div>

        
        <div class="text-center mb-5">
          <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
            style="width:72px; height:72px; background:rgba(40,167,69,0.1); border:2px solid rgba(40,167,69,0.35);">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#28a745" stroke-width="2">
              <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
            </svg>
          </div>
          <h3 class="text-light mb-1" style="font-weight:900; font-size:1.65rem; letter-spacing:1.5px;">
            PAY WITH M-PESA
          </h3>
          <p class="text-secondary mb-0" style="font-size:0.95rem;">Enter Your M-Pesa Number Below</p>
        </div>

        
        <div class="d-flex align-items-center justify-content-between p-3 rounded mb-4"
          style="background:rgba(255,140,0,0.05); border:1px solid rgba(255,140,0,0.22);">
          <div class="d-flex align-items-center gap-2">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
              <line x1="16" y1="2" x2="16" y2="6"></line>
              <line x1="8" y1="2" x2="8" y2="6"></line>
              <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
            <span class="text-secondary small">
              Hookup Listing ·
              <span class="text-warning fw-semibold" x-text="planDays + ' Days'"></span>
            </span>
          </div>
          <span class="text-warning fw-bold">
            KSh <span x-text="prices[planDays].toLocaleString()"></span>
          </span>
        </div>

        
        <div class="mb-4">
          <label class="form-label fw-bold" style="font-size:1rem;">M-PESA Phone Number</label>
          <div class="input-group input-group-lg">
            <span class="input-group-text"
              style="background:rgba(40,167,69,0.08); border-color:rgba(40,167,69,0.3); color:#28a745;">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
              </svg>
            </span>
            <input type="tel"
              class="form-control form-control-lg"
              placeholder="254722xxxxxx"
              x-model="mpesaPhone"
              pattern="^254[0-9]{9}$"
              maxlength="12"
              autocomplete="tel"
              style="background:rgba(0,0,0,0.3); border-color:rgba(40,167,69,0.3); color:#fff; font-size:1.15rem; letter-spacing:3px; text-align:center;">
          </div>
          <div class="text-center text-secondary mt-2" style="font-size:0.8rem;">
            Format: 254XXXXXXXXX &nbsp;·&nbsp; e.g. 254722123456
          </div>
        </div>

        
        <button type="submit" id="mpesaSubmitBtn"
          class="w-100 py-3 fw-bold rounded-2 d-flex align-items-center justify-content-center gap-2"
          style="background:#28a745; border:2px solid #28a745; color:#fff; font-size:1.05rem; letter-spacing:0.5px; font-family:'Outfit',sans-serif; transition:all 0.3s ease; cursor:pointer;"
          :disabled="loading || mpesaPhone.length < 12"
          :class="{ 'opacity-75': loading || mpesaPhone.length < 12 }"
          @click="if(mpesaPhone.length >= 12) loading = true"
          onmouseover="if(!this.disabled){ this.style.background='#218838'; this.style.borderColor='#218838'; }"
          onmouseout="if(!this.disabled){ this.style.background='#28a745'; this.style.borderColor='#28a745'; }">

          <template x-if="!loading">
            <span class="d-flex align-items-center gap-2">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
              </svg>
              Send Payment Request to Phone
            </span>
          </template>
          <template x-if="loading">
            <span class="d-flex align-items-center gap-2">
              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              Sending Payment Request…
            </span>
          </template>
        </button>

        
        <div class="text-center mt-3">
          <button type="button"
            class="btn btn-link p-0 text-secondary text-decoration-none"
            style="font-size:0.85rem;"
            @click="step=2; loading=false; window.scrollTo({top:0,behavior:'smooth'});">
            ← Change Plan
          </button>
        </div>

        
        <div class="rounded p-4 mt-5" style="background:rgba(40,167,69,0.04); border:1px solid rgba(40,167,69,0.18);">
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [
            ['Check your phone for the M-PESA PIN prompt', 'A payment request will be sent to your Safaricom number.'],
            ['Key in your M-PESA PIN and confirm',         'Enter your PIN on the Safaricom STK push popup to authorise.'],
            ['Wait for this page to refresh',              'Once payment is confirmed you will be moved to the next step automatically.']
          ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
          <div class="d-flex align-items-start gap-3 <?php echo e($i < 2 ? 'mb-4' : ''); ?>">
            <div class="flex-shrink-0 mt-1">
              <div class="rounded-circle d-flex align-items-center justify-content-center"
                style="width:30px; height:30px; background:rgba(40,167,69,0.12); border:1px solid rgba(40,167,69,0.4);">
                <span class="text-success fw-bold" style="font-size:0.78rem;"><?php echo e($i + 1); ?></span>
              </div>
            </div>
            <div>
              <div class="text-light fw-semibold mb-1" style="font-size:0.92rem;"><?php echo e($item[0]); ?></div>
              <div class="text-secondary" style="font-size:0.82rem;"><?php echo e($item[1]); ?></div>
            </div>
          </div>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>

      </div>

    </form>
  </div>

</div>
<?php /**PATH C:\Users\willi\Desktop\Kenyan Baddies Club\resources\views/profile/partials/hookup-listing-form.blade.php ENDPATH**/ ?>