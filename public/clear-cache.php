<?php
// Emergency cache-clear script — bypasses Laravel routing entirely
// Access: https://kenyanbaddies.com/clear-cache.php?token=kbc-clear-2026
if (($_GET['token'] ?? '') !== 'kbc-clear-2026') { http_response_code(404); die('Not found'); }

$base    = dirname(__DIR__);  // /home/kenyanba/repositories/Baddies
$deleted = [];
$errors  = [];

// Recursive file deleter (skips .gitignore)
function clearDir(string $dir, string $base, array &$deleted, array &$errors): void {
    if (!is_dir($dir)) return;
    foreach (glob($dir . '/*') ?: [] as $f) {
        if (basename($f) === '.gitignore') continue;
        if (is_dir($f)) {
            clearDir($f, $base, $deleted, $errors);
        } elseif (is_file($f)) {
            if (@unlink($f)) {
                $deleted[] = str_replace($base . '/', '', $f);
            } else {
                $errors[] = 'Could not delete: ' . str_replace($base . '/', '', $f);
            }
        }
    }
}

$dirs = [
    $base . '/bootstrap/cache',          // includes filament/panels/ subdirectory
    $base . '/storage/framework/cache/data',
    $base . '/storage/framework/views',
    $base . '/storage/framework/sessions',
];

foreach ($dirs as $dir) {
    clearDir($dir, $base, $deleted, $errors);
}

header('Content-Type: text/plain');
echo "=== Emergency Cache Clear ===\n\n";
echo "Deleted " . count($deleted) . " file(s):\n";
foreach ($deleted as $f) echo "  - $f\n";
if ($errors) {
    echo "\nErrors:\n";
    foreach ($errors as $e) echo "  ! $e\n";
}

// Show last 30 lines of laravel log for diagnostics
$logFile = $base . '/storage/logs/laravel.log';
if (file_exists($logFile)) {
    $lines = file($logFile);
    $last  = array_slice($lines, -40);
    echo "\n=== Last 40 lines of laravel.log ===\n";
    echo implode('', $last);
}

echo "\nDone. All caches cleared including Filament panel cache. Reload the site now.\n";
