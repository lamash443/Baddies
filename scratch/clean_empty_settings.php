<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Ensure any empty string values in SiteSetting table are converted to null
\App\Models\SiteSetting::where('value', '')->orWhereNull('value')->delete();
\Illuminate\Support\Facades\Cache::forget('site_settings');
echo "Cleaned empty site settings successfully!\n";
