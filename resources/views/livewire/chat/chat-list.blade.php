<div class="chat-list border-end border-secondary bg-dark" style="height: 75vh; overflow-y: auto;">

    {{-- Header --}}
    <div class="p-3 border-bottom border-secondary d-flex align-items-center gap-2">
        <a href="{{ route('dashboard') }}" class="text-white text-opacity-75 text-decoration-none" title="Back to Dashboard">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        </a>
        <div class="d-flex align-items-center gap-2">
            <h5 class="mb-0 text-white">Conversations</h5>
            @php
                $totalUnread = auth()->user()->messagesReceived()->where('is_read', false)->count();
            @endphp
            @if($totalUnread > 0)
                <span class="badge bg-danger rounded-pill">{{ $totalUnread }} New</span>
            @endif
        </div>
    </div>

    {{-- Conversation Rows --}}
    <div class="list-group list-group-flush" wire:poll.10s>
        @forelse($conversations as $user)
            @php
                $hasPhoto   = $user->profile_photo || $user->photos->first();
                $cover      = $user->profile_photo ? asset('storage/'.$user->profile_photo) : ($hasPhoto ? asset('storage/'.$user->photos->first()->path) : null);
                $initials   = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $user->name), 0, 2));
                $online     = $user->isOnline();

                // Get last message between the two users
                $lastMsg = \App\Models\Message::where(function($q) use ($user) {
                    $q->where('sender_id', auth()->id())->where('receiver_id', $user->id);
                })->orWhere(function($q) use ($user) {
                    $q->where('sender_id', $user->id)->where('receiver_id', auth()->id());
                })->orderBy('created_at', 'desc')->first();

                $unread  = \App\Models\Message::where('sender_id', $user->id)->where('receiver_id', auth()->id())->where('is_read', false)->count();
                $snippet = $lastMsg ? \Illuminate\Support\Str::limit($lastMsg->body, 40) : 'No messages yet';
                $timeAgo = $lastMsg ? $lastMsg->created_at->diffForHumans(null, true, true) : '';
                $isActive = $activeUserId == $user->id;
            @endphp

            <a href="{{ route('chat.show', $user->id) }}"
               class="chat-row text-decoration-none d-block"
               style="
                   padding: 0.9rem 1rem;
                   border-bottom: 1px solid rgba(255,255,255,0.06);
                   background: {{ $isActive ? 'rgba(255,140,0,0.08)' : 'transparent' }};
                   border-left: 3px solid {{ $isActive ? '#ff8c00' : 'transparent' }};
                   transition: all 0.2s ease;
               ">
                <div class="d-flex align-items-center gap-3">

                    {{-- Avatar --}}
                    <div class="position-relative flex-shrink-0">
                        @if($hasPhoto)
                            <img src="{{ $cover }}" alt="{{ $user->name }}"
                                 class="rounded-circle"
                                 style="width: 48px; height: 48px; object-fit: cover; border: 2px solid {{ $online ? '#4ade80' : 'rgba(255,255,255,0.1)' }};">
                        @else
                            <div class="rounded-circle d-flex justify-content-center align-items-center fw-bold"
                                 style="width: 48px; height: 48px; font-size: 1rem; color: #fff;
                                        background: linear-gradient(135deg, rgba(255,140,0,0.25), rgba(255,140,0,0.1));
                                        border: 2px solid {{ $online ? '#4ade80' : 'rgba(255,140,0,0.3)' }};">
                                {{ $initials ?: 'U' }}
                            </div>
                        @endif
                    </div>

                    {{-- Name + Last Message --}}
                    <div class="flex-grow-1" style="min-width: 0;">
                        {{-- Top row: Name + Time --}}
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span style="font-size: 0.92rem; font-weight: 700; color: {{ $unread > 0 ? '#fff' : 'rgba(255,255,255,0.85)' }}; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $user->name }}
                            </span>
                            <span style="font-size: 0.65rem; color: {{ $unread > 0 ? '#ff8c00' : 'rgba(255,255,255,0.3)' }}; white-space: nowrap; margin-left: 0.5rem; font-weight: 500;">
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
                                    <span style="font-size: 0.65rem; font-weight: 700; color: #4ade80; letter-spacing: 0.03em;">Online</span>
                                @else
                                    <span style="font-size: 0.65rem; font-weight: 600; color: rgba(255,255,255,0.25); letter-spacing: 0.03em;">Offline</span>
                                @endif
                                @if($unread > 0)
                                    <span style="min-width: 20px; height: 20px; background: #ff8c00; border-radius: 50px; font-size: 0.65rem; font-weight: 800; color: #000; display: flex; align-items: center; justify-content: center; padding: 0 5px;">
                                        {{ $unread }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div class="d-flex flex-column align-items-center justify-content-center py-5 px-3" style="color: rgba(255,255,255,0.3);">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem; opacity: 0.3;">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                <p class="mb-1 fw-bold" style="font-size: 0.95rem; color: rgba(255,255,255,0.5);">No conversations yet</p>
                <p class="mb-0" style="font-size: 0.78rem;">Start a chat from a member's profile!</p>
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
