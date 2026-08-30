<div class="chat-box d-flex flex-column bg-dark" style="height: 75vh;">
    @if($activeUser)
        <!-- Header -->
        <div class="p-3 border-bottom border-secondary d-flex align-items-center">
            <a href="{{ route('chat.index') }}" class="text-white text-opacity-75 text-decoration-none me-3 d-md-none" title="Back to conversations">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            </a>
            @php
                $hasPhoto = $activeUser->profile_photo || $activeUser->photos->first();
                $cover = $activeUser->profile_photo ? asset('storage/'.$activeUser->profile_photo) : ($hasPhoto ? asset('storage/'.$activeUser->photos->first()->path) : null);
                $initials = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $activeUser->name), 0, 2));
            @endphp
            @if($hasPhoto)
                <img src="{{ $cover }}" alt="{{ $activeUser->name }}" class="rounded-circle flex-shrink-0" style="width: 45px; height: 45px; object-fit: cover;">
            @else
                <div class="rounded-circle flex-shrink-0 bg-secondary bg-opacity-50 d-flex justify-content-center align-items-center text-white fw-bold" style="width: 45px; height: 45px; font-size: 1.1rem;">
                    {{ $initials ?: 'U' }}
                </div>
            @endif
            <div class="ms-3 flex-grow-1">
                <h6 class="mb-0 fw-bold text-white"><a href="{{ route('profile.view', $activeUser->id) }}" class="text-white text-decoration-none">{{ $activeUser->name }}</a></h6>
                @php
                    $chatSettings = \App\Models\Setting::getSettings();
                    $showStatusInChat = $activeUser->show_online_status_in_chat ?? $chatSettings->show_online_status_in_chat;
                @endphp
                @if($showStatusInChat)
                    @if($activeUser->isOnline())
                        <small style="color:#4ade80; font-size:0.72rem; font-weight:600;">Online</small>
                    @elseif($activeUser->last_seen_at)
                        <small class="text-muted" style="font-size:0.72rem;">Last seen {{ $activeUser->last_seen_at->diffForHumans() }}</small>
                    @else
                        <small class="text-muted" style="font-size:0.72rem;">Offline</small>
                    @endif
                @endif
            </div>

            {{-- Phone Call Icon --}}
            @if($activeUser->phone_number)
                <a href="tel:{{ $activeUser->phone_number }}" class="ms-auto flex-shrink-0 d-flex align-items-center justify-content-center text-decoration-none" title="Call {{ $activeUser->name }}"
                   style="width: 40px; height: 40px; border-radius: 50%; background: rgba(255,140,0,0.15); border: 1px solid rgba(255,140,0,0.4); color: #ff8c00; transition: all 0.2s; box-shadow: 0 0 12px rgba(255,140,0,0.25), 0 0 4px rgba(255,140,0,0.15);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="transform: rotate(270deg);">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12.34a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.62h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.22a16 16 0 0 0 6.29 6.29l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                    </svg>
                </a>
            @endif
        </div>

        <!-- Messages Body -->
        <div class="flex-grow-1 p-3 overflow-auto" id="chat-messages" wire:poll.3s>
            @forelse($messages as $message)
                <div class="d-flex mb-3 {{ $message->sender_id === auth()->id() ? 'justify-content-end' : '' }}">
                    <div class="px-3 py-2 rounded {{ $message->sender_id === auth()->id() ? 'bg-primary text-dark' : 'bg-secondary bg-opacity-25 text-white' }}" style="max-width: 75%;">
                        <div>{{ $message->body }}</div>
                        <small class="{{ $message->sender_id === auth()->id() ? 'text-dark opacity-75' : 'text-muted' }} d-block mt-1" style="font-size: 0.65rem;">{{ $message->created_at->format('g:i A') }}</small>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted mt-5">
                    Say hello to start the conversation!
                </div>
            @endforelse
        </div>

        <!-- Input Area -->
        <div class="p-3 border-top border-secondary">
            <form wire:submit.prevent="sendMessage" class="d-flex gap-2">
                <input type="text" wire:model="body" class="form-control bg-transparent text-white border-secondary" placeholder="Type a message..." required>
                <button type="submit" class="btn btn-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
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
        </script>
    @else
        <div class="d-flex h-100 justify-content-center align-items-center text-muted">
            Select a conversation to start chatting.
        </div>
    @endif
</div>
