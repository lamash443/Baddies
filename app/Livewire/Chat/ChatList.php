<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use App\Models\User;
use App\Models\ChatArchive;
use App\Models\ChatPin;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Poll;

#[Poll(10000)]
class ChatList extends Component
{
    public $activeUserId;
    public bool $showArchived = false;

    protected $listeners = [
        'chat-pin-updated' => '$refresh',
        'chat-archive-updated' => '$refresh',
        'messageSent' => '$refresh',
    ];

    #[On('chat-pin-updated')]
    public function onChatPinUpdated()
    {
        // Refresh component
    }

    #[On('chat-archive-updated')]
    public function onChatArchiveUpdated()
    {
        // Refresh component
    }

    #[On('messageSent')]
    public function onMessageSent()
    {
        // Refresh component
    }

    #[On('chat-list-action')]
    public function handleChatListAction(string $action = '', string $ids = ''): void
    {
        match ($action) {
            'pin'       => $this->togglePinSelected($ids),
            'unpin'     => $this->unpinChat($ids),
            'archive'   => $this->archiveSelected($ids),
            'unarchive' => $this->unarchiveSelected($ids),
            'delete'    => $this->deleteSelected($ids),
            default     => null,
        };
    }

    public function mount($activeUserId = null)
    {
        $this->activeUserId = $activeUserId;
        // Read showArchived from query string on page load
        $this->showArchived = request()->boolean('showArchived', false);
        if ($this->activeUserId && auth()->check()) {
            $isArchived = ChatArchive::where('user_id', auth()->id())
                ->where('archived_user_id', $this->activeUserId)
                ->exists();
            if ($isArchived) {
                $this->showArchived = true;
            }
        }
    }

    private function parseUserIds($userIds): array
    {
        if (is_null($userIds)) return [];
        if (is_string($userIds)) {
            $userIds = explode(',', $userIds);
        }
        if (!is_array($userIds)) {
            $userIds = [$userIds];
        }
        $flattened = \Illuminate\Support\Arr::flatten($userIds);
        $result = [];
        foreach ($flattened as $val) {
            $val = trim($val);
            if (is_numeric($val) && (int)$val > 0) {
                $result[] = (int)$val;
            }
        }
        return array_values(array_unique($result));
    }

    public function archiveChat($userId)
    {
        $ids = $this->parseUserIds($userId);
        foreach ($ids as $id) {
            ChatArchive::firstOrCreate([
                'user_id' => auth()->id(),
                'archived_user_id' => $id,
            ]);
            if ($this->activeUserId == $id) {
                return redirect()->route('chat.index');
            }
        }
        $this->dispatch('chat-archive-updated');
    }

    public function unarchiveChat($userId)
    {
        $ids = $this->parseUserIds($userId);
        if (!empty($ids)) {
            ChatArchive::where('user_id', auth()->id())
                ->whereIn('archived_user_id', $ids)
                ->delete();
        }
        $this->showArchived = false;
        $this->dispatch('chat-archive-updated');
    }

    public function deleteChat($userId)
    {
        $myId = auth()->id();
        $ids = $this->parseUserIds($userId);

        foreach ($ids as $id) {
            Message::where('sender_id', $myId)
                ->where('receiver_id', $id)
                ->update(['deleted_by_sender' => true]);

            Message::where('sender_id', $id)
                ->where('receiver_id', $myId)
                ->update(['deleted_by_receiver' => true]);

            $this->unarchiveChat($id);
            $this->unpinChat($id);

            if ($this->activeUserId == $id) {
                return redirect()->route('chat.index');
            }
        }
        $this->dispatch('chat-archive-updated');
        $this->dispatch('chat-pin-updated');
    }

    public function unpinChat($userId)
    {
        $ids = $this->parseUserIds($userId);
        if (!empty($ids)) {
            ChatPin::where('user_id', auth()->id())
                ->whereIn('pinned_user_id', $ids)
                ->delete();
        }
        $this->dispatch('chat-pin-updated');
    }

    public function togglePinSelected($userIds)
    {
        $myId = auth()->id();
        \Log::info('togglePinSelected called', ['received' => $userIds, 'auth_user_id' => $myId]);
        $userIds = $this->parseUserIds($userIds);
        \Log::info('parsed userIds', ['parsed' => $userIds, 'myId' => $myId]);
        if (empty($userIds) || !$myId) return;
        
        $existingPinned = ChatPin::where('user_id', $myId)
            ->whereIn('pinned_user_id', $userIds)
            ->pluck('pinned_user_id')
            ->toArray();

        foreach ($userIds as $id) {
            if (in_array($id, $existingPinned)) {
                \Log::info('UNPINNING', ['myId' => $myId, 'target' => $id]);
                ChatPin::where('user_id', $myId)->where('pinned_user_id', $id)->delete();
            } else {
                \Log::info('PINNING', ['myId' => $myId, 'target' => $id]);
                ChatPin::create(['user_id' => $myId, 'pinned_user_id' => $id]);
            }
        }
        \Log::info('After pin, total pins in DB: ' . ChatPin::count());
        $this->dispatch('chat-pin-updated');
    }

    public function unarchiveSelected($userIds)
    {
        $userIds = $this->parseUserIds($userIds);
        foreach ($userIds as $id) {
            ChatArchive::where('user_id', auth()->id())
                ->where('archived_user_id', $id)
                ->delete();
        }
        $this->dispatch('chat-archive-updated');
    }

    public function archiveSelected($userIds)
    {
        $userIds = $this->parseUserIds($userIds);
        $redirect = false;
        foreach ($userIds as $id) {
            ChatArchive::firstOrCreate([
                'user_id' => auth()->id(),
                'archived_user_id' => $id,
            ]);
            if ($this->activeUserId == $id) $redirect = true;
        }
        $this->dispatch('chat-archive-updated');
        if ($redirect) return redirect()->route('chat.index');
    }

    public function deleteSelected($userIds)
    {
        $userIds = $this->parseUserIds($userIds);
        $redirect = false;
        foreach ($userIds as $id) {
            $myId = auth()->id();
            Message::where('sender_id', $myId)->where('receiver_id', $id)->update(['deleted_by_sender' => true]);
            Message::where('sender_id', $id)->where('receiver_id', $myId)->update(['deleted_by_receiver' => true]);
            ChatArchive::where('user_id', $myId)->where('archived_user_id', $id)->delete();
            ChatPin::where('user_id', $myId)->where('pinned_user_id', $id)->delete();
            if ($this->activeUserId == $id) $redirect = true;
        }
        $this->dispatch('chat-archive-updated');
        $this->dispatch('chat-pin-updated');
        if ($redirect) return redirect()->route('chat.index');
    }

    public function toggleArchived()
    {
        $this->showArchived = !$this->showArchived;
    }

    public function render()
    {
        $userId = auth()->id();

        if (!$userId) {
            return view('livewire.chat.chat-list', [
                'conversations' => collect(),
                'archivedConversations' => collect(),
                'pinnedUserIds' => [],
            ]);
        }

        $userIds = \DB::table('messages')
            ->select(\DB::raw('CASE WHEN sender_id = ' . (int)$userId . ' THEN receiver_id ELSE sender_id END as partner_id'), \DB::raw('MAX(created_at) as max_created_at'))
            ->where(function ($q) use ($userId) {
                $q->where('sender_id', $userId)->where('deleted_by_sender', false);
            })
            ->orWhere(function ($q) use ($userId) {
                $q->where('receiver_id', $userId)->where('deleted_by_receiver', false);
            })
            ->groupBy('partner_id')
            ->orderByDesc('max_created_at')
            ->pluck('partner_id')
            ->map(fn($id) => (int)$id);

        if ($this->activeUserId && !$userIds->contains((int)$this->activeUserId)) {
            $userIds->prepend((int)$this->activeUserId);
        }

        $archivedUserIds = ChatArchive::where('user_id', $userId)->pluck('archived_user_id')->map(fn($id) => (int)$id)->toArray();
        $pinnedUserIds   = ChatPin::where('user_id', $userId)->pluck('pinned_user_id')->map(fn($id) => (int)$id)->toArray();

        $allPartnerIds = collect(array_merge($userIds->toArray(), $archivedUserIds, $pinnedUserIds))->unique()->values()->toArray();

        $activeUserIdsList = array_values(array_diff($allPartnerIds, $archivedUserIds));
        $archivedUserIdsList = array_values($archivedUserIds);

        $allConversations = User::whereIn('id', $allPartnerIds)
            ->with('photos')
            ->get();

        foreach ($allConversations as $user) {
            $user->last_message = Message::where(function($q) use ($user, $userId) {
                $q->where('sender_id', $userId)->where('receiver_id', $user->id)->where('deleted_by_sender', false);
            })->orWhere(function($q) use ($user, $userId) {
                $q->where('sender_id', $user->id)->where('receiver_id', $userId)->where('deleted_by_receiver', false);
            })->latest()->first();

            $user->unread_count = Message::where('sender_id', $user->id)
                ->where('receiver_id', $userId)
                ->where('is_read', false)
                ->where('deleted_by_receiver', false)
                ->count();
        }

        $conversations = $allConversations->whereIn('id', $activeUserIdsList)->sortBy(function($user) use ($activeUserIdsList, $pinnedUserIds) {
            $isPinned = in_array($user->id, $pinnedUserIds);
            $origIndex = array_search($user->id, $activeUserIdsList);
            return ($isPinned ? '0_' : '1_') . str_pad($origIndex !== false ? $origIndex : 9999, 6, '0', STR_PAD_LEFT);
        })->values();

        $archivedConversations = $allConversations->whereIn('id', $archivedUserIdsList)->sortBy(function($user) use ($archivedUserIdsList, $pinnedUserIds) {
            $isPinned = in_array($user->id, $pinnedUserIds);
            $origIndex = array_search($user->id, $archivedUserIdsList);
            return ($isPinned ? '0_' : '1_') . str_pad($origIndex !== false ? $origIndex : 9999, 6, '0', STR_PAD_LEFT);
        })->values();

        return view('livewire.chat.chat-list', [
            'conversations' => $conversations,
            'archivedConversations' => $archivedConversations,
            'pinnedUserIds' => $pinnedUserIds,
        ]);
    }
}
