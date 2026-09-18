<div wire:poll.3s>
    <div class="d-flex align-items-center justify-content-between mb-4 position-relative">
        <div class="d-flex align-items-center gap-2 gap-md-3">
            <div style="width:38px; height:38px; background:rgba(255,140,0,0.1); border:1px solid rgba(255,140,0,0.25); border-radius:10px; display:flex; align-items:center; justify-content:center; color:orange; position:relative; flex-shrink:0;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                @if($totalUnread > 0)
                    <span class="msg-pulse"></span>
                @endif
            </div>
            <div>
                <h3 class="dash-card-title mb-0" style="text-align:left; font-size:1.15rem;">Messages</h3>
                <p class="mb-0 text-muted" style="font-size:0.78rem; margin-top:2px;">
                    @if($totalUnread > 0)
                        <span style="color:#ff8c00; font-weight:700;">{{ $totalUnread }} unread</span> message{{ $totalUnread > 1 ? 's' : '' }}
                    @else
                        No new messages
                    @endif
                </p>
            </div>
        </div>
        @if($user->hasActiveChatSubscription())
            <a href="{{ route('chat.index') }}" class="btn-ghost" style="width:auto; padding:0.5rem 1.1rem; font-size:0.82rem;">
                Open Inbox
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        @endif
    </div>

    @if(!$user->hasActiveChatSubscription())
        <div class="text-center py-4 dash-empty-state" style="border:1px dashed var(--bs-border-color); border-radius:12px;">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-muted" style="margin-bottom:0.75rem;"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            <p class="mb-3 text-muted" style="font-size:0.88rem;">Activate a chat plan to send &amp; receive private messages.</p>
            <a href="{{ route('chat.memberships') }}" class="btn-orange" style="width:auto; display:inline-flex; padding:0.55rem 1.4rem; font-size:0.85rem;">Get Chat Plan</a>
        </div>
    @elseif($unreadMessages->isEmpty())
        <div class="text-center py-4 dash-empty-state" style="border:1px dashed var(--bs-border-color); border-radius:12px;">
            <svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" class="text-muted" style="margin-bottom:0.75rem;"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            <p class="mb-0 text-muted" style="font-size:0.88rem;">Your inbox is empty. Start a conversation from a member profile!</p>
        </div>
    @else
        <div class="d-flex flex-column" style="gap:0.6rem;">
            @foreach($unreadMessages as $senderId => $msgs)
                @php
                    $sender  = $msgs->first()->sender;
                    $count   = $msgs->count();
                    $latest  = $msgs->first();

                    // If sender is admin, show as "Kenyan Baddies" with the site logo
                    $isAdmin = $sender->is_admin ?? false;
                    if ($isAdmin) {
                        $displayName = 'Kenyan Baddies';
                        $logoPath = \App\Models\SiteSetting::get('chat_announcement_logo')
                                 ?: \App\Models\SiteSetting::get('logo');
                        $cover = $logoPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($logoPath)
                                 ? asset('storage/' . $logoPath)
                                 : 'https://ui-avatars.com/api/?name=KB&background=ff8c00&color=000&size=200&bold=true';
                    } else {
                        $displayName = $sender->name;
                        $cover = $sender->profile_photo
                                    ? asset('storage/'.$sender->profile_photo)
                                    : ($sender->photos->first() ? asset('storage/'.$sender->photos->first()->path) : asset('callboy-1.png'));
                    }

                    $snippet = \Illuminate\Support\Str::limit($latest->body, 55);
                    $timeAgo = $latest->created_at->diffForHumans(null, true);
                @endphp
                <a href="{{ route('chat.show', $senderId) }}"
                   class="msg-row d-flex align-items-center gap-3 text-decoration-none bg-body-tertiary"
                   style="border:1px solid rgba(255,140,0,0.15); border-radius:12px; padding:0.85rem 1rem; transition:all 0.2s ease;">
                    <div class="position-relative flex-shrink-0">
                        <img src="{{ $cover }}" alt="{{ $displayName }}"
                             style="width:46px; height:46px; border-radius:50%; object-fit:{{ $isAdmin ? 'contain' : 'cover' }}; border:2px solid rgba(255,140,0,0.3); background:#111;">
                        <span style="position:absolute; bottom:1px; right:1px; width:11px; height:11px; background:#4ade80; border-radius:50%; border:2px solid #111;"></span>
                    </div>
                    <div class="flex-grow-1" style="min-width:0;">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="text-body" style="font-size:0.9rem; font-weight:700;">{{ $displayName }}</span>
                            <span class="text-muted" style="font-size:0.7rem; white-space:nowrap; margin-left:0.5rem;">{{ $timeAgo }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between gap-2">
                            <span class="text-muted" style="font-size:0.8rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $snippet }}</span>
                            <span style="flex-shrink:0; min-width:20px; height:20px; background:#ff8c00; border-radius:50px; font-size:0.68rem; font-weight:800; color:#000; display:flex; align-items:center; justify-content:center; padding:0 5px;">{{ $count }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
