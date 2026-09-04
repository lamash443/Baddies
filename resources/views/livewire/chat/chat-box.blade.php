<div class="chat-box d-flex flex-column bg-dark" style="height: 75vh;">
    @if($activeUser)
        <!-- Header -->
        <div class="d-flex align-items-center px-3 py-2" style="background: linear-gradient(135deg, rgba(255,140,0,0.15) 0%, rgba(255,140,0,0.05) 100%); border-bottom: 1px solid rgba(255,140,0,0.25); min-height: 62px;">
            {{-- Back button (mobile) --}}
            <a href="{{ route('chat.index') }}" class="text-decoration-none me-2 d-md-none d-flex align-items-center justify-content-center flex-shrink-0" title="Back"
               style="width: 34px; height: 34px; border-radius: 50%; color: #ff8c00;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            </a>

            @php
                $hasPhoto = $activeUser->profile_photo || $activeUser->photos->first();
                $cover = $activeUser->profile_photo ? asset('storage/'.$activeUser->profile_photo) : ($hasPhoto ? asset('storage/'.$activeUser->photos->first()->path) : null);
                $initials = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $activeUser->name), 0, 2));
            @endphp

            {{-- Avatar --}}
            <a href="{{ route('profile.view', $activeUser->id) }}" class="text-decoration-none d-block flex-shrink-0">
                @if($hasPhoto)
                    <div class="d-flex align-items-center justify-content-center" style="width:44px; height:44px; border-radius:50%; border: 2px solid {{ $activeUser->isOnline() ? '#ff8c00' : 'rgba(255,140,0,0.3)' }}; padding:2px; box-shadow: {{ $activeUser->isOnline() ? '0 0 8px rgba(255,140,0,0.5)' : 'none' }};">
                        <img src="{{ $cover }}" alt="{{ $activeUser->name }}" class="rounded-circle w-100 h-100" style="object-fit: cover;">
                    </div>
                @else
                    <div class="d-flex align-items-center justify-content-center" style="width:44px; height:44px; border-radius:50%; border: 2px solid {{ $activeUser->isOnline() ? '#ff8c00' : 'rgba(255,140,0,0.3)' }}; padding:2px; box-shadow: {{ $activeUser->isOnline() ? '0 0 8px rgba(255,140,0,0.5)' : 'none' }};">
                        <div class="rounded-circle w-100 h-100 d-flex justify-content-center align-items-center text-white fw-bold" style="font-size: 1rem; background: linear-gradient(135deg, rgba(255,140,0,0.4), rgba(255,140,0,0.2));">
                            {{ $initials ?: 'U' }}
                        </div>
                    </div>
                @endif
            </a>

            {{-- Name + Status --}}
            <div class="ms-3 flex-grow-1" style="min-width: 0;">
                <a href="{{ route('profile.view', $activeUser->id) }}" class="text-decoration-none">
                    <div class="fw-bold text-white" style="font-size: 0.95rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $activeUser->name }}</div>
                </a>
                @php
                    $chatSettings = \App\Models\Setting::getSettings();
                    $showStatusInChat = $activeUser->show_online_status_in_chat ?? $chatSettings->show_online_status_in_chat;
                @endphp
                @if($showStatusInChat)
                    @if($activeUser->isOnline())
                        <small style="color: #ff8c00; font-size: 0.7rem; font-weight: 600;">Online</small>
                    @elseif($activeUser->last_seen_at)
                        <small style="color: rgba(255,255,255,0.4); font-size: 0.7rem;">Last seen {{ $activeUser->last_seen_at->diffForHumans() }}</small>
                    @else
                        <small style="color: rgba(255,255,255,0.35); font-size: 0.7rem;">Offline</small>
                    @endif
                @endif
            </div>

            {{-- Phone Call Icon --}}
            @if($activeUser->phone_number)
                <a href="tel:{{ $activeUser->phone_number }}" class="flex-shrink-0 d-flex align-items-center justify-content-center text-decoration-none ms-2" title="Call {{ $activeUser->name }}"
                   style="width: 38px; height: 38px; border-radius: 50%; background: rgba(255,140,0,0.15); border: 1px solid rgba(255,140,0,0.4); color: #ff8c00; transition: all 0.2s; box-shadow: 0 0 10px rgba(255,140,0,0.2);">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="transform: rotate(270deg);">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12.34a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.62h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.22a16 16 0 0 0 6.29 6.29l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                    </svg>
                </a>
            @endif
        </div>

        <!-- Messages Body -->
        <div class="flex-grow-1 p-3 overflow-auto position-relative" id="chat-messages" wire:poll.3s style="background-color: #efeae2;">
            <!-- End-to-End Encryption Notice -->
            <div class="d-flex justify-content-center mb-4 mt-2">
                <div class="text-center px-3 py-2" style="background: rgba(255,140,0,0.15); border: 1px solid rgba(255,140,0,0.25); border-radius: 8px; max-width: 90%;">
                    <div class="d-flex align-items-center justify-content-center gap-2 mb-1" style="color: rgba(0,0,0,0.7); font-size: 0.75rem; font-weight: 700;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #d97700;"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        Messages and calls are end-to-end encrypted.
                    </div>
                    <div style="color: rgba(0,0,0,0.6); font-size: 0.7rem; line-height: 1.3; font-weight: 500;">
                        Only people in this chat can read, listen to, or share them.
                    </div>
                </div>
            </div>

            @php $lastDate = null; @endphp
            @forelse($messages as $message)
                @php
                    $msgDateObj = $message->created_at;
                    if ($msgDateObj->isToday()) {
                        $dateString = 'Today';
                    } elseif ($msgDateObj->isYesterday()) {
                        $dateString = 'Yesterday';
                    } else {
                        $dateString = $msgDateObj->format('d/m/Y');
                    }
                @endphp

                @if($lastDate !== $dateString)
                    <div class="d-flex justify-content-center my-3">
                        <div class="px-3 py-1 shadow-sm rounded-pill" style="background-color: #ffffff; color: rgba(0,0,0,0.6); font-size: 0.72rem; font-weight: 600; border: 1px solid rgba(0,0,0,0.05);">
                            {{ $dateString }}
                        </div>
                    </div>
                    @php $lastDate = $dateString; @endphp
                @endif
                <div class="d-flex mb-3 message-wrapper {{ $message->sender_id === auth()->id() ? 'justify-content-end' : '' }}" data-msg-id="{{ $message->id }}">
                    <div class="px-3 py-2 shadow-sm text-dark position-relative" 
                         style="max-width: 75%; border-radius: 12px; background-color: {{ $message->sender_id === auth()->id() ? '#e2ffc7' : '#ffffff' }}; {{ $message->sender_id === auth()->id() ? 'border-top-right-radius: 0px;' : 'border-top-left-radius: 0px;' }}">
                        
                        @if($message->replyTo)
                            <div class="mb-2 p-2 rounded" style="background-color: rgba(0,0,0,0.04); border-left: 4px solid {{ $message->sender_id === auth()->id() ? '#4ade80' : '#ff8c00' }}; font-size: 0.8rem;">
                                <div class="fw-bold mb-1" style="color: {{ $message->sender_id === auth()->id() ? '#15803d' : '#d97700' }};">{{ $message->replyTo->sender_id === auth()->id() ? 'You' : $message->replyTo->sender->name }}</div>
                                <div class="text-truncate" style="opacity: 0.75;">{{ $message->replyTo->body }}</div>
                            </div>
                        @endif

                        <div style="font-size: 0.95rem;">{{ $message->body }}</div>
                        <div class="d-flex align-items-center mt-1 justify-content-end text-dark opacity-75" style="font-size: 0.65rem; gap: 4px;">
                            <span>{{ $message->created_at->format('g:i A') }}</span>
                            @if($message->sender_id === auth()->id())
                                @if($message->is_read)
                                    {{-- Double Blue Tick --}}
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#0d6efd" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                      <polyline points="22 7 12 17 8 13"></polyline>
                                      <polyline points="16 7 12 11"></polyline>
                                      <polyline points="6 15 2 11"></polyline>
                                    </svg>
                                @elseif($activeUser->isOnline())
                                    {{-- Double Gray Tick --}}
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-50">
                                      <polyline points="22 7 12 17 8 13"></polyline>
                                      <polyline points="16 7 12 11"></polyline>
                                      <polyline points="6 15 2 11"></polyline>
                                    </svg>
                                @else
                                    {{-- Single Gray Tick --}}
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-50">
                                      <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted mt-5">
                    Say hello to start the conversation!
                </div>
            @endforelse
        </div>

        @if($replyToId)
            @php
                $replyMessage = \App\Models\Message::find($replyToId);
            @endphp
            @if($replyMessage)
                <div class="p-2 border-top border-secondary position-relative" style="background-color: #f8f9fa;">
                    <div class="p-2 rounded shadow-sm" style="background-color: #ffffff; border-left: 4px solid #ff8c00;">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-bold" style="color: #ff8c00; font-size: 0.8rem;">Replying to {{ $replyMessage->sender_id === auth()->id() ? 'Yourself' : $replyMessage->sender->name }}</span>
                            <button wire:click="cancelReply" type="button" class="btn-close" style="font-size: 0.6rem;"></button>
                        </div>
                        <div class="text-truncate text-dark opacity-75" style="font-size: 0.8rem;">{{ $replyMessage->body }}</div>
                    </div>
                </div>
            @endif
        @endif

        <!-- Input Area -->
        <div class="px-3 py-2" style="background: linear-gradient(135deg, rgba(255,140,0,0.12) 0%, rgba(255,140,0,0.04) 100%); border-top: 1px solid rgba(255,140,0,0.2);">
            <form wire:submit.prevent="sendMessage" class="d-flex align-items-center gap-2">
                <input type="text" wire:model="body"
                    class="form-control text-white border-0"
                    placeholder="Type a message..."
                    required
                    style="background: rgba(255,255,255,0.07); border-radius: 24px; padding: 0.5rem 1rem; font-size: 0.9rem; outline: none; box-shadow: none; border: 1px solid rgba(255,140,0,0.2) !important;">
                <button type="submit"
                    class="btn d-flex align-items-center justify-content-center flex-shrink-0"
                    style="width: 42px; height: 42px; border-radius: 50%; background: linear-gradient(135deg, #ff8c00, #ff6b00); border: none; box-shadow: 0 2px 10px rgba(255,140,0,0.4); padding: 0;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                </button>
            </form>
        </div>

        <script>
            function scrollToBottom() {
                const el = document.getElementById('chat-messages');
                if(el) {
                    el.scrollTop = el.scrollHeight;
                }
            }
            document.addEventListener('livewire:initialized', () => {
                scrollToBottom();
                Livewire.on('messageSent', () => {
                    setTimeout(scrollToBottom, 50);
                });
            });
            document.addEventListener('DOMContentLoaded', () => {
                scrollToBottom();
            });
            
            // Re-scroll on DOM updates
            document.addEventListener('livewire:navigated', () => scrollToBottom());

            // Admin-controlled Online Toast Config (User-specific with Global fallback)
            @php
                $gSettings = \App\Models\Setting::getSettings();
                $tEnabled = $activeUser->online_toast_enabled ?? $gSettings->online_toast_enabled;
                $tMessage = $activeUser->online_toast_message ?: ($gSettings->online_toast_message ?? '💚 {name} is now online!');
                $tDuration = $activeUser->online_toast_duration ?: ($gSettings->online_toast_duration ?? 4000);
                $tPosition = $activeUser->online_toast_position ?: ($gSettings->online_toast_position ?? 'bottom-right');
                $tSound = $activeUser->online_toast_sound ?: ($gSettings->online_toast_sound ?? 'none');
            @endphp
            window.chatToastConfig = {
                enabled: {{ $tEnabled ? 'true' : 'false' }},
                message: @json($tMessage),
                duration: {{ $tDuration }},
                position: @json($tPosition),
                sound: @json($tSound),
            };

            // Online toast function respecting admin settings
            window.showOnlineToast = function(userName) {
                if (!window.chatToastConfig || !window.chatToastConfig.enabled) return;

                const msg = window.chatToastConfig.message.replace('{name}', userName);
                const pos = window.chatToastConfig.position;
                const duration = window.chatToastConfig.duration;

                // Position styles
                const posStyles = {
                    'top-left':      'top:20px;left:20px;',
                    'top-right':     'top:20px;right:20px;',
                    'top-center':    'top:20px;left:50%;transform:translateX(-50%)',
                    'bottom-left':   'bottom:20px;left:20px;',
                    'bottom-right':  'bottom:20px;right:20px;',
                    'bottom-center': 'bottom:20px;left:50%;transform:translateX(-50%)',
                };

                const t = document.createElement('div');
                t.style.cssText = `position:fixed;${posStyles[pos]??posStyles['bottom-right']};z-index:9999;background:#1a2332;border:1px solid #4ade80;color:#4ade80;padding:10px 16px;border-radius:10px;font-size:13px;font-weight:600;box-shadow:0 4px 20px rgba(0,0,0,.4);transition:opacity .4s;`;
                t.textContent = msg;
                document.body.appendChild(t);

                // Sound
                if (window.chatToastConfig.sound !== 'none') {
                    try {
                        const ctx = new (window.AudioContext || window.webkitAudioContext)();
                        const osc = ctx.createOscillator();
                        const gain = ctx.createGain();
                        osc.connect(gain); gain.connect(ctx.destination);
                        osc.frequency.value = window.chatToastConfig.sound === 'chime' ? 880 : (window.chatToastConfig.sound === 'pop' ? 300 : 660);
                        osc.type = 'sine';
                        gain.gain.setValueAtTime(0.3, ctx.currentTime);
                        gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.4);
                        osc.start(); osc.stop(ctx.currentTime + 0.4);
                    } catch(e) {}
                }

                setTimeout(() => { t.style.opacity = '0'; setTimeout(() => t.remove(), 400); }, duration);
            };

            // Swipe to reply logic
            document.addEventListener('DOMContentLoaded', () => {
                let touchstartX = 0;
                let touchendX = 0;
                let currentMsgElement = null;
                let originalTransform = '';

                document.body.addEventListener('touchstart', e => {
                    const bubble = e.target.closest('.message-wrapper');
                    if (bubble) {
                        touchstartX = e.changedTouches[0].screenX;
                        currentMsgElement = bubble;
                        originalTransform = bubble.style.transform;
                        bubble.style.transition = 'none';
                    }
                }, {passive: true});

                document.body.addEventListener('touchmove', e => {
                    if (currentMsgElement) {
                        const currentX = e.changedTouches[0].screenX;
                        const diff = currentX - touchstartX;
                        if (diff > 0 && diff < 80) { // Only swipe right
                            currentMsgElement.style.transform = `translateX(${diff}px)`;
                        }
                    }
                }, {passive: true});

                document.body.addEventListener('touchend', e => {
                    if (currentMsgElement) {
                        touchendX = e.changedTouches[0].screenX;
                        currentMsgElement.style.transition = 'transform 0.3s ease';
                        currentMsgElement.style.transform = originalTransform;
                        
                        if (touchendX > touchstartX + 60) { // Trigger reply if swiped > 60px
                            const msgId = currentMsgElement.getAttribute('data-msg-id');
                            const wireEl = currentMsgElement.closest('[wire\\:id]');
                            if (msgId && wireEl) {
                                Livewire.find(wireEl.getAttribute('wire:id')).call('setReply', msgId);
                            }
                        }
                        currentMsgElement = null;
                    }
                }, {passive: true});
            });
        </script>
    @else
        <div class="d-flex h-100 justify-content-center align-items-center text-muted">
            Select a conversation to start chatting.
        </div>
    @endif
</div>
