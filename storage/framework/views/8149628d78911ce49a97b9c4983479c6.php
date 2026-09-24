<?php if (isset($component)) { $__componentOriginal166a02a7c5ef5a9331faf66fa665c256 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

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

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$activeUserA || !$activeUserB): ?>

    
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:10px">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="conv-card" wire:click="openConversation(<?php echo e($conv->user_a->id); ?>,<?php echo e($conv->user_b->id); ?>)">
                <div style="display:flex;align-items:center;gap:5px">
                    <span class="av av-a"><?php echo e(strtoupper(substr($conv->user_a->name,0,1))); ?></span>
                    <span class="uname"><?php echo e($conv->user_a->name); ?></span>
                    <span style="color:#64748b;font-size:11px;margin:0 2px">⇄</span>
                    <span class="av av-b"><?php echo e(strtoupper(substr($conv->user_b->name,0,1))); ?></span>
                    <span class="uname"><?php echo e($conv->user_b->name); ?></span>
                    <span class="badge"><?php echo e($conv->total_messages); ?> msgs</span>
                </div>
                <div class="snip">
                    <strong><?php echo e($conv->last_message->sender_id===$conv->user_a->id ? $conv->user_a->name : $conv->user_b->name); ?>:</strong>
                    <span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;flex:1">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($conv->last_message->is_deleted || $conv->last_message->deleted_by_sender || $conv->last_message->deleted_by_receiver): ?>
                            <span style="font-style: italic; opacity: 0.7;">This message was deleted</span>
                        <?php elseif($conv->last_message->image_path): ?>
                            📷 Photo <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($conv->last_message->body): ?> - <?php echo e($conv->last_message->body); ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php else: ?>
                            <?php echo e($conv->last_message->body); ?>

                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </span>
                    <span class="ts"><?php echo e($conv->last_message->created_at->diffForHumans()); ?></span>
                </div>
            </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <div style="grid-column:1/-1;text-align:center;padding:60px 20px;color:#64748b;font-size:13px">
                No conversations yet.
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

<?php else: ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($editingUser): ?>
        <div class="settings-bar">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
                <h3 style="margin:0">🟢 Online Settings: <?php echo e($editingUser->name); ?></h3>
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
                <label for="force_online" style="color:#4ade80;font-weight:bold;">FORCE <?php echo e($editingUser->name); ?> to appear ONLINE everywhere</label>
            </div>
            <div class="toggle-row">
                <input type="checkbox" id="toast_enabled" wire:model="online_toast_enabled">
                <label for="toast_enabled">Enable Online Toast Notification for <?php echo e($editingUser->name); ?></label>
            </div>
            <div class="toggle-row">
                <input type="checkbox" id="status_in_chat" wire:model="show_online_status_in_chat">
                <label for="status_in_chat">Show Online/Offline Status in Chat Header for <?php echo e($editingUser->name); ?></label>
            </div>
            <button class="btn-save" wire:click="saveOnlineSettings">💾 Save Settings for <?php echo e($editingUser->name); ?></button>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="chat-wrap" style="position: relative; padding-bottom: 70px;">
        <div class="chat-head">
            <button class="btn-back" wire:click="closeConversation">← Back</button>
            <span class="av av-a" style="width:20px;height:20px;font-size:8px"><?php echo e(strtoupper(substr($userA->name,0,1))); ?></span>
            <span style="font-size:12px;font-weight:700;color:#e2e8f0;display:flex;align-items:center;gap:4px">
                <?php echo e($userA->name); ?>

                <button wire:click="openSettingsForUser(<?php echo e($userA->id); ?>)" style="background:none;border:none;color:#94a3b8;cursor:pointer;padding:0;font-size:12px" title="Online Settings">⚙️</button>
            </span>
            <span style="color:#475569;font-size:11px">⇄</span>
            <span class="av av-b" style="width:20px;height:20px;font-size:8px"><?php echo e(strtoupper(substr($userB->name,0,1))); ?></span>
            <span style="font-size:12px;font-weight:700;color:#e2e8f0;display:flex;align-items:center;gap:4px">
                <?php echo e($userB->name); ?>

                <button wire:click="openSettingsForUser(<?php echo e($userB->id); ?>)" style="background:none;border:none;color:#94a3b8;cursor:pointer;padding:0;font-size:12px" title="Online Settings">⚙️</button>
            </span>
            <span style="margin-left:auto;font-size:10px;color:#64748b"><?php echo e(count($messages)); ?> messages</span>
        </div>
        <div class="chat-body" wire:poll.3s>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php $isA = $msg->sender_id === $userA->id; ?>
                <div class="msg-row <?php echo e($isA ? '' : 'me'); ?>">
                    <div>
                        <div class="bubble <?php echo e($isA ? 'left' : 'right'); ?>">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($msg->is_deleted || $msg->deleted_by_sender || $msg->deleted_by_receiver): ?>
                                <span style="background:rgba(239,68,68,0.2);color:#f87171;border:1px solid rgba(239,68,68,0.4);font-size:9px;padding:2px 6px;margin-right:6px;border-radius:4px;font-weight:bold;display:inline-flex;align-items:center;gap:3px;margin-bottom:4px;">
                                    🗑️ Deleted
                                </span><br>
                            <?php else: ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($msg->image_path): ?>
                                    <div style="margin-bottom: 5px;">
                                        <a href="<?php echo e(asset('storage/' . $msg->image_path)); ?>" target="_blank">
                                            <img src="<?php echo e(asset('storage/' . $msg->image_path)); ?>" style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); object-fit: cover;">
                                        </a>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php echo e($msg->body); ?>

                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="msg-meta" style="justify-content: <?php echo e($isA ? 'flex-start' : 'flex-end'); ?>">
                            <span><?php echo e($isA ? $userA->name : $userB->name); ?></span>
                            <span><?php echo e($msg->created_at->format('M d, g:i A')); ?></span>
                            <span>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($msg->is_read): ?>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 6 11 13 8 10"></polyline><path d="M22 10l-7 7-3-3"></path></svg>
                                <?php else: ?>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 6 11 13 8 10"></polyline><path d="M22 10l-7 7-3-3"></path></svg>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>

        
        <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 12px; background: #1e293b; border-top: 1px solid #334155; border-radius: 0 0 12px 12px; display: flex; gap: 10px; align-items: center;">
            
            <div style="position: relative; flex-shrink: 0; width: 34px; height: 34px;">
                <label style="display: flex; align-items: center; justify-content: center; margin: 0; position: absolute; top: 0; left: 0; width: 100%; height: 100%; border-radius: 50%; background: #0f172a; border: 1px solid #334155; color: #94a3b8; cursor: pointer; overflow: hidden; transition: all 0.2s;" title="Attach Photo">
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($photo): ?>
                        <img src="<?php echo e($photo->temporaryUrl()); ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    <?php else: ?>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
                        </svg>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <div wire:loading.flex wire:target="photo" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; align-items: center; justify-content: center; background: rgba(0,0,0,0.5); z-index: 10;">
                        <span style="color: #fff; font-size: 10px; font-weight: bold;">...</span>
                    </div>
                    <input type="file" wire:model="photo" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" style="display: none;">
                </label>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($photo): ?>
                    <button type="button" wire:click="removePhoto" style="position: absolute; top: -4px; right: -4px; width: 16px; height: 16px; border-radius: 50%; background: #ef4444; color: #fff; border: none; padding: 0; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 15; box-shadow: 0 1px 3px rgba(0,0,0,0.3);">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <input type="text" wire:model="newMessage" wire:keydown.enter="sendMessageAs(<?php echo e($userA->id); ?>)" placeholder="<?php echo e($photo ? 'Add a caption...' : 'Type a message to send...'); ?>" style="flex: 1; background: #0f172a; border: 1px solid #334155; color: #e2e8f0; border-radius: 8px; padding: 8px 12px; font-size: 12px;">
            
            <div style="display: flex; gap: 6px; flex-shrink: 0;">
                <button wire:click="sendMessageAs(<?php echo e($userA->id); ?>)" wire:loading.attr="disabled" wire:target="photo" style="background: #1d4ed8; color: #fff; border: none; border-radius: 6px; padding: 6px 12px; font-size: 11px; font-weight: 600; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#1d4ed8'">
                    Send as <?php echo e(explode(' ', $userA->name)[0]); ?>

                </button>
                <button wire:click="sendMessageAs(<?php echo e($userB->id); ?>)" wire:loading.attr="disabled" wire:target="photo" style="background: #ea580c; color: #fff; border: none; border-radius: 6px; padding: 6px 12px; font-size: 11px; font-weight: 600; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#f97316'" onmouseout="this.style.background='#ea580c'">
                    Send as <?php echo e(explode(' ', $userB->name)[0]); ?>

                </button>
            </div>
        </div>
    </div>

<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $attributes = $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $component = $__componentOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php /**PATH C:\Users\willi\Desktop\Kenyan Baddies Club\resources\views\filament\pages\admin-chats.blade.php ENDPATH**/ ?>