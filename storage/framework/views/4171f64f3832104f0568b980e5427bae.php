
<?php
    $faviconUrl = asset('favicon.ico');
    if (!empty($siteSettings['favicon'])) {
        $path = storage_path('app/public/' . $siteSettings['favicon']);
        $version = file_exists($path) ? filemtime($path) : time();
        $faviconUrl = asset('storage/' . $siteSettings['favicon']) . '?v=' . $version;
    }
?>
<link rel="icon" type="image/x-icon" href="<?php echo e($faviconUrl); ?>">
<link rel="shortcut icon" href="<?php echo e($faviconUrl); ?>">
<?php /**PATH C:\Users\willi\Desktop\Kenyan Baddies Club\resources\views/components/site-favicon.blade.php ENDPATH**/ ?>