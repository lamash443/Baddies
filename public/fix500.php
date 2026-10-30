<?php
// One-shot 500 fixer — no Laravel, no dependencies
// https://kenyanbaddies.com/fix500.php
$base = dirname(__DIR__);
header('Content-Type: text/plain');

echo "Base: $base\n";
echo "PHP: " . PHP_VERSION . "\n\n";

// Show last error from laravel log
$log = $base . '/storage/logs/laravel.log';
if (file_exists($log)) {
    $lines = file($log, FILE_IGNORE_NEW_LINES);
    $tail  = array_slice($lines, -50);
    echo "=== LARAVEL LOG (last 50 lines) ===\n";
    echo implode("\n", $tail);
} else {
    echo "Log not found: $log\n";
}

