<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use App\Models\User;
use App\Models\ChatArchive;
use Livewire\Component;

class ChatList extends Component
{
    public $activeUserId;
    public $showArchived = false;

    public function mount($activeUserId = null)
    {
        $this->activeUserId = $activeUserId;
    }

    public function archiveChat($userId)
    {
        ChatArchive::firstOrCreate([
            'user_id' => auth()->id(),
            'archived_user_id' => $userId,
        ]);
        
        // If the currently active chat is archived, we can redirect to the chat index
        if ($this->activeUserId == $userId) {
            return redirect()->route('chat.index');
        }
    }

    public function unarchiveChat($userId)
    {
        ChatArchive::where('user_id', auth()->id())
            ->where('archived_user_id', $userId)
            ->delete();
    }

    public function deleteChat($userId)
    {
        $myId = auth()->id();

        // Mark messages I sent to them as deleted by me
        Message::where('sender_id', $myId)
            ->where('receiver_id', $userId)
            ->update(['deleted_by_sender' => true]);

        // Mark messages they sent to me as deleted by me
        Message::where('sender_id', $userId)
            ->where('receiver_id', $myId)
            ->update(['deleted_by_receiver' => true]);

        // Unarchive just in case
        $this->unarchiveChat($userId);

        if ($this->activeUserId == $userId) {
            return redirect()->route('chat.index');
        }
    }

    public function unarchiveSelected($userIds)
    {
        foreach ($userIds as $id) {
            $this->unarchiveChat($id);
        }
    }

    public function archiveSelected($userIds)
    {
        $redirect = false;
        foreach ($userIds as $id) {
            ChatArchive::firstOrCreate([
                'user_id' => auth()->id(),
                'archived_user_id' => $id,
            ]);
            if ($this->activeUserId == $id) $redirect = true;
        }
        if ($redirect) return redirect()->route('chat.index');
    }

    public function deleteSelected($userIds)
    {
        $redirect = false;
        foreach ($userIds as $id) {
            $myId = auth()->id();
            Message::where('sender_id', $myId)->where('receiver_id', $id)->update(['deleted_by_sender' => true]);
            Message::where('sender_id', $id)->where('receiver_id', $myId)->update(['deleted_by_receiver' => true]);
            $this->unarchiveChat($id);
            if ($this->activeUserId == $id) $redirect = true;
        }
        if ($redirect) return redirect()->route('chat.index');
    }

    public function toggleArchived()
    {
        $this->showArchived = !$this->showArchived;
    }

    public function render()
    {
        $userId = auth()->id();

        // Get unique user IDs from messages that haven't been deleted by me
        $userIds = Message::where(function ($q) use ($userId) {
                $q->where('sender_id', $userId)
                  ->where('deleted_by_sender', false);
            })
            ->orWhere(function ($q) use ($userId) {
                $q->where('receiver_id', $userId)
                  ->where('deleted_by_receiver', false);
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->flatMap(function ($message) use ($userId) {
                return [$message->sender_id === $userId ? $message->receiver_id : $message->sender_id];
            })->unique()->values();

        if ($this->activeUserId && !$userIds->contains($this->activeUserId)) {
            $userIds->prepend((int)$this->activeUserId);
        }

        $archivedUserIds = ChatArchive::where('user_id', $userId)->pluck('archived_user_id')->toArray();

        // Split into active and archived
        $activeUserIdsList = $userIds->diff($archivedUserIds);
        $archivedUserIdsList = $userIds->intersect($archivedUserIds);

        // Fetch users
        $allConversations = User::whereIn('id', $userIds)
            ->with('photos')
            ->get();

        $conversations = $allConversations->whereIn('id', $activeUserIdsList)->sortBy(function($user) use ($activeUserIdsList) {
            return array_search($user->id, $activeUserIdsList->toArray());
        });

        $archivedConversations = $allConversations->whereIn('id', $archivedUserIdsList)->sortBy(function($user) use ($archivedUserIdsList) {
            return array_search($user->id, $archivedUserIdsList->toArray());
        });

        return view('livewire.chat.chat-list', [
            'conversations' => $conversations,
            'archivedConversations' => $archivedConversations,
        ]);
    }
}
