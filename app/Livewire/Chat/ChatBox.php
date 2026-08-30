<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use App\Models\User;
use Livewire\Component;

class ChatBox extends Component
{
    public $activeUserId;
    public $activeUser;
    public $body = '';

    public function mount($activeUserId = null)
    {
        $this->activeUserId = $activeUserId;
        if ($this->activeUserId) {
            $this->activeUser = User::find($this->activeUserId);
            $this->markMessagesAsRead();
        }
    }

    public function markMessagesAsRead()
    {
        if ($this->activeUserId) {
            Message::where('sender_id', $this->activeUserId)
                ->where('receiver_id', auth()->id())
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }
    }

    public function sendMessage()
    {
        if (!trim($this->body) || !$this->activeUserId) return;

        Message::create([
            'sender_id'   => auth()->id(),
            'receiver_id' => $this->activeUserId,
            'body'        => $this->body,
        ]);

        $this->body = '';
        $this->dispatch('messageSent');
    }

    public function render()
    {
        // Always reload the other user so last_seen_at / isOnline() is live
        if ($this->activeUserId) {
            $this->activeUser = User::find($this->activeUserId);
        }

        // Keep the current user's own last_seen_at fresh on every poll tick
        if (auth()->check()) {
            auth()->user()->update(['last_seen_at' => now()]);
        }

        $messages = [];
        if ($this->activeUserId) {
            $messages = Message::where(function ($query) {
                $query->where('sender_id', auth()->id())
                      ->where('receiver_id', $this->activeUserId);
            })->orWhere(function ($query) {
                $query->where('sender_id', $this->activeUserId)
                      ->where('receiver_id', auth()->id());
            })->orderBy('created_at', 'asc')->get();

            $this->markMessagesAsRead();
        }

        return view('livewire.chat.chat-box', [
            'messages' => $messages,
        ]);
    }
}
