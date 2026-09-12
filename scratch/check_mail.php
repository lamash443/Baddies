<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$settings = App\Models\SiteSetting::where('key', 'like', 'mail_%')->get();
foreach ($settings as $s) {
    echo $s->key . ' = ' . $s->value . PHP_EOL;
}
