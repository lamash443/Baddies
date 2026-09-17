<div class="chat-list border-end border-secondary bg-dark position-relative" style="height: 75vh; overflow-y: auto;">
    <div x-data="{ 
        selectedChats: [],
        longPressTimer: null,
        startPress(id) {
            this.longPressTimer = setTimeout(() => {
                if(!this.selectedChats.includes(id)) {
                    this.selectedChats.push(id);
                }
            }, 250); // 250ms fast long press
        },
        endPress() {
            if (this.longPressTimer) {
                clearTimeout(this.longPressTimer);
            }
        },
        handleClick(id, e) {
            if (this.selectedChats.length > 0) {
                e.preventDefault();
                let idx = this.selectedChats.indexOf(id);
                if (idx > -1) {
                    this.selectedChats.splice(idx, 1);
                } else {
                    this.selectedChats.push(id);
                }
            }
        },
        archiveSelected() {
            if (this.selectedChats.length === 0) return;
            $wire.archiveSelected(this.selectedChats).then(() => {
                this.selectedChats = [];
            });
        },
        unarchiveSelected() {
            if (this.selectedChats.length === 0) return;
            $wire.unarchiveSelected(this.selectedChats).then(() => {
                this.selectedChats = [];
            });
        },
        deleteSelected() {
            if (this.selectedChats.length === 0) return;
            if(confirm('Are you sure you want to delete selected chats?')) {
                $wire.deleteSelected(this.selectedChats).then(() => {
                    this.selectedChats = [];
                });
            }
        }
    }">

    {{-- Action Bar Overlay (Appears when chats are selected) --}}
    <div x-transition.opacity 
         :class="selectedChats.length > 0 ? 'd-flex' : 'd-none'"
         class="position-absolute top-0 start-0 w-100 p-3 bg-dark align-items-center justify-content-between" 
         style="display: none; z-index: 50; border-bottom: 1px solid rgba(255,255,255,0.1); height: 60px;">
         
         <div class="d-flex align-items-center gap-3">
             <button @click="selectedChats = []" class="btn text-white p-0 d-flex align-items-center justify-content-center">
                 <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
             </button>
             <span class="text-white fw-bold fs-5" x-text="selectedChats.length"></span>
         </div>
         <div class="d-flex align-items-center gap-4">
             @if(!$showArchived)
             <button @click="archiveSelected" class="btn text-white p-0" title="Archive">
                 <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg>
             </button>
             @else
             <button @click="unarchiveSelected" class="btn text-white p-0" title="Unarchive">
                 <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 10 4 15 9 20"></polyline><path d="M20 4v7a4 4 0 0 1-4 4H4"></path></svg>
             </button>
             @endif
             <button @click="deleteSelected" class="btn text-danger p-0" title="Delete">
                 <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
             </button>
         </div>
    </div>

    {{-- Header --}}
    <div class="p-3 border-bottom border-secondary d-flex align-items-center gap-2">
        <div class="d-flex align-items-center gap-2 flex-grow-1">
            <a href="{{ route('dashboard') }}" class="text-decoration-none d-flex align-items-center" title="Back to Dashboard">
                @if(!empty($siteSettings['logo']))
                    <img src="{{ asset('storage/' . $siteSettings['logo']) }}" alt="Logo" style="max-height:48px;width:auto;object-fit:contain;margin-left:0.2rem;">
                @else
                    <h4 class="mb-0 fw-bold" style="color: #ff8c00; letter-spacing: 0.5px; margin-left: 0.2rem;">Baddies Club</h4>
                @endif
            </a>
            @php
                $totalUnread = auth()->user()->messagesReceived()->where('is_read', false)->where('deleted_by_receiver', false)->count();
            @endphp
            @if($totalUnread > 0)
                <span style="background: #ff8c00; color: #000; font-size: 0.6rem; font-weight: 800; padding: 2px 8px; border-radius: 50px; letter-spacing: 0.03em; margin-left: auto;">
                    {{ $totalUnread }} New
                </span>
            @endif
        </div>
    </div>

    {{-- Global Announcement --}}
    @if(!auth()->user()->is_admin)
        @php
            $adminUser = \App\Models\User::where('is_admin', true)->first();
            $announcementActive = \App\Models\SiteSetting::get('chat_announcement_active');
            $announcementLogoPath = \App\Models\SiteSetting::get('chat_announcement_logo') ?: \App\Models\SiteSetting::get('logo');
            $announcementLogo = $announcementLogoPath ? asset('storage/'.$announcementLogoPath) : null;
            
            $latestAnnouncement = null;
            $unreadCount = 0;
            if ($adminUser) {
                $latestAnnouncement = \App\Models\Message::where('sender_id', $adminUser->id)
                                        ->where('receiver_id', auth()->id())
                                        ->where('deleted_by_receiver', false)
                                        ->latest()->first();
                $unreadCount = \App\Models\Message::where('sender_id', $adminUser->id)
                                        ->where('receiver_id', auth()->id())
                                        ->where('deleted_by_receiver', false)
                                        ->where('is_read', false)
                                        ->count();
            }
        @endphp
        @if($announcementActive && $latestAnnouncement)
            <a href="{{ route('chat.show', 'announcement') }}" class="chat-row text-decoration-none d-block w-100 position-relative" style="border-bottom: 1px solid rgba(255,140,0,0.15); padding: 0.55rem 0.75rem; transition: all 0.2s ease;">
                <div class="d-flex align-items-start gap-3">
                    {{-- Avatar --}}
                    <div class="position-relative flex-shrink-0">
                        @if($announcementLogo)
                            <div class="d-flex align-items-center justify-content-center bg-dark" style="width:52px; height:52px; border-radius:50%; border: 2px solid #ff8c00; padding:2px; box-shadow: 0 0 10px rgba(255,140,0,0.4);">
                                <img src="{{ $announcementLogo }}" alt="Kenyan Baddies" class="rounded-circle w-100 h-100" style="object-fit: contain;">
                            </div>
                        @else
                            <div class="d-flex align-items-center justify-content-center" style="width:52px; height:52px; border-radius:50%; border: 2px solid #ff8c00; box-shadow: 0 0 10px rgba(255,140,0,0.4); background: linear-gradient(135deg, rgba(255,140,0,0.3), rgba(255,140,0,0.1));">
                                <span class="fw-bold text-white">KB</span>
                            </div>
                        @endif
                        {{-- Pinned Badge Overlay --}}
                        <div class="position-absolute align-items-center justify-content-center bg-primary rounded-circle d-flex" 
                             style="width: 20px; height: 20px; bottom: -2px; right: -2px; border: 2px solid #1a1a1a;">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path></svg>
                        </div>
                    </div>

                    {{-- Name + Message --}}
                    <div class="flex-grow-1" style="min-width: 0;">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="d-flex align-items-center gap-1" style="font-size: 0.95rem; font-weight: 800; color: #ff8c00;">
                                Kenyan Baddies
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="#0d6efd" stroke="#0d6efd" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ms-1"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01" stroke="#fff"></polyline></svg>
                            </span>
                            <span class="d-flex align-items-center gap-2">
                                <span style="font-size: 0.65rem; color: #ff8c00; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; background: rgba(255,140,0,0.15); padding: 2px 6px; border-radius: 4px;">Announcement</span>
                            </span>
                        </div>
                        <div style="font-size: 0.85rem; color: rgba(255,255,255,0.85); line-height: 1.5;" class="d-flex justify-content-between align-items-center">
                            <div class="text-truncate" style="max-width: 80%;">
                                {!! nl2br(e($latestAnnouncement->body)) !!}
                            </div>
                            @if($unreadCount > 0)
                                <span class="badge rounded-pill ms-2" style="background: #ff8c00; color: #000; font-size: 0.65rem; font-weight: 800;">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </a>
        @endif
    @endif

    {{-- Conversation Rows --}}
    <div class="list-group list-group-flush mt-2" wire:poll.10s>
        @if(!$showArchived && count($archivedConversations) > 0)
            <div class="position-relative chat-row-wrapper mb-2 mx-2" style="border-radius: 12px; border: 1px solid rgba(255,255,255,0.06); cursor: pointer;" wire:click="toggleArchived">
                <div class="chat-row text-decoration-none d-block w-100" style="padding: 0.5rem 1rem; transition: all 0.2s ease;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ff8c00" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg>
                            </div>
                            <div class="fw-bold text-white" style="font-size: 0.9rem;">Archived</div>
                        </div>
                        <div class="text-muted fw-bold pe-2" style="font-size: 0.8rem;">
                            {{ count($archivedConversations) }}
                        </div>
                    </div>
                </div>
            </div>
        @elseif($showArchived)
            <div class="position-relative chat-row-wrapper mb-2 mx-2" style="border-radius: 12px; border: 1px solid rgba(255,255,255,0.06); cursor: pointer;" wire:click="toggleArchived">
                <div class="chat-row text-decoration-none d-block w-100" style="padding: 0.5rem 1rem; transition: all 0.2s ease;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#4ade80" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                            </div>
                            <div class="fw-bold text-white" style="font-size: 0.9rem;">Back to Active Chats</div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @php
            $displayConversations = $showArchived ? $archivedConversations : $conversations;
        @endphp

        @forelse($displayConversations as $user)
            @if(!auth()->user()->is_admin && $user->is_admin)
                @continue
            @endif
            @php
                $hasPhoto   = $user->profile_photo || $user->photos->first();
                $cover      = $user->profile_photo ? asset('storage/'.$user->profile_photo) : ($hasPhoto ? asset('storage/'.$user->photos->first()->path) : null);
                $initials   = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $user->name), 0, 2));
                $online     = $user->isOnline();

                $lastMsg = $user->last_message;
                $unread  = $user->unread_count ?? 0;
                if ($lastMsg) {
                    if ($lastMsg->is_deleted) {
                        $snippet = 'This message was deleted';
                    } elseif ($lastMsg->image_path) {
                        $snippet = '📷 Photo' . ($lastMsg->body ? ' - ' . \Illuminate\Support\Str::limit($lastMsg->body, 25) : '');
                    } else {
                        $snippet = \Illuminate\Support\Str::limit($lastMsg->body, 35);
                    }
                } else {
                    $snippet = 'No messages yet';
                }
                $timeAgo = '';
                if ($lastMsg) {
                    $msgDate = $lastMsg->created_at;
                    if ($msgDate->isToday()) {
                        $timeAgo = 'Today';
                    } elseif ($msgDate->isYesterday()) {
                        $timeAgo = 'Yesterday';
                    } else {
                        $timeAgo = $msgDate->format('d/m/Y');
                    }
                }
                $isActive = $activeUserId == $user->id;
            @endphp

            <div class="position-relative chat-row-wrapper mb-1" 
                 :class="{ 'bg-secondary bg-opacity-25': selectedChats.includes({{ $user->id }}) }"
                 style="background: {{ $isActive ? 'rgba(255,140,0,0.08)' : 'transparent' }}; border-left: 3px solid {{ $isActive ? '#ff8c00' : 'transparent' }}; transition: background 0.2s;">
                
                <a href="{{ route('chat.show', $user->id) }}" class="chat-row text-decoration-none d-block w-100" 
                   style="padding: 0.55rem 0.75rem; transition: all 0.2s ease; -webkit-touch-callout: none; user-select: none; -webkit-user-select: none; -webkit-user-drag: none;"
                   @contextmenu.prevent
                   @touchstart="startPress({{ $user->id }})"
                   @touchend="endPress()"
                   @touchmove="endPress()"
                   @mousedown="startPress({{ $user->id }})"
                   @mouseup="endPress()"
                   @mouseleave="endPress()"
                   @click="handleClick({{ $user->id }}, $event)">
                    <div class="d-flex align-items-start gap-3">

                        {{-- Avatar --}}
                        <div class="position-relative flex-shrink-0">
                            @if($hasPhoto)
                                <div class="flex-shrink-0 d-flex align-items-center justify-content-center" style="width:52px; height:52px; border-radius:50%; border: 2px solid {{ $online ? '#ff8c00' : 'rgba(255,255,255,0.15)' }}; padding:2px; box-shadow: {{ $online ? '0 0 8px rgba(255,140,0,0.5)' : 'none' }};">
                                    <img src="{{ $cover }}" alt="{{ $user->name }}" class="rounded-circle w-100 h-100" style="object-fit: cover;">
                                </div>
                            @else
                                <div class="flex-shrink-0 d-flex align-items-center justify-content-center" style="width:52px; height:52px; border-radius:50%; border: 2px solid {{ $online ? '#ff8c00' : 'rgba(255,140,0,0.3)' }}; padding:2px; box-shadow: {{ $online ? '0 0 8px rgba(255,140,0,0.5)' : 'none' }};">
                                    <div class="rounded-circle w-100 h-100 d-flex justify-content-center align-items-center text-white fw-bold" style="font-size: 1.1rem; background: linear-gradient(135deg, rgba(255,140,0,0.25), rgba(255,140,0,0.1));">
                                        {{ $initials ?: 'U' }}
                                    </div>
                                </div>
                            @endif

                            {{-- Selection Checkmark Overlay on Avatar --}}
                            <div :class="selectedChats.includes({{ $user->id }}) ? 'd-flex' : 'd-none'" 
                                 class="position-absolute align-items-center justify-content-center bg-success rounded-circle" 
                                 style="display: none; width: 22px; height: 22px; bottom: -2px; right: -2px; z-index: 5; border: 2px solid #1a1a1a;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                        </div>

                        {{-- Name + Last Message --}}
                        <div class="flex-grow-1" style="min-width: 0;">
                            {{-- Top row: Name + Time --}}
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span style="font-size: 0.92rem; font-weight: 700; color: {{ $unread > 0 ? '#fff' : 'rgba(255,255,255,0.85)' }}; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $user->name }}
                                </span>
                                <span style="font-size: 0.62rem; color: {{ $unread > 0 ? '#ff8c00' : 'rgba(255,255,255,0.3)' }}; white-space: nowrap; margin-left: 0.5rem; font-weight: 600;">
                                    {{ $timeAgo }}
                                </span>
                            </div>

                            {{-- Bottom row: Snippet + Status/Badge --}}
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="font-size: 0.78rem; color: {{ $unread > 0 ? 'rgba(255,255,255,0.7)' : 'rgba(255,255,255,0.4)' }}; font-weight: {{ $unread > 0 ? '600' : '400' }}; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; flex: 1; margin-right: 0.5rem;">
                                    @if($lastMsg && $lastMsg->sender_id === auth()->id())
                                        <span style="color: rgba(255,255,255,0.3);">You: </span>
                                    @endif
                                    {{ $snippet }}
                                </span>
                                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                    @if($online)
                                        <span style="font-size: 0.62rem; font-weight: 700; color: #ff8c00; letter-spacing: 0.03em;">Online</span>
                                    @endif
                                    @if($unread > 0)
                                        <span style="min-width: 16px; height: 16px; background: #ff8c00; border-radius: 50px; font-size: 0.55rem; font-weight: 800; color: #000; display: flex; align-items: center; justify-content: center; padding: 0 4px;">
                                            {{ $unread }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </a>

            </div>
        @empty
            <div class="d-flex flex-column align-items-center justify-content-center py-5 px-3" style="color: rgba(255,255,255,0.3);">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem; opacity: 0.3;">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                <p class="mb-1 fw-bold" style="font-size: 0.95rem; color: rgba(255,255,255,0.5);">{{ $showArchived ? 'No archived chats' : 'No conversations yet' }}</p>
                <p class="mb-0" style="font-size: 0.78rem;">{{ $showArchived ? '' : 'Start a chat from a member\'s profile!' }}</p>
            </div>
        @endforelse
    </div>

    <style>
        .chat-row:hover {
            background: rgba(255,140,0,0.06) !important;
            border-left-color: rgba(255,140,0,0.4) !important;
        }
    </style>
    </div>
</div>
