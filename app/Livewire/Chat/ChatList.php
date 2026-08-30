<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use App\Models\User;
use Livewire\Component;

class ChatList extends Component
{
    public $activeUserId;

    public function mount($activeUserId = null)
    {
        $this->activeUserId = $activeUserId;
    }

    public function render()
    {
        $userId = auth()->id();

        // Get unique user IDs from messages
        $userIds = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->flatMap(function ($message) use ($userId) {
                return [$message->sender_id === $userId ? $message->receiver_id : $message->sender_id];
            })->unique()->values();

        if ($this->activeUserId && !$userIds->contains($this->activeUserId)) {
            $userIds->prepend((int)$this->activeUserId);
        }

        $conversations = User::whereIn('id', $userIds)
            ->with('photos')
            ->get()
            ->sortBy(function($user) use ($userIds) {
                return array_search($user->id, $userIds->toArray());
            });

        return view('livewire.chat.chat-list', [
            'conversations' => $conversations
        ]);
    }
}
