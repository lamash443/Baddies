<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$user = \App\Models\User::first();
if (!$user) {
    echo "No user found.\n";
    exit;
}

auth()->login($user);
echo "Logged in as User ID {$user->id} ({$user->name})\n";

// Fetch chat partners
$userIds = \DB::table('messages')
    ->select(\DB::raw('CASE WHEN sender_id = ' . (int)$user->id . ' THEN receiver_id ELSE sender_id END as partner_id'), \DB::raw('MAX(created_at) as max_created_at'))
    ->where(function ($q) use ($user) {
        $q->where('sender_id', $user->id)->where('deleted_by_sender', false);
    })
    ->orWhere(function ($q) use ($user) {
        $q->where('receiver_id', $user->id)->where('deleted_by_receiver', false);
    })
    ->groupBy('partner_id')
    ->orderByDesc('max_created_at')
    ->pluck('partner_id')
    ->map(fn($id) => (int)$id);

echo "Found " . $userIds->count() . " chat partners.\n";

if ($userIds->count() > 0) {
    $targetPartnerId = $userIds[0];
    echo "Testing Pinning partner ID {$targetPartnerId}...\n";

    // Toggle Pin
    \App\Models\ChatPin::firstOrCreate(['user_id' => $user->id, 'pinned_user_id' => $targetPartnerId]);
    
    $pinnedUserIds = \App\Models\ChatPin::where('user_id', $user->id)->pluck('pinned_user_id')->map(fn($id) => (int)$id)->toArray();
    echo "Pinned User IDs: " . json_encode($pinnedUserIds) . "\n";
    
    if (in_array($targetPartnerId, $pinnedUserIds)) {
        echo "SUCCESS: Partner {$targetPartnerId} is pinned!\n";
    } else {
        echo "ERROR: Partner {$targetPartnerId} not pinned.\n";
    }

    // Clean up
    \App\Models\ChatPin::where('user_id', $user->id)->where('pinned_user_id', $targetPartnerId)->delete();
    echo "Cleaned up pin.\n";
}
