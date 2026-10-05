<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$user = \App\Models\User::first();
auth()->login($user);
$userId = $user->id;

// Create dummy archive record if none exists
$partner = \App\Models\User::where('id', '!=', $userId)->first();
\App\Models\ChatArchive::firstOrCreate(['user_id' => $userId, 'archived_user_id' => $partner->id]);

$archivedUserIds = \App\Models\ChatArchive::where('user_id', $userId)->pluck('archived_user_id')->map(fn($id) => (int)$id)->toArray();
echo "Archived IDs array: " . json_encode($archivedUserIds) . "\n";

$allPartnerIds = $archivedUserIds;

$allConversations = \App\Models\User::whereIn('id', $allPartnerIds)->get();
echo "allConversations count: " . $allConversations->count() . "\n";

$archivedConversations = $allConversations->whereIn('id', $archivedUserIds)->values();
echo "archivedConversations count: " . $archivedConversations->count() . "\n";

foreach ($archivedConversations as $u) {
    echo "Archived User: ID {$u->id}, Name {$u->name}\n";
}
