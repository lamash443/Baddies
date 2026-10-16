<?php
/**
 * Kenyan Baddies Club — One-Time Server Setup Page
 * =====================================================
 * Access via browser: https://www.kenyanbaddies.com/kbc-setup-7x9q2.php
 *
 * SECURITY: Delete this file from the server after use!
 * The secret token below protects it from public access.
 *
 * AFTER USE: Delete this file or it will be overwritten on next deploy anyway
 * since it lives in public/ and .cpanel.yml copies public/ each time.
 */

// ── Secret token — change this before deploying if you want extra security ──
define('SETUP_TOKEN', 'kbc-setup-2026-secure');

$token = $_GET['token'] ?? '';
if ($token !== SETUP_TOKEN) {
    http_response_code(404);
    echo '<!DOCTYPE html><html><body style="font-family:sans-serif;text-align:center;padding:3rem;">
        <h2>404 Not Found</h2><p>The page you requested was not found.</p>
    </body></html>';
    exit;
}

// ── Paths ────────────────────────────────────────────────────────────────────
$appDir   = '/home/kenyanba/laravel-app';
$artisan  = $appDir . '/artisan';
$php      = '/usr/local/bin/php';
$envFile  = $appDir . '/.env';
$envProd  = $appDir . '/.env.production';

$results = [];

function run(string $cmd): array {
    $output = [];
    $code   = 0;
    exec($cmd . ' 2>&1', $output, $code);
    return ['cmd' => $cmd, 'output' => implode("\n", $output), 'code' => $code];
}

// ── Run requested action ──────────────────────────────────────────────────────
$action = $_GET['action'] ?? 'status';

if ($action === 'fix-env') {
    // Patch critical .env values without overwriting the whole file
    $env = file_get_contents($envFile);
    $patches = [
        '/^APP_URL=.*/m'         => 'APP_URL=https://www.kenyanbaddies.com',
        '/^FILESYSTEM_DISK=.*/m' => 'FILESYSTEM_DISK=public',
        '/^SESSION_DRIVER=.*/m'  => 'SESSION_DRIVER=database',
        '/^SESSION_DOMAIN=.*/m'  => 'SESSION_DOMAIN=null',
        '/^APP_DEBUG=.*/m'       => 'APP_DEBUG=false',
    ];
    foreach ($patches as $pattern => $replacement) {
        $env = preg_replace($pattern, $replacement, $env);
    }
    file_put_contents($envFile, $env);
    $results[] = ['cmd' => 'Patch .env', 'output' => 'Done ✅', 'code' => 0];
}

if ($action === 'clear-cache' || $action === 'full-setup') {
    $results[] = run("$php $artisan config:clear");
    $results[] = run("$php $artisan cache:clear");
    $results[] = run("$php $artisan route:clear");
    $results[] = run("$php $artisan view:clear");
}

if ($action === 'migrate' || $action === 'full-setup') {
    $results[] = run("$php $artisan migrate --force");
}

if ($action === 'rebuild-cache' || $action === 'full-setup') {
    $results[] = run("$php $artisan config:cache");
    $results[] = run("$php $artisan route:cache");
    $results[] = run("$php $artisan view:cache");
}

if ($action === 'fix-storage') {
    $results[] = run("rm -rf /home/kenyanba/public_html/storage");
    $results[] = run("ln -sfn /home/kenyanba/laravel-app/storage/app/public /home/kenyanba/public_html/storage");
    $results[] = run("chmod -R 775 $appDir/storage");
    $results[] = run("chmod -R 775 $appDir/bootstrap/cache");
}

if ($action === 'full-setup') {
    // Fix env first
    $env = file_get_contents($envFile);
    $patches = [
        '/^APP_URL=.*/m'         => 'APP_URL=https://www.kenyanbaddies.com',
        '/^FILESYSTEM_DISK=.*/m' => 'FILESYSTEM_DISK=public',
        '/^SESSION_DRIVER=.*/m'  => 'SESSION_DRIVER=database',
        '/^SESSION_DOMAIN=.*/m'  => 'SESSION_DOMAIN=null',
        '/^APP_DEBUG=.*/m'       => 'APP_DEBUG=false',
    ];
    foreach ($patches as $pattern => $replacement) {
        $env = preg_replace($pattern, $replacement, $env);
    }
    file_put_contents($envFile, $env);
    $results[] = ['cmd' => 'Patch .env', 'output' => 'Done ✅', 'code' => 0];

    // Fix storage symlink
    $results[] = run("rm -rf /home/kenyanba/public_html/storage");
    $results[] = run("ln -sfn /home/kenyanba/laravel-app/storage/app/public /home/kenyanba/public_html/storage");
    $results[] = run("chmod -R 775 $appDir/storage");
    $results[] = run("chmod -R 775 $appDir/bootstrap/cache");
}

// ── Status info ───────────────────────────────────────────────────────────────
$envContent   = file_exists($envFile) ? file_get_contents($envFile) : 'NOT FOUND';
$symlinkCheck = run("ls -la /home/kenyanba/public_html/storage");
$phpVersion   = run("$php -v");

function envVal(string $key, string $env): string {
    preg_match("/^{$key}=(.*)$/m", $env, $m);
    return $m[1] ?? '(not set)';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KBC Server Setup</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #0d0d0d; color: #eee; padding: 2rem; }
        h1 { color: #ff8c00; margin-bottom: 0.25rem; }
        .subtitle { color: #888; font-size: 0.9rem; margin-bottom: 2rem; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
        .card { background: #1a1a1a; border: 1px solid #333; border-radius: 10px; padding: 1.25rem; }
        .card h3 { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; color: #888; margin-bottom: 0.5rem; }
        .card .val { font-size: 1rem; color: #fff; word-break: break-all; }
        .ok { color: #4ade80 !important; }
        .bad { color: #f87171 !important; }
        .warn { color: #fb923c !important; }
        .actions { display: flex; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 2rem; }
        .btn { display: inline-block; padding: 0.65rem 1.25rem; border-radius: 8px; font-weight: 600; font-size: 0.9rem; cursor: pointer; text-decoration: none; border: none; }
        .btn-primary  { background: #ff8c00; color: #000; }
        .btn-danger   { background: #dc2626; color: #fff; }
        .btn-secondary{ background: #333; color: #fff; }
        .btn-green    { background: #16a34a; color: #fff; }
        .results { margin-top: 1rem; }
        .result-item { background: #111; border: 1px solid #2a2a2a; border-radius: 8px; padding: 1rem; margin-bottom: 0.75rem; }
        .result-cmd  { font-size: 0.8rem; color: #888; font-family: monospace; margin-bottom: 0.5rem; }
        .result-out  { font-family: monospace; font-size: 0.85rem; white-space: pre-wrap; word-break: break-word; }
        .result-ok   { border-left: 3px solid #4ade80; }
        .result-fail { border-left: 3px solid #f87171; }
        .warning-box { background: #7c2d12; border: 1px solid #f87171; border-radius: 8px; padding: 1rem; margin-bottom: 2rem; font-size: 0.9rem; }
        .warning-box strong { color: #fca5a5; }
    </style>
</head>
<body>

<h1>🔧 KBC Server Setup</h1>
<p class="subtitle">kenyanbaddies.com — One-time server configuration panel</p>

<div class="warning-box">
    <strong>⚠️ Security Notice:</strong> Delete or rename this file after use.
    It will be replaced automatically on next git push since <code>public/</code> is overwritten by the deploy script.
</div>

<!-- ── Status Cards ── -->
<div class="grid">
    <div class="card">
        <h3>PHP Version</h3>
        <div class="val"><?= htmlspecialchars(explode("\n", $phpVersion['output'])[0] ?? '?') ?></div>
    </div>
    <div class="card">
        <h3>APP_URL</h3>
        <?php $v = envVal('APP_URL', $envContent); ?>
        <div class="val <?= str_contains($v, 'kenyanbaddies') ? 'ok' : 'bad' ?>"><?= htmlspecialchars($v) ?></div>
    </div>
    <div class="card">
        <h3>APP_ENV</h3>
        <?php $v = envVal('APP_ENV', $envContent); ?>
        <div class="val <?= $v === 'production' ? 'ok' : 'warn' ?>"><?= htmlspecialchars($v) ?></div>
    </div>
    <div class="card">
        <h3>APP_DEBUG</h3>
        <?php $v = envVal('APP_DEBUG', $envContent); ?>
        <div class="val <?= $v === 'false' ? 'ok' : 'bad' ?>"><?= htmlspecialchars($v) ?></div>
    </div>
    <div class="card">
        <h3>SESSION_DRIVER</h3>
        <?php $v = envVal('SESSION_DRIVER', $envContent); ?>
        <div class="val <?= $v === 'database' ? 'ok' : 'warn' ?>"><?= htmlspecialchars($v) ?></div>
    </div>
    <div class="card">
        <h3>FILESYSTEM_DISK</h3>
        <?php $v = envVal('FILESYSTEM_DISK', $envContent); ?>
        <div class="val <?= $v === 'public' ? 'ok' : 'bad' ?>"><?= htmlspecialchars($v) ?></div>
    </div>
    <div class="card">
        <h3>SESSION_DOMAIN</h3>
        <?php $v = envVal('SESSION_DOMAIN', $envContent); ?>
        <div class="val <?= $v === 'null' || $v === '' ? 'ok' : 'warn' ?>"><?= htmlspecialchars($v) ?></div>
    </div>
    <div class="card">
        <h3>Storage Symlink</h3>
        <?php $symOk = str_contains($symlinkCheck['output'], 'laravel-app/storage'); ?>
        <div class="val <?= $symOk ? 'ok' : 'bad' ?>"><?= $symOk ? '✅ Linked' : '❌ Broken or missing' ?></div>
    </div>
    <div class="card">
        <h3>DB_DATABASE</h3>
        <div class="val"><?= htmlspecialchars(envVal('DB_DATABASE', $envContent)) ?></div>
    </div>
</div>

<!-- ── Actions ── -->
<h2 style="margin-bottom:1rem; color:#ff8c00;">Actions</h2>
<div class="actions">
    <a class="btn btn-primary"    href="?token=<?= SETUP_TOKEN ?>&action=full-setup">🚀 Full Setup (Recommended)</a>
    <a class="btn btn-secondary"  href="?token=<?= SETUP_TOKEN ?>&action=fix-env">📝 Fix .env Only</a>
    <a class="btn btn-secondary"  href="?token=<?= SETUP_TOKEN ?>&action=fix-storage">🔗 Fix Storage Symlink</a>
    <a class="btn btn-secondary"  href="?token=<?= SETUP_TOKEN ?>&action=clear-cache">🗑️ Clear All Caches</a>
    <a class="btn btn-secondary"  href="?token=<?= SETUP_TOKEN ?>&action=migrate">🗄️ Run Migrations</a>
    <a class="btn btn-green"      href="?token=<?= SETUP_TOKEN ?>&action=rebuild-cache">⚡ Rebuild Caches</a>
    <a class="btn btn-secondary"  href="?token=<?= SETUP_TOKEN ?>&action=status">🔄 Refresh Status</a>
</div>

<!-- ── Results ── -->
<?php if (!empty($results)): ?>
<h2 style="margin-bottom:1rem; color:#ff8c00;">Results for: <code style="font-size:0.9rem;"><?= htmlspecialchars($action) ?></code></h2>
<div class="results">
    <?php foreach ($results as $r): ?>
    <div class="result-item <?= $r['code'] === 0 ? 'result-ok' : 'result-fail' ?>">
        <div class="result-cmd">$ <?= htmlspecialchars($r['cmd']) ?></div>
        <div class="result-out"><?= htmlspecialchars($r['output'] ?: '(no output)') ?></div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- ── Symlink detail ── -->
<h2 style="margin:2rem 0 1rem; color:#ff8c00;">Storage Symlink Detail</h2>
<div class="result-item <?= str_contains($symlinkCheck['output'], 'laravel') ? 'result-ok' : 'result-fail' ?>">
    <div class="result-cmd">$ ls -la /home/kenyanba/public_html/storage</div>
    <div class="result-out"><?= htmlspecialchars($symlinkCheck['output']) ?></div>
</div>

</body>
</html>
