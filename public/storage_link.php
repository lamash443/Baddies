<?php
/**
 * TEMPORARY SETUP SCRIPT - DELETE IMMEDIATELY AFTER RUNNING
 *
 * Creates the storage symlink for Truehost cPanel hosting.
 * Visit: https://www.kenyanbaddies.com/storage_link.php
 * Then DELETE this file from cPanel File Manager!
 */

$linkPath   = __DIR__ . '/storage';
$targetPath = __DIR__ . '/../storage/app/public';

echo '<style>body{font-family:sans-serif;max-width:700px;margin:40px auto;padding:20px;background:#111;color:#eee;}
.ok{color:#4ade80;}.err{color:#f87171;}.warn{color:#fbbf24;}pre{background:#222;padding:10px;border-radius:6px;}</style>';

echo '<h2>Kenyan Baddies Club - Storage Symlink Setup</h2>';

if (file_exists($linkPath) && is_link($linkPath)) {
    echo '<p class="ok">Storage symlink already exists.</p>';
    echo '<p>Target: <code>' . readlink($linkPath) . '</code></p>';
} elseif (file_exists($linkPath) && is_dir($linkPath) && !is_link($linkPath)) {
    echo '<p class="warn">public/storage is a real directory (from Git). Trying to rename and re-link...</p>';
    if (@rename($linkPath, $linkPath . '_backup_' . time())) {
        if (@symlink($targetPath, $linkPath)) {
            echo '<p class="ok">Done! Old directory renamed and symlink created.</p>';
        } else {
            @rename($linkPath . '_backup_' . time(), $linkPath);
            echo '<p class="err">symlink() failed. Host may not allow symlinks. See workaround below.</p>';
        }
    } else {
        echo '<p class="err">Could not rename existing storage directory.</p>';
    }
} else {
    if (function_exists("symlink") && @symlink($targetPath, $linkPath)) {
        echo '<p class="ok">Symlink created successfully!</p>';
    } else {
        echo '<p class="err">symlink() failed or unavailable. See workaround below.</p>';
        echo '<pre>
WORKAROUND: In cPanel File Manager:
1. Navigate to public_html/
2. If "storage" folder exists, delete it (it\'s empty from git)
3. Create a new symbolic link named "storage" pointing to:
   ../storage/app/public
</pre>';
    }
}

echo '<hr>';
$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    $env = file_get_contents($envPath);
    preg_match('/APP_URL=(.+)/', $env, $m);
    $appUrl = trim($m[1] ?? '');
    if (strpos($appUrl, '127.0.0.1') !== false || strpos($appUrl, 'localhost') !== false) {
        echo '<p class="err">APP_URL is still set to: <code>' . htmlspecialchars($appUrl) . '</code> - update it to https://www.kenyanbaddies.com</p>';
    } else {
        echo '<p class="ok">APP_URL = <code>' . htmlspecialchars($appUrl) . '</code></p>';
    }
}

echo '<hr><p class="err"><strong>DELETE THIS FILE after running it!</strong></p>';
