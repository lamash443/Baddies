<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deposits->isEmpty()): ?>
  <div class="text-center py-4 rounded" style="border:1px dashed rgba(255,140,0,0.2);">
    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="1.5" class="mb-2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    <h6 class="fw-bold mb-1" style="font-size:0.9rem;"><?php echo e(__('No transaction history found.')); ?></h6>
    <p class="text-secondary mb-0" style="font-size:0.78rem;"><?php echo e(__('When you add funds or an admin updates your balance, it will appear here.')); ?></p>
  </div>
<?php else: ?>
  <div class="table-responsive mb-3" style="padding-bottom: 0.4rem;">
    <table class="table table-borderless align-middle mb-0" style="background: transparent !important; color: inherit !important;">
      <thead>
        <tr style="border-bottom: 1.5px solid rgba(255,140,0,0.25); background: transparent !important;">
          <th class="text-uppercase text-secondary fw-bold py-2" style="font-size:0.72rem; letter-spacing:1px; background: transparent !important; color: inherit !important;">Date</th>
          <th class="text-uppercase text-secondary fw-bold py-2" style="font-size:0.72rem; letter-spacing:1px; background: transparent !important; color: inherit !important;">Ref / Method</th>
          <th class="text-uppercase text-secondary fw-bold py-2 text-end" style="font-size:0.72rem; letter-spacing:1px; background: transparent !important; color: inherit !important;">Amount</th>
          <th class="text-uppercase text-secondary fw-bold py-2 text-center" style="font-size:0.72rem; letter-spacing:1px; background: transparent !important; color: inherit !important;">Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $deposits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deposit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
          <tr style="border-bottom: 1px solid rgba(255,140,0,0.08); background: transparent !important;">
            <td class="py-2 text-nowrap" style="background: transparent !important; color: inherit !important;">
              <div class="fw-bold" style="font-size:0.85rem;"><?php echo e($deposit->created_at->format('M d, Y')); ?></div>
              <div class="text-secondary" style="font-size:0.72rem;"><?php echo e($deposit->created_at->format('h:i A')); ?></div>
            </td>
            <td class="py-2" style="background: transparent !important; color: inherit !important;">
              <div class="fw-bold" style="font-size:0.85rem;"><?php echo e($deposit->reference ?? 'N/A'); ?></div>
              <div class="text-uppercase" style="color:orange; font-weight:700; font-size:0.72rem; letter-spacing:0.5px;"><?php echo e($deposit->payment_method); ?></div>
            </td>
            <td class="py-2 text-end fw-bold" style="background: transparent !important; color: inherit !important; font-size:0.95rem;">
              KSh <?php echo e(number_format($deposit->amount, 2)); ?>

            </td>
            <td class="py-2 text-center" style="background: transparent !important;">
              <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deposit->status === 'completed'): ?>
                <span class="fw-bold" style="color:#28a745; font-size:0.8rem;">Completed</span>
              <?php elseif($deposit->status === 'failed'): ?>
                <span class="fw-bold" style="color:#ff4d4d; font-size:0.8rem;">Failed</span>
              <?php else: ?>
                <span class="fw-bold" style="color:orange; font-size:0.8rem;"><?php echo e(ucfirst($deposit->status)); ?></span>
              <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </td>
          </tr>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
      </tbody>
    </table>
  </div>

  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deposits->hasPages()): ?>
    <div class="d-flex justify-content-center pt-2 mt-3">
      <?php echo e($deposits->fragment('tab-wallet')->links('pagination::bootstrap-5')); ?>

    </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH C:\Users\willi\Desktop\Kenyan Baddies Club\resources\views/profile/partials/wallet-history.blade.php ENDPATH**/ ?>