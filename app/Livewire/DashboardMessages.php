<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class DashboardMessages extends Component
{
    public function render()
    {
        $user = Auth::user();
        $unreadMessages = Message::where('receiver_id', $user->id)
            ->where('is_read', false)
            ->with(['sender' => function($q){ $q->with('photos'); }])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('sender_id');

        $totalUnread = $unreadMessages->sum(fn($group) => $group->count());

        return view('livewire.dashboard-messages', [
            'user' => $user,
            'unreadMessages' => $unreadMessages,
            'totalUnread' => $totalUnread,
        ]);
    }
}
