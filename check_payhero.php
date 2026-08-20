<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$username = config('services.payhero.username');
$password = config('services.payhero.password');
$channelId = config('services.payhero.channel_id');
$accountId = config('services.payhero.account_id');

echo "Username: $username\n";
echo "Password: " . $password . "\n";
echo "Channel: $channelId\n";
echo "Account: $accountId\n";

$credentials = base64_encode($username . ':' . $password);
echo "Auth Header: Basic $credentials\n";

$payload = [
    'amount' => 10,
    'phone_number' => '254708344101',
    'provider' => 'm-pesa',
    'network_code' => '63902',
    'channel_id' => (int)$channelId,
    'account_id' => (int)$accountId,
    'external_reference' => 'test_diagnose',
    'callback_url' => 'http://localhost/callback',
];

$urls = [
    'https://api.payhero.africa/api/v2/payments',
    'https://backend.payhero.co.ke/api/v2/payments'
];

foreach ($urls as $url) {
    echo "\nTesting: $url\n";
    $response = Illuminate\Support\Facades\Http::withHeaders([
        'Content-Type' => 'application/json',
        'Authorization' => 'Basic ' . $credentials,
    ])->post($url, $payload);

    echo "Status: " . $response->status() . "\n";
    echo "Body: " . $response->body() . "\n";
}

