<?php
// Emergency cache-clear script — bypasses Laravel routing entirely
// Access: https://kenyanbaddies.com/clear-cache.php?token=kbc-clear-2026
if (($_GET['token'] ?? '') !== 'kbc-clear-2026') { http_response_code(404); die('Not found'); }

$base    = dirname(__DIR__);  // /home/kenyanba/repositories/Baddies
$deleted = [];
$errors  = [];

$dirs = [
    $base . '/bootstrap/cache',
    $base . '/storage/framework/cache/data',
    $base . '/storage/framework/views',
    $base . '/storage/framework/sessions',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) continue;
    foreach (glob($dir . '/*') ?: [] as $f) {
        if (!is_file($f) || basename($f) === '.gitignore') continue;
        if (@unlink($f)) {
            $deleted[] = str_replace($base . '/', '', $f);
        } else {
            $errors[] = 'Could not delete: ' . str_replace($base . '/', '', $f);
        }
    }
}

header('Content-Type: text/plain');
echo "=== Emergency Cache Clear ===\n\n";
echo "Deleted " . count($deleted) . " file(s):\n";
foreach ($deleted as $f) echo "  - $f\n";
if ($errors) {
    echo "\nErrors:\n";
    foreach ($errors as $e) echo "  ! $e\n";
}
echo "\nDone. Laravel cache cleared. Reload the site now.\n";
