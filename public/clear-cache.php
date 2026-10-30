<?php
// Emergency cache-clear + diagnostics script
// Access: https://kenyanbaddies.com/clear-cache.php?token=kbc-clear-2026
if (($_GET['token'] ?? '') !== 'kbc-clear-2026') { http_response_code(404); die('Not found'); }

header('Content-Type: text/plain; charset=utf-8');

$candidateBases = [
    '/home/kenyanba/repositories/Baddies',
    '/home/kenyanba/laravel-app',
    dirname(__DIR__),
];
$base = dirname(__DIR__);
foreach ($candidateBases as $b) {
    if (file_exists($b . '/artisan') || file_exists($b . '/vendor/autoload.php')) {
        $base = $b;
        break;
    }
}
echo "Base path: $base\n";
echo "PHP version: " . PHP_VERSION . "\n\n";

// --- Recursive delete ---
$deleted = [];
$errors  = [];

function rDelete(string $path, string $base, array &$d, array &$e): void {
    if (is_file($path)) {
        if (basename($path) === '.gitignore') return;
        if (@unlink($path)) $d[] = ltrim(str_replace($base, '', $path), '/\\');
        else $e[] = ltrim(str_replace($base, '', $path), '/\\');
    } elseif (is_dir($path) && is_readable($path)) {
        $items = @scandir($path);
        if (is_array($items)) {
            foreach ($items as $item) {
                if ($item === '.' || $item === '..') continue;
                rDelete($path . DIRECTORY_SEPARATOR . $item, $base, $d, $e);
            }
        }
    }
}

$clearDirs = [
    $base . '/bootstrap/cache',
    $base . '/storage/framework/cache/data',
    $base . '/storage/framework/views',
    $base . '/storage/framework/sessions',
];

foreach ($clearDirs as $dir) {
    if (is_dir($dir)) rDelete($dir, $base, $deleted, $errors);
}

echo "=== Cleared " . count($deleted) . " cached file(s) ===\n";
foreach ($deleted as $f) echo "  OK  $f\n";
if ($errors) {
    echo "\n=== Could not delete " . count($errors) . " file(s) ===\n";
    foreach ($errors as $f) echo "  ERR $f\n";
}

// --- Show last 60 lines of laravel.log ---
$logFile = $base . '/storage/logs/laravel.log';
echo "\n=== laravel.log (last 60 lines) ===\n";
if (!file_exists($logFile)) {
    echo "(log file not found at $logFile)\n";
} else {
    $lines = file($logFile, FILE_IGNORE_NEW_LINES);
    $tail  = array_slice($lines, -60);
    echo implode("\n", $tail) . "\n";
}

echo "\n=== Done ===\nReload kenyanbaddies.com now.\n";
