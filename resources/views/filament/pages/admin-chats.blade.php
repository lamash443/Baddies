<x-filament-panels::page>
<style>
    .conv-card{background:#1e293b;border:1px solid #334155;border-radius:10px;padding:10px 12px;cursor:pointer;transition:border-color .15s,box-shadow .15s}
    .conv-card:hover{border-color:#f97316;box-shadow:0 0 0 1px #f9731630}
    .av{width:22px;height:22px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-weight:700;font-size:9px;flex-shrink:0;border:1px solid rgba(255,255,255,.1)}
    .av-a{background:#1d4ed8;color:#bfdbfe}
    .av-b{background:#9a3412;color:#fed7aa}
    .uname{font-size:11px;font-weight:600;color:#cbd5e1;max-width:70px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
    .badge{background:rgba(249,115,22,.12);color:#fb923c;border:1px solid rgba(249,115,22,.25);border-radius:9999px;padding:1px 7px;font-size:9px;font-weight:700;margin-left:auto;white-space:nowrap}
    .snip{background:#0f172a;border-radius:6px;padding:6px 10px;margin-top:7px;font-size:11px;color:#94a3b8;display:flex;gap:8px;align-items:center}
    .snip strong{color:#cbd5e1}
    .snip .ts{margin-left:auto;flex-shrink:0;font-size:9px;color:#64748b}
    .chat-wrap{background:#1e293b;border:1px solid #334155;border-radius:12px;display:flex;flex-direction:column;min-height:80vh}
    .chat-head{display:flex;align-items:center;gap:10px;padding:10px 14px;border-bottom:1px solid #334155;background:#0f172a;border-radius:12px 12px 0 0;flex-shrink:0}
    .chat-body{flex:1;overflow-y:auto;padding:18px;display:flex;flex-direction:column;gap:14px;background:#0f172a;border-radius:0 0 12px 12px}
    .msg-row{display:flex}
    .msg-row.me{justify-content:flex-end}
    .bubble{max-width:65%;padding:8px 12px;border-radius:14px;font-size:12px;line-height:1.5;word-break:break-word}
    .bubble.left{background:#1e293b;color:#e2e8f0;border:1px solid #334155;border-top-left-radius:4px}
    .bubble.right{background:#ea580c;color:#fff;border-top-right-radius:4px}
    .msg-meta{font-size:9px;color:#64748b;margin-top:3px;display:flex;gap:6px}
    .btn-back{background:#1e293b;border:1px solid #334155;color:#94a3b8;padding:5px 12px;border-radius:8px;font-size:11px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:5px}
    .btn-back:hover{color:#f1f5f9;border-color:#94a3b8}
    .settings-bar{background:#1e293b;border:1px solid #334155;border-radius:10px;padding:14px 16px;margin-bottom:16px}
    .settings-bar h3{color:#f1f5f9;font-size:13px;font-weight:700;margin:0 0 12px}
    .settings-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:12px;margin-bottom:12px}
    .sfield label{display:block;font-size:10px;font-weight:600;color:#94a3b8;margin-bottom:4px;text-transform:uppercase;letter-spacing:.05em}
    .sfield input,.sfield select{width:100%;background:#0f172a;border:1px solid #334155;color:#e2e8f0;border-radius:6px;padding:5px 8px;font-size:12px}
    .toggle-row{display:flex;align-items:center;gap:10px;padding:5px 0}
    .toggle-row label{font-size:12px;color:#cbd5e1;cursor:pointer}
    .toggle-row input[type=checkbox]{width:16px;height:16px;accent-color:#f97316;cursor:pointer}
    .btn-save{background:#f97316;color:#fff;border:none;border-radius:8px;padding:7px 18px;font-size:12px;font-weight:700;cursor:pointer;margin-top:12px}
    .btn-save:hover{background:#ea580c}
    .btn-toggle-settings{background:transparent;border:1px solid #334155;color:#94a3b8;border-radius:8px;padding:5px 12px;font-size:11px;font-weight:600;cursor:pointer;margin-bottom:12px}
    .btn-toggle-settings:hover{border-color:#f97316;color:#f97316}
</style>

@if(!$activeUserA || !$activeUserB)

    {{-- Conversations grid --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:10px">
        @forelse($conversations as $conv)
            <div class="conv-card" wire:click="openConversation({{ $conv->user_a->id }},{{ $conv->user_b->id }})">
                <div style="display:flex;align-items:center;gap:5px">
                    <span class="av av-a">{{ strtoupper(substr($conv->user_a->name,0,1)) }}</span>
                    <span class="uname">{{ $conv->user_a->name }}</span>
                    <span style="color:#64748b;font-size:11px;margin:0 2px">⇄</span>
                    <span class="av av-b">{{ strtoupper(substr($conv->user_b->name,0,1)) }}</span>
                    <span class="uname">{{ $conv->user_b->name }}</span>
                    <span class="badge">{{ $conv->total_messages }} msgs</span>
                </div>
                <div class="snip">
                    <strong>{{ $conv->last_message->sender_id===$conv->user_a->id ? $conv->user_a->name : $conv->user_b->name }}:</strong>
                    <span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;flex:1">{{ $conv->last_message->body }}</span>
                    <span class="ts">{{ $conv->last_message->created_at->diffForHumans() }}</span>
                </div>
            </div>
        @empty
            <div style="grid-column:1/-1;text-align:center;padding:60px 20px;color:#64748b;font-size:13px">
                No conversations yet.
            </div>
        @endforelse
    </div>

@else

    {{-- Settings panel for specific user --}}
    @if($editingUser)
        <div class="settings-bar">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
                <h3 style="margin:0">🟢 Online Settings: {{ $editingUser->name }}</h3>
                <button wire:click="closeSettings" style="background:none;border:none;color:#94a3b8;cursor:pointer;font-size:16px">&times;</button>
            </div>
            
            <div class="settings-grid">
                <div class="sfield">
                    <label>Toast Message <span style="color:#64748b">({name} = username)</span></label>
                    <input type="text" wire:model="online_toast_message" placeholder="Leave blank for global default">
                </div>
                <div class="sfield">
                    <label>Toast Position</label>
                    <select wire:model="online_toast_position">
                        <option value="">-- Use Global Default --</option>
                        <option value="bottom-right">Bottom Right</option>
                        <option value="bottom-left">Bottom Left</option>
                        <option value="bottom-center">Bottom Center</option>
                        <option value="top-right">Top Right</option>
                        <option value="top-left">Top Left</option>
                        <option value="top-center">Top Center</option>
                    </select>
                </div>
                <div class="sfield">
                    <label>Toast Duration (ms)</label>
                    <input type="number" wire:model="online_toast_duration" min="1000" max="15000" step="500" placeholder="Leave blank for global default">
                </div>
                <div class="sfield">
                    <label>Notification Sound</label>
                    <select wire:model="online_toast_sound">
                        <option value="">-- Use Global Default --</option>
                        <option value="none">No Sound</option>
                        <option value="ping">Ping</option>
                        <option value="chime">Chime</option>
                        <option value="pop">Pop</option>
                    </select>
                </div>
                <div class="sfield">
                    <label>Online Threshold (minutes)</label>
                    <input type="number" wire:model="online_threshold_minutes" min="1" max="60" placeholder="Leave blank for global default">
                </div>
            </div>
            <div class="toggle-row">
                <input type="checkbox" id="force_online" wire:model="force_online">
                <label for="force_online" style="color:#4ade80;font-weight:bold;">FORCE {{ $editingUser->name }} to appear ONLINE everywhere</label>
            </div>
            <div class="toggle-row">
                <input type="checkbox" id="toast_enabled" wire:model="online_toast_enabled">
                <label for="toast_enabled">Enable Online Toast Notification for {{ $editingUser->name }}</label>
            </div>
            <div class="toggle-row">
                <input type="checkbox" id="status_in_chat" wire:model="show_online_status_in_chat">
                <label for="status_in_chat">Show Online/Offline Status in Chat Header for {{ $editingUser->name }}</label>
            </div>
            <button class="btn-save" wire:click="saveOnlineSettings">💾 Save Settings for {{ $editingUser->name }}</button>
        </div>
    @endif

    {{-- Chat history view --}}
    <div class="chat-wrap" style="position: relative; padding-bottom: 70px;">
        <div class="chat-head">
            <button class="btn-back" wire:click="closeConversation">← Back</button>
            <span class="av av-a" style="width:20px;height:20px;font-size:8px">{{ strtoupper(substr($userA->name,0,1)) }}</span>
            <span style="font-size:12px;font-weight:700;color:#e2e8f0;display:flex;align-items:center;gap:4px">
                {{ $userA->name }}
                <button wire:click="openSettingsForUser({{ $userA->id }})" style="background:none;border:none;color:#94a3b8;cursor:pointer;padding:0;font-size:12px" title="Online Settings">⚙️</button>
            </span>
            <span style="color:#475569;font-size:11px">⇄</span>
            <span class="av av-b" style="width:20px;height:20px;font-size:8px">{{ strtoupper(substr($userB->name,0,1)) }}</span>
            <span style="font-size:12px;font-weight:700;color:#e2e8f0;display:flex;align-items:center;gap:4px">
                {{ $userB->name }}
                <button wire:click="openSettingsForUser({{ $userB->id }})" style="background:none;border:none;color:#94a3b8;cursor:pointer;padding:0;font-size:12px" title="Online Settings">⚙️</button>
            </span>
            <span style="margin-left:auto;font-size:10px;color:#64748b">{{ count($messages) }} messages</span>
        </div>
        <div class="chat-body" wire:poll.3s>
            @foreach($messages as $msg)
                @php $isA = $msg->sender_id === $userA->id; @endphp
                <div class="msg-row {{ $isA ? '' : 'me' }}">
                    <div>
                        <div class="bubble {{ $isA ? 'left' : 'right' }}">{{ $msg->body }}</div>
                        <div class="msg-meta" style="justify-content: {{ $isA ? 'flex-start' : 'flex-end' }}">
                            <span>{{ $isA ? $userA->name : $userB->name }}</span>
                            <span>{{ $msg->created_at->format('M d, g:i A') }}</span>
                            <span>
                                @if($msg->is_read)
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 6 11 13 8 10"></polyline><path d="M22 10l-7 7-3-3"></path></svg>
                                @else
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 6 11 13 8 10"></polyline><path d="M22 10l-7 7-3-3"></path></svg>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Admin Reply Box --}}
        <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 12px; background: #1e293b; border-top: 1px solid #334155; border-radius: 0 0 12px 12px; display: flex; gap: 10px; align-items: center;">
            <input type="text" wire:model="newMessage" wire:keydown.enter="sendMessageAs({{ $userA->id }})" placeholder="Type a message to send..." style="flex: 1; background: #0f172a; border: 1px solid #334155; color: #e2e8f0; border-radius: 8px; padding: 8px 12px; font-size: 12px;">
            <div style="display: flex; gap: 6px; flex-shrink: 0;">
                <button wire:click="sendMessageAs({{ $userA->id }})" style="background: #1d4ed8; color: #fff; border: none; border-radius: 6px; padding: 6px 12px; font-size: 11px; font-weight: 600; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#1d4ed8'">
                    Send as {{ explode(' ', $userA->name)[0] }}
                </button>
                <button wire:click="sendMessageAs({{ $userB->id }})" style="background: #ea580c; color: #fff; border: none; border-radius: 6px; padding: 6px 12px; font-size: 11px; font-weight: 600; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#f97316'" onmouseout="this.style.background='#ea580c'">
                    Send as {{ explode(' ', $userB->name)[0] }}
                </button>
            </div>
        </div>
    </div>

@endif
</x-filament-panels::page>
