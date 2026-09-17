<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class ChatBox extends Component
{
    use WithFileUploads;
    public $activeUserId;
    public $body = '';
    public $photo;

    public $replyToId = null;

    public function mount($activeUserId = null)
    {
        $this->activeUserId = $activeUserId;
        if ($this->activeUserId && $this->activeUserId !== 'announcement') {
            $this->markMessagesAsRead();
        } elseif ($this->activeUserId === 'announcement') {
            $admin = \App\Models\User::where('is_admin', true)->first();
            if ($admin) {
                Message::where('sender_id', $admin->id)
                    ->where('receiver_id', auth()->id())
                    ->where('is_read', false)
                    ->update(['is_read' => true]);
            }
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

    public function setReply($messageId)
    {
        $this->replyToId = $messageId;
    }

    public function cancelReply()
    {
        $this->replyToId = null;
    }

    public function deleteMessage($messageId)
    {
        $this->deleteMessagesForEveryone([$messageId]);
    }

    public function deleteMessages(array $messageIds)
    {
        $this->deleteMessagesForEveryone($messageIds);
    }

    public function deleteMessagesForEveryone(array $messageIds)
    {
        if (!$this->activeUserId || empty($messageIds)) return;

        $myId = auth()->id();
        // Only messages sent by current user can be deleted for everyone
        Message::whereIn('id', $messageIds)
            ->where('sender_id', $myId)
            ->update(['is_deleted' => true]);

        if (in_array($this->replyToId, $messageIds)) {
            $this->replyToId = null;
        }
    }

    public function deleteMessagesForMe(array $messageIds)
    {
        if (!$this->activeUserId || empty($messageIds)) return;

        $myId = auth()->id();

        // Messages sent by me -> set deleted_by_sender
        Message::whereIn('id', $messageIds)
            ->where('sender_id', $myId)
            ->update(['deleted_by_sender' => true]);

        // Messages received by me -> set deleted_by_receiver
        Message::whereIn('id', $messageIds)
            ->where('receiver_id', $myId)
            ->update(['deleted_by_receiver' => true]);

        if (in_array($this->replyToId, $messageIds)) {
            $this->replyToId = null;
        }
    }

    public function removePhoto()
    {
        $this->photo = null;
    }

    public function sendMessage()
    {
        if ((!trim($this->body) && !$this->photo) || !$this->activeUserId) return;

        // Validation for photo (optional but recommended)
        if ($this->photo) {
            $this->validate([
                'photo' => 'image|max:8192', // 8MB max
            ]);
        }

        $imagePath = null;
        if ($this->photo) {
            $imagePath = $this->photo->store('chat-images', 'public');
        }

        Message::create([
            'sender_id'   => auth()->id(),
            'receiver_id' => $this->activeUserId,
            'body'        => $this->body,
            'image_path'  => $imagePath,
            'reply_to_id' => $this->replyToId,
        ]);

        // Unarchive chat for both users when a new message is sent
        \App\Models\ChatArchive::where(function($q) {
            $q->where('user_id', auth()->id())->where('archived_user_id', $this->activeUserId);
        })->orWhere(function($q) {
            $q->where('user_id', $this->activeUserId)->where('archived_user_id', auth()->id());
        })->delete();

        $this->body = '';
        $this->photo = null;
        $this->replyToId = null;
        $this->dispatch('messageSent');
    }

    public function render()
    {
        $activeUser = null;
        if ($this->activeUserId && $this->activeUserId !== 'announcement') {
            $activeUser = User::find($this->activeUserId);
        }

        // Keep current user's last_seen_at fresh (throttled to at most once per 30s)
        if (auth()->check()) {
            $user = auth()->user();
            if (!$user->last_seen_at || $user->last_seen_at->diffInSeconds(now()) > 30) {
                \DB::table('users')->where('id', $user->id)->update(['last_seen_at' => now()]);
            }
        }

        $messages = [];
        if ($this->activeUserId && $this->activeUserId !== 'announcement') {
            $myId = auth()->id();
            $messages = Message::with('replyTo')->where(function ($query) use ($myId) {
                $query->where('sender_id', $myId)
                      ->where('receiver_id', $this->activeUserId)
                      ->where('deleted_by_sender', false);
            })->orWhere(function ($query) use ($myId) {
                $query->where('sender_id', $this->activeUserId)
                      ->where('receiver_id', $myId)
                      ->where('deleted_by_receiver', false);
            })->orderBy('created_at', 'asc')->get();

            $this->markMessagesAsRead();
        } elseif ($this->activeUserId === 'announcement') {
            $admin = \App\Models\User::where('is_admin', true)->first();
            if ($admin) {
                $messages = Message::with('replyTo')
                    ->where('sender_id', $admin->id)
                    ->where('receiver_id', auth()->id())
                    ->where('deleted_by_receiver', false)
                    ->orderBy('created_at', 'asc')
                    ->get();
            }
        }

        return view('livewire.chat.chat-box', [
            'messages' => $messages,
            'activeUser' => $activeUser,
        ]);
    }
}
