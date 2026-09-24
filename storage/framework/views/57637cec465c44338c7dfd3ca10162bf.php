<?php
    $logo = \App\Models\SiteSetting::get('logo');
?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($logo && \Illuminate\Support\Facades\Storage::disk('public')->exists($logo)): ?>
    <img src="<?php echo e(asset('storage/' . $logo)); ?>" <?php echo e($attributes->merge(['style' => 'object-fit: contain;'])); ?> alt="<?php echo e(config('app.name')); ?> Logo">
<?php else: ?>
    <span <?php echo e($attributes->merge(['class' => 'font-bold tracking-widest uppercase text-xl'])); ?> style="letter-spacing: 1px;">
        <span style="color: orange;">Baddies</span><span style="color: white;">Club</span>
    </span>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH C:\Users\willi\Desktop\Kenyan Baddies Club\resources\views\components\application-logo.blade.php ENDPATH**/ ?>