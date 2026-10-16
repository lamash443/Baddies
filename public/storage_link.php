<?php
/**
 * SETUP SCRIPT FOR TRUEHOST CPANEL HOSTING
 * Visit: https://www.kenyanbaddies.com/storage_link.php
 * Then DELETE this file from cPanel File Manager after running!
 */

echo '<!DOCTYPE html><html><head><title>Storage Symlink Setup</title>';
echo '<style>body{font-family:sans-serif;max-width:700px;margin:40px auto;padding:24px;background:#0d0d0d;color:#eee;border:1px solid #333;border-radius:12px;}
.ok{color:#4ade80;font-weight:bold;}.err{color:#f87171;font-weight:bold;}.warn{color:#fbbf24;}pre{background:#1a1a1a;padding:12px;border-radius:8px;border:1px solid #2a2a2a;overflow-x:auto;}code{color:#ff8c00;}</style></head><body>';

echo '<h2 style="color:#ff8c00;margin-top:0;">Kenyan Baddies Club — Truehost Storage Symlink Setup</h2>';

$linkPath = __DIR__ . '/storage';

// Find the real target path
$candidateTargets = [
    '/home/kenyanba/laravel-app/storage/app/public',
    dirname(__DIR__) . '/storage/app/public',
    dirname(__DIR__) . '/laravel-app/storage/app/public',
    __DIR__ . '/../storage/app/public',
    __DIR__ . '/../laravel-app/storage/app/public',
];

$targetPath = null;
foreach ($candidateTargets as $candidate) {
    if (is_dir($candidate)) {
        $targetPath = realpath($candidate) ?: $candidate;
        break;
    }
}

if (!$targetPath) {
    // If not found yet, default to the expected Truehost path
    $targetPath = '/home/kenyanba/laravel-app/storage/app/public';
    echo '<p class="warn">Note: Target path not detected directly, defaulting to: <code>' . htmlspecialchars($targetPath) . '</code></p>';
} else {
    echo '<p class="ok">Found storage target: <code>' . htmlspecialchars($targetPath) . '</code></p>';
}

// Remove broken symlink or old directory if needed
if (file_exists($linkPath) || is_link($linkPath)) {
    if (is_link($linkPath)) {
        $currentTarget = @readlink($linkPath);
        echo '<p>Existing symlink points to: <code>' . htmlspecialchars($currentTarget) . '</code></p>';
        if ($currentTarget !== $targetPath) {
            echo '<p class="warn">Updating symlink to point to the correct target...</p>';
            @unlink($linkPath);
        }
    } elseif (is_dir($linkPath)) {
        echo '<p class="warn">"storage" in public is a regular directory. Renaming to back it up...</p>';
        @rename($linkPath, $linkPath . '_backup_' . time());
    }
}

// Create symlink
if (!file_exists($linkPath) && !is_link($linkPath)) {
    if (function_exists('symlink') && @symlink($targetPath, $linkPath)) {
        echo '<p class="ok">Storage symlink created successfully!</p>';
    } else {
        echo '<p class="err">symlink() PHP function failed or is disabled by host.</p>';
        echo '<p>Don\'t worry! The application now includes a direct fallback route in Laravel that will serve images automatically regardless of symlinks.</p>';
        echo '<pre>Manual Workaround (if needed in cPanel Terminal / SSH):
ln -sfn ' . htmlspecialchars($targetPath) . ' ' . htmlspecialchars($linkPath) . '
</pre>';
    }
} else {
    echo '<p class="ok">Symlink is active and points to: <code>' . htmlspecialchars(@readlink($linkPath) ?: $linkPath) . '</code></p>';
}

echo '<hr style="border-color:#333;margin:24px 0;">';
echo '<h3 style="color:#ff8c00;">Environment Check:</h3>';

// Check .env
$envCandidates = [
    dirname(__DIR__) . '/.env',
    dirname(__DIR__) . '/laravel-app/.env',
    '/home/kenyanba/laravel-app/.env',
    __DIR__ . '/../.env',
];

$envPath = null;
foreach ($envCandidates as $candidate) {
    if (file_exists($candidate) && is_file($candidate)) {
        $envPath = $candidate;
        break;
    }
}

if ($envPath) {
    $env = file_get_contents($envPath);
    preg_match('/APP_URL=(.+)/', $env, $m);
    $appUrl = trim($m[1] ?? '');
    echo '<p>APP_URL: <code>' . htmlspecialchars($appUrl) . '</code></p>';

    preg_match('/SESSION_DRIVER=(.+)/', $env, $m);
    $sessDriver = trim($m[1] ?? '');
    echo '<p>SESSION_DRIVER: <code>' . htmlspecialchars($sessDriver) . '</code> ' . ($sessDriver === 'database' ? '<span class="ok">(Optimal for Truehost)</span>' : '<span class="warn">(Recommend: database)</span>') . '</p>';

    preg_match('/SESSION_DOMAIN=(.+)/', $env, $m);
    $sessDomain = trim($m[1] ?? '');
    echo '<p>SESSION_DOMAIN: <code>' . htmlspecialchars($sessDomain) . '</code> ' . (empty($sessDomain) || $sessDomain === 'null' ? '<span class="ok">(Optimal)</span>' : '<span class="warn">(Recommend: null)</span>') . '</p>';
} else {
    echo '<p class="warn">Could not locate .env file for inspection.</p>';
}

echo '<hr style="border-color:#333;margin:24px 0;">';
echo '<p class="err"><strong>REMINDER: Delete this storage_link.php file after testing!</strong></p>';
echo '</body></html>';
