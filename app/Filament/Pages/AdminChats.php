<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Message;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Filament\Notifications\Notification;

class AdminChats extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static string|\UnitEnum|null $navigationGroup = 'Communication';
    protected static ?string $navigationLabel = 'Conversations';
    protected static ?string $title = 'Platform Conversations';
    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.admin-chats';

    public ?int $activeUserA = null;
    public ?int $activeUserB = null;

    // Specific user settings
    public ?int $editingUserId = null;
    public ?User $editingUser = null;

    // Admin reply
    public ?string $newMessage = null;

    // Online settings bound to form
    public bool $force_online               = false;
    public bool $online_toast_enabled       = true;
    public bool $show_online_status_in_chat = true;
    public ?string $online_toast_message    = null;
    public ?string $online_toast_position   = null;
    public ?int $online_toast_duration      = null;
    public ?string $online_toast_sound      = null;
    public ?int $online_threshold_minutes   = null;

    public function openSettingsForUser(int $userId): void
    {
        $this->editingUserId = $userId;
        $this->editingUser = User::find($userId);

        if ($this->editingUser) {
            $this->force_online               = (bool) ($this->editingUser->force_online ?? false);
            $this->online_toast_enabled       = (bool) ($this->editingUser->online_toast_enabled ?? true);
            $this->show_online_status_in_chat = (bool) ($this->editingUser->show_online_status_in_chat ?? true);
            $this->online_toast_message       = $this->editingUser->online_toast_message;
            $this->online_toast_position      = $this->editingUser->online_toast_position;
            $this->online_toast_duration      = $this->editingUser->online_toast_duration;
            $this->online_toast_sound         = $this->editingUser->online_toast_sound;
            $this->online_threshold_minutes   = $this->editingUser->online_threshold_minutes;
        }
    }

    public function closeSettings(): void
    {
        $this->editingUserId = null;
        $this->editingUser = null;
    }

    public function saveOnlineSettings(): void
    {
        if ($this->editingUser) {
            $wasForcedOnline = $this->editingUser->force_online;

            $updates = [
                'force_online'               => $this->force_online,
                'online_toast_enabled'       => $this->online_toast_enabled,
                'show_online_status_in_chat' => $this->show_online_status_in_chat,
                'online_toast_message'       => $this->online_toast_message,
                'online_toast_position'      => $this->online_toast_position,
                'online_toast_duration'      => $this->online_toast_duration,
                'online_toast_sound'         => $this->online_toast_sound,
                'online_threshold_minutes'   => $this->online_threshold_minutes,
            ];

            // If the admin is turning OFF the force online toggle, reset last seen to just outside the threshold so they immediately appear offline
            if ($wasForcedOnline && !$this->force_online) {
                $threshold = $this->online_threshold_minutes ?: (\App\Models\Setting::getSettings()->online_threshold_minutes ?? 5);
                $updates['last_seen_at'] = now()->subMinutes($threshold + 1);
            }

            $this->editingUser->update($updates);

            Notification::make()
                ->title('Online settings saved for ' . $this->editingUser->name)
                ->success()
                ->send();
            
            $this->closeSettings();
        }
    }

    public function openConversation(int $userAId, int $userBId): void
    {
        $this->activeUserA = $userAId;
        $this->activeUserB = $userBId;
    }

    public function closeConversation(): void
    {
        $this->activeUserA = null;
        $this->activeUserB = null;
    }

    public function getConversations(): array
    {
        $rows = Message::select(
                DB::raw('LEAST(sender_id, receiver_id) as user_a'),
                DB::raw('GREATEST(sender_id, receiver_id) as user_b'),
                DB::raw('MAX(id) as last_message_id'),
                DB::raw('COUNT(id) as total_messages')
            )
            ->groupBy('user_a', 'user_b')
            ->get();

        $conversations = [];
        foreach ($rows as $row) {
            $lastMsg = Message::find($row->last_message_id);
            $uA = User::find($row->user_a);
            $uB = User::find($row->user_b);
            if ($uA && $uB && $lastMsg) {
                $conversations[] = (object)[
                    'user_a'         => $uA,
                    'user_b'         => $uB,
                    'last_message'   => $lastMsg,
                    'total_messages' => $row->total_messages,
                ];
            }
        }

        usort($conversations, fn($a, $b) =>
            $b->last_message->created_at <=> $a->last_message->created_at
        );

        return $conversations;
    }

    public function getMessages()
    {
        if (!$this->activeUserA || !$this->activeUserB) return collect();
        return Message::with(['sender', 'receiver'])
            ->where(fn($q) => $q->where('sender_id', $this->activeUserA)->where('receiver_id', $this->activeUserB))
            ->orWhere(fn($q) => $q->where('sender_id', $this->activeUserB)->where('receiver_id', $this->activeUserA))
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function sendMessageAs(int $senderId): void
    {
        if (!$this->newMessage || trim($this->newMessage) === '') return;
        if (!$this->activeUserA || !$this->activeUserB) return;

        $receiverId = ($senderId === $this->activeUserA) ? $this->activeUserB : $this->activeUserA;

        // Mark previous messages from the receiver as read (since the sender is replying)
        Message::where('sender_id', $receiverId)
               ->where('receiver_id', $senderId)
               ->where('is_read', false)
               ->update(['is_read' => true]);

        Message::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'body' => trim($this->newMessage),
            'is_read' => false,
        ]);

        $this->newMessage = null;
    }

    public function getViewData(): array
    {
        return [
            'conversations' => $this->getConversations(),
            'messages'      => $this->getMessages(),
            'userA'         => $this->activeUserA ? User::find($this->activeUserA) : null,
            'userB'         => $this->activeUserB ? User::find($this->activeUserB) : null,
        ];
    }
}
