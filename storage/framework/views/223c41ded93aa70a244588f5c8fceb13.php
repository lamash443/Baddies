<div class="chat-list border-end border-secondary position-relative" style="height: 75vh; overflow-y: auto; -webkit-overflow-scrolling: touch;"
    wire:poll.4s
    data-show-archived="<?php echo e($showArchived ? 'true' : 'false'); ?>"
    data-archive-count="<?php echo e(count($archivedConversations)); ?>"
    @touchstart="touchStart" @touchmove="touchMove" @touchend="touchEnd" @touchcancel="touchEnd" @scroll.passive="if ($el.scrollTop > 20) showArchiveButton = false"
    x-data="{
        selectedChats: [],
        longPressTimer: null,
        didLongPress: false,
        startX: 0,
        startY: 0,

        pullDistance: 0,
        pullStartY: 0,
        isPulling: false,
        canPull: false,
        pullThreshold: 75,
        holdArchiveTimer: null,
        isArchiveReady: false,
        showArchiveButton: false,

        init() {
            // Force reset scroll on load to fix iOS history restoration blocking pull-to-refresh
            setTimeout(() => { this.$el.scrollTop = 0; }, 50);
        },
        
        touchStart(e) {
            // Allow pull-to-reveal to start on chat rows (anchor tags). Only block on form elements/buttons.
            if (e.target.closest('button, input')) {
                this.canPull = false;
                return;
            }
            
            // Read state dynamically from DOM to avoid frozen variables after Livewire morph
            const isArchived = this.$el.getAttribute('data-show-archived') === 'true';
            const archiveCount = parseInt(this.$el.getAttribute('data-archive-count') || '0');

            // Use <= 5 to be forgiving in case of 1px Safari scroll offsets
            if ($el.scrollTop <= 5 && archiveCount > 0 && !isArchived && !this.showArchiveButton) {
                this.pullStartY = e.touches[0].clientY;
                this.isPulling = true;
                this.canPull = true;
                this.pullDistance = 0;
                this.isArchiveReady = false;
                if(this.holdArchiveTimer) clearTimeout(this.holdArchiveTimer);
                this.holdArchiveTimer = null;
            } else {
                this.canPull = false;
            }
        },
        touchMove(e) {
            if (!this.canPull || !this.isPulling) return;
            const y = e.touches[0].clientY;
            const diff = y - this.pullStartY;
            
            if (diff > 0) {
                // Pulling down at top of list — intercept and prevent native scroll/bounce
                if (e.cancelable) e.preventDefault();
                
                // Frictional pull
                this.pullDistance = Math.min(diff * 0.45, 120);

                if (this.pullDistance >= this.pullThreshold) {
                    if (!this.holdArchiveTimer && !this.isArchiveReady) {
                        this.holdArchiveTimer = setTimeout(() => {
                            this.isArchiveReady = true;
                            if (navigator.vibrate) navigator.vibrate(50);
                        }, 700); // 700ms hold required
                    }
                } else {
                    if (this.holdArchiveTimer) {
                        clearTimeout(this.holdArchiveTimer);
                        this.holdArchiveTimer = null;
                    }
                    this.isArchiveReady = false;
                }
            } else {
                // Scrolling down the list normally — abort pull and let native scroll take over
                this.isPulling = false;
                this.canPull = false;
            }
        },
        touchEnd(e) {
            if (!this.isPulling) return;
            this.isPulling = false;
            if (this.holdArchiveTimer) {
                clearTimeout(this.holdArchiveTimer);
                this.holdArchiveTimer = null;
            }
            if (this.isArchiveReady) {
                // Reveal the button instead of auto-navigating
                this.showArchiveButton = true;
            }
            this.pullDistance = 0;
            this.isArchiveReady = false;
        },

        startPress(id, event) {
            const e = event || window.event;
            if (e?.button !== undefined && e.button !== 0) return;
            this.didLongPress = false;
            if (e) {
                this.startX = e.clientX ?? e.touches?.[0]?.clientX ?? 0;
                this.startY = e.clientY ?? e.touches?.[0]?.clientY ?? 0;
            }
            this.clearLongPress();
            this.longPressTimer = setTimeout(() => {
                this.didLongPress = true;
                const numericId = Number(id);
                if (numericId > 0 && !this.selectedChats.includes(numericId)) {
                    this.selectedChats.push(numericId);
                }
                if (navigator.vibrate) navigator.vibrate(40);
                this.longPressTimer = null;
            }, 450);
        },

        movePress(event) {
            if (!this.longPressTimer) return;
            const e = event || window.event;
            const currentX = e.clientX ?? e.touches?.[0]?.clientX ?? 0;
            const currentY = e.clientY ?? e.touches?.[0]?.clientY ?? 0;
            if (Math.abs(currentX - this.startX) > 10 || Math.abs(currentY - this.startY) > 10) {
                this.clearLongPress();
            }
        },

        endPress() {
            this.clearLongPress();
        },

        clearLongPress() {
            if (this.longPressTimer) {
                clearTimeout(this.longPressTimer);
                this.longPressTimer = null;
            }
        },

        isSelected(id) {
            return this.selectedChats.includes(Number(id));
        },

        toggleSelected(id) {
            const numericId = Number(id);
            if (!numericId) return;
            const index = this.selectedChats.indexOf(numericId);
            if (index === -1) {
                this.selectedChats.push(numericId);
            } else {
                this.selectedChats.splice(index, 1);
            }
        },

        clearSelection() {
            this.selectedChats = [];
            this.didLongPress = false;
        },

        selectedIds() {
            return this.selectedChats.map(id => Number(id)).filter(id => id > 0).join(',');
        },

        handleClick(id, event, url) {
            const numericId = Number(id);
            if (this.didLongPress) {
                event.preventDefault();
                event.stopPropagation();
                if (event.stopImmediatePropagation) event.stopImmediatePropagation();
                this.didLongPress = false;
                return;
            }
            if (this.selectedChats.length > 0) {
                event.preventDefault();
                event.stopPropagation();
                if (event.stopImmediatePropagation) event.stopImmediatePropagation();
                this.toggleSelected(numericId);
                return;
            }
            if (url) {
                event.preventDefault();
                event.stopPropagation();
                if (window.Livewire) {
                    Livewire.navigate(url);
                } else {
                    window.location.href = url;
                }
            }
        },

        showDeleteModal: false,
        pendingDeleteIds: '',

        cancelDelete() {
            this.showDeleteModal = false;
            this.pendingDeleteIds = '';
        }
    }">

<style>
.chat-list {
    --chat-list-text: #111111;
    --chat-list-muted: rgba(0,0,0,0.6);
    --chat-list-muted-light: rgba(0,0,0,0.4);
    --chat-list-unread: #000000;
}
[data-bs-theme="dark"] .chat-list, .dark .chat-list {
    --chat-list-text: rgba(255,255,255,0.85);
    --chat-list-muted: rgba(255,255,255,0.4);
    --chat-list-muted-light: rgba(255,255,255,0.3);
    --chat-list-unread: #ffffff;
}
/* Custom flex helper WITHOUT !important so Alpine x-show can override it */
.cl-flex { display: flex; }
[x-cloak] { display: none !important; }

/* Selection checkmark animations */
@keyframes checkmark-pop-in {
    0%   { transform: scale(0) rotate(-15deg); opacity: 0; }
    65%  { transform: scale(1.2) rotate(3deg); opacity: 1; }
    100% { transform: scale(1) rotate(0deg); opacity: 1; }
}
@keyframes checkmark-pop-out {
    0%   { transform: scale(1); opacity: 1; }
    100% { transform: scale(0); opacity: 0; }
}
.chat-check-badge {
    position: absolute;
    bottom: -3px;
    right: -3px;
    width: 17px;
    height: 17px;
    border-radius: 50%;
    background: #ff8c00;
    border: 2px solid #111;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 6;
    pointer-events: none;
    transform: scale(0);
    opacity: 0;
    transition: none;
}
.chat-check-badge.is-selected {
    animation: checkmark-pop-in 0.28s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
}
.chat-check-badge.is-deselected {
    animation: checkmark-pop-out 0.18s ease-in forwards;
}
</style>

    
    <template x-if="showDeleteModal">
        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
             style="z-index: 200; background: rgba(0,0,0,0.65); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);"
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">

            <div @click.outside="cancelDelete()"
                 style="width: 100%; max-width: 380px; margin: 0 1.25rem;
                        background: linear-gradient(145deg, rgba(20,12,0,0.97), rgba(13,13,13,0.97));
                        border: 1px solid rgba(255,140,0,0.3);
                        border-radius: 20px;
                        box-shadow: 0 24px 60px rgba(0,0,0,0.6), 0 0 0 1px rgba(255,140,0,0.08), inset 0 1px 0 rgba(255,255,255,0.04);
                        overflow: hidden;">

                
                <div style="padding: 1.25rem 1.25rem 0.75rem; border-bottom: 1px solid rgba(255,140,0,0.12);">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 38px; height: 38px; border-radius: 50%; background: rgba(220,53,69,0.15); border: 1px solid rgba(220,53,69,0.3); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#dc3545" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="fw-bold text-white" style="font-size: 0.98rem; line-height: 1.3;" x-text="selectedChats.length > 1 ? 'Delete ' + selectedChats.length + ' chats?' : 'Delete chat?'">Delete chat?</div>
                            <div style="font-size: 0.75rem; color: rgba(255,255,255,0.4); margin-top: 1px;">This action cannot be undone</div>
                        </div>
                    </div>
                </div>

                
                <div style="padding: 0.85rem 1.25rem 1.25rem; display: flex; flex-direction: column; gap: 0.5rem;">
                    <button type="button"
                            @click.stop="let _ids = pendingDeleteIds; showDeleteModal=false; pendingDeleteIds=''; selectedChats=[]; didLongPress=false; $wire.handleChatListAction('delete', _ids).then(() => $wire.$refresh())"
                            class="w-100 d-flex align-items-center gap-3 text-start"
                            style="background: rgba(220,53,69,0.1); border: 1px solid rgba(220,53,69,0.3); border-radius: 12px; padding: 0.75rem 1rem; color: #ff6b6b; font-size: 0.9rem; font-weight: 600; cursor: pointer; transition: background 0.12s ease, border-color 0.12s ease;"
                            onmouseenter="this.style.background='rgba(220,53,69,0.2)'; this.style.borderColor='rgba(220,53,69,0.5)'"
                            onmouseleave="this.style.background='rgba(220,53,69,0.1)'; this.style.borderColor='rgba(220,53,69,0.3)'">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        Delete Chat
                    </button>

                    <button type="button"
                            @click.stop="cancelDelete()"
                            class="w-100"
                            style="background: transparent; border: 1px solid rgba(255,140,0,0.2); border-radius: 12px; padding: 0.65rem 1rem; color: #ff8c00; font-size: 0.88rem; font-weight: 600; cursor: pointer; transition: background 0.12s ease, border-color 0.12s ease; margin-top: 0.15rem;"
                            onmouseenter="this.style.background='rgba(255,140,0,0.08)'; this.style.borderColor='rgba(255,140,0,0.4)'"
                            onmouseleave="this.style.background='transparent'; this.style.borderColor='rgba(255,140,0,0.2)'">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </template>

    
    <div class="p-3 border-bottom border-secondary border-opacity-50 position-relative" style="min-height:64px; background: inherit; z-index: 20;">
        
        
        <div class="d-flex align-items-center gap-2 w-100">
            <a href="<?php echo e(route('dashboard')); ?>" class="text-decoration-none d-flex align-items-center" title="Back to Dashboard">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($siteSettings['logo'])): ?>
                    <img src="<?php echo e(asset('storage/' . $siteSettings['logo'])); ?>" alt="Logo" style="max-height:48px;width:auto;object-fit:contain;margin-left:-0.5rem;">
                <?php else: ?>
                    <h4 class="mb-0 fw-bold" style="color: #ff8c00; letter-spacing: 0.5px; margin-left: -0.5rem;">Baddies Club</h4>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </a>
            <?php
                $totalUnread = auth()->user()->messagesReceived()->where('is_read', false)->where('deleted_by_receiver', false)->count();
            ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($totalUnread > 0): ?>
                <span style="background: #ff8c00; color: #000; font-size: 0.6rem; font-weight: 800; padding: 2px 8px; border-radius: 50px; letter-spacing: 0.03em; margin-left: auto;">
                    <?php echo e($totalUnread); ?> New
                </span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div x-show="selectedChats.length > 0" 
             style="display: none; background: #0d0d0d; z-index: 50; top: 0; left: 0; right: 0; bottom: 0;" 
             class="position-absolute w-100 h-100">
             
            <div class="d-flex align-items-center justify-content-between h-100 px-3 w-100">
                <div class="d-flex align-items-center gap-3">
                    <button type="button" @click.stop.prevent="clearSelection()" class="btn text-white p-0 d-flex align-items-center justify-content-center" style="border:none;background:none;cursor:pointer;" title="Cancel">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    </button>
                    <span class="fw-bold" style="color:#fff;font-size:1rem;" x-text="selectedChats.length + ' selected'"></span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    
                    <button type="button"
                            @click.prevent.stop="let _ids = selectedIds(); if(_ids){ selectedChats=[]; didLongPress=false; $wire.handleChatListAction('pin', _ids).then(() => $wire.$refresh()); }"
                            title="Pin"
                            style="display:flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:50%;border:none;cursor:pointer;background:rgba(255,140,0,0.15);color:#ff8c00;transition:background 0.2s,transform 0.1s;touch-action:manipulation;"
                            onmouseenter="this.style.background='rgba(255,140,0,0.28)'"
                            onmouseleave="this.style.background='rgba(255,140,0,0.15)'">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ff8c00" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="17" x2="12" y2="22"></line><path d="M5 17h14l-1.5-6H6.5L5 17z"></path><path d="M9 11V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v7"></path></svg>
                    </button>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$showArchived): ?>
                    
                    <button type="button"
                            @click.prevent.stop="let _ids = selectedIds(); if(_ids){ selectedChats=[]; didLongPress=false; $wire.handleChatListAction('archive', _ids).then(() => $wire.$refresh()); }"
                            title="Archive"
                            style="display:flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:50%;border:none;cursor:pointer;background:rgba(255,140,0,0.15);color:#ff8c00;transition:background 0.2s,transform 0.1s;touch-action:manipulation;"
                            onmouseenter="this.style.background='rgba(255,140,0,0.28)'"
                            onmouseleave="this.style.background='rgba(255,140,0,0.15)'">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ff8c00" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg>
                    </button>
                    <?php else: ?>
                    
                    <button type="button"
                            @click.prevent.stop="let _ids = selectedIds(); if(_ids){ selectedChats=[]; didLongPress=false; $wire.handleChatListAction('unarchive', _ids).then(() => $wire.$refresh()); }"
                            title="Unarchive"
                            style="display:flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:50%;border:none;cursor:pointer;background:rgba(255,140,0,0.15);color:#ff8c00;transition:background 0.2s,transform 0.1s;touch-action:manipulation;"
                            onmouseenter="this.style.background='rgba(255,140,0,0.28)'"
                            onmouseleave="this.style.background='rgba(255,140,0,0.15)'">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ff8c00" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 10 4 15 9 20"></polyline><path d="M20 4v7a4 4 0 0 1-4 4H4"></path></svg>
                    </button>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    
                    <button type="button"
                            @click.prevent.stop="if(selectedChats.length){ pendingDeleteIds = selectedIds(); showDeleteModal = true; }"
                            title="Delete"
                            style="display:flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:50%;border:none;cursor:pointer;background:rgba(239,68,68,0.12);color:#ef4444;transition:background 0.2s,transform 0.1s;touch-action:manipulation;"
                            onmouseenter="this.style.background='rgba(239,68,68,0.25)'"
                            onmouseleave="this.style.background='rgba(239,68,68,0.12)'">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    
    <a href="<?php echo e(route('chat.index') . '?showArchived=1'); ?>" wire:navigate x-ref="archiveTrigger" @click="showArchiveButton = true" class="d-none"></a>

    
    <div x-show="pullDistance > 0 && !<?php echo e($showArchived ? 'true' : 'false'); ?>" 
         class="w-100 d-flex flex-column align-items-center justify-content-end overflow-hidden" 
         style="background: inherit; z-index: 5;" 
         :style="`height: ${pullDistance}px; opacity: ${pullDistance / pullThreshold}; transition: ${isPulling ? 'none' : 'height 0.3s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.3s'}`">
        <div class="rounded-circle d-flex align-items-center justify-content-center mb-2 flex-shrink-0" 
             :style="isArchiveReady ? 'background: #ff8c00; transform: scale(1.1); transition: all 0.2s;' : 'background: rgba(255,255,255,0.08); transition: all 0.2s;'"
             style="width: 36px; height: 36px;">
             <svg width="18" height="18" viewBox="0 0 24 24" fill="none" :stroke="isArchiveReady ? '#000' : '#fff'" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                 <polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line>
             </svg>
        </div>
        <span class="fw-bold flex-shrink-0" style="font-size: 0.72rem; letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 0.8rem;" 
              :style="isArchiveReady ? 'color: #ff8c00;' : 'color: rgba(255,255,255,0.4);'" 
              x-text="isArchiveReady ? 'Release to reveal archive' : (pullDistance >= pullThreshold ? 'Hold...' : 'Pull down to reveal')"></span>
    </div>

    

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$showArchived && count($archivedConversations) > 0): ?>
        <a href="<?php echo e(route('chat.index') . '?showArchived=1'); ?>" wire:navigate
            :class="showArchiveButton ? 'd-flex' : 'd-none d-md-flex'"
            class="chat-row w-100 align-items-center px-3 py-2 text-start text-decoration-none"
            style="border: none; border-bottom: 1px solid rgba(255,255,255,0.05); cursor:pointer; background: transparent;">
            
            <div class="d-flex align-items-center justify-content-center flex-shrink-0" 
                 style="width: 52px; height: 52px; border-radius: 50%; background: linear-gradient(135deg, rgba(255,140,0,0.15), rgba(255,140,0,0.05)); border: 1px solid rgba(255,140,0,0.2);">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#ff8c00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg>
            </div>
            
            <div class="ms-3 flex-grow-1">
                <div class="fw-bold" style="color: var(--chat-list-text); font-size: 0.95rem;">Archived Chats</div>
                <div style="color: var(--chat-list-muted); font-size: 0.8rem;"><?php echo e(count($archivedConversations)); ?> conversations</div>
            </div>
        </a>
    <?php elseif($showArchived): ?>
        <a href="<?php echo e(route('chat.index')); ?>" wire:navigate
            class="chat-row w-100 d-flex align-items-center px-3 py-2 text-decoration-none"
            style="border-bottom: 1px solid rgba(255,255,255,0.05); cursor:pointer; background: transparent;">

            <div class="d-flex align-items-center justify-content-center flex-shrink-0"
                 style="width: 52px; height: 52px; border-radius: 50%; background: linear-gradient(135deg, rgba(255,140,0,0.15), rgba(255,140,0,0.05)); border: 1px solid rgba(255,140,0,0.2);">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#ff8c00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><polyline points="12 5 5 12 12 19"/></svg>
            </div>

            <div class="ms-3 flex-grow-1">
                <div class="fw-bold" style="color: var(--chat-list-text); font-size: 0.95rem;">Back to Active Chats</div>
                <div style="color: var(--chat-list-muted); font-size: 0.8rem;">Leave archive view</div>
            </div>
        </a>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <div class="list-group list-group-flush mt-2">
            <?php
            $displayConversations = $showArchived ? $archivedConversations : $conversations;
        ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $displayConversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <?php
                if ($user->is_admin) {
                    $announcementLogoPath = \App\Models\SiteSetting::get('chat_announcement_logo') ?: \App\Models\SiteSetting::get('logo');
                    $hasPhoto   = (bool) $announcementLogoPath;
                    $cover      = $announcementLogoPath ? asset('storage/'.$announcementLogoPath) : null;
                    $userName   = \App\Models\SiteSetting::get('site_name', 'Kenyan Baddies');
                    $initials   = 'KB';
                } else {
                    $hasPhoto   = $user->profile_photo || $user->photos->first();
                    $cover      = $user->profile_photo ? asset('storage/'.$user->profile_photo) : ($hasPhoto ? asset('storage/'.$user->photos->first()->path) : null);
                    $userName   = $user->name;
                    $initials   = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $userName), 0, 2));
                }
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
                $isPinned = in_array($user->id, $pinnedUserIds ?? []);
            ?>

            <div <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'chat-user-'.e($user->id).''; ?>wire:key="chat-user-<?php echo e($user->id); ?>"
                 class="position-relative chat-row-wrapper mb-1"
                 :class="{ 'chat-row-selected': isSelected(<?php echo e($user->id); ?>) }"
                 style="background: <?php echo e(($isActive || $isPinned) ? 'rgba(255,140,0,0.06)' : 'transparent'); ?>; border-left: 3px solid <?php echo e(($isActive || $isPinned) ? '#ff8c00' : 'transparent'); ?>; transition: background 0.2s; touch-action: manipulation; user-select: none; -webkit-user-select: none; -webkit-touch-callout: none;"
                 @touchstart.passive="startPress(<?php echo e($user->id); ?>, $event)"
                 @touchmove.passive="movePress($event)"
                 @touchend.passive="endPress()"
                 @touchcancel.passive="endPress()"
                 @mousedown="startPress(<?php echo e($user->id); ?>, $event)"
                 @mousemove="movePress($event)"
                 @mouseup="endPress()"
                 @mouseleave="endPress()"
                 @contextmenu.prevent>

                <a href="<?php echo e(route('chat.show', $user->id)); ?>"
                   class="chat-row text-decoration-none d-block w-100"
                   style="padding: 0.55rem 0.75rem; transition: background 0.08s ease-out, border-left-color 0.08s ease-out;"
                   @click="handleClick(<?php echo e($user->id); ?>, $event, '<?php echo e(route('chat.show', $user->id)); ?>')">
                    <div class="d-flex align-items-start gap-3">

                        
                        <div class="position-relative flex-shrink-0">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasPhoto): ?>
                                <div class="flex-shrink-0 d-flex align-items-center justify-content-center" style="width:52px; height:52px; border-radius:50%; border: 2px solid <?php echo e($online ? '#ff8c00' : 'rgba(255,255,255,0.15)'); ?>; padding:2px; box-shadow: <?php echo e($online ? '0 0 8px rgba(255,140,0,0.5)' : 'none'); ?>;">
                                    <img src="<?php echo e($cover); ?>" alt="<?php echo e($user->name); ?>" class="rounded-circle w-100 h-100" style="object-fit: cover;">
                                </div>
                            <?php else: ?>
                                <div class="flex-shrink-0 d-flex align-items-center justify-content-center" style="width:52px; height:52px; border-radius:50%; border: 2px solid <?php echo e($online ? '#ff8c00' : 'rgba(255,140,0,0.3)'); ?>; padding:2px; box-shadow: <?php echo e($online ? '0 0 8px rgba(255,140,0,0.5)' : 'none'); ?>;">
                                    <div class="rounded-circle w-100 h-100 d-flex justify-content-center align-items-center text-white fw-bold" style="font-size: 1.1rem; background: linear-gradient(135deg, rgba(255,140,0,0.25), rgba(255,140,0,0.1));">
                                        <?php echo e($initials ?: 'U'); ?>

                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>



                            
                            <div class="chat-check-badge"
                                 x-data="{ wasSelected: false }"
                                 x-effect="if (selectedChats.includes(<?php echo e($user->id); ?>)) wasSelected = true"
                                 :class="{
                                     'is-selected':   selectedChats.includes(<?php echo e($user->id); ?>),
                                     'is-deselected': wasSelected && !selectedChats.includes(<?php echo e($user->id); ?>)
                                 }">
                                <svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                        </div>

                        
                        <div class="flex-grow-1" style="min-width: 0;">
                            
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span style="font-size: 0.92rem; font-weight: 700; color: <?php echo e($unread > 0 ? 'var(--chat-list-unread)' : 'var(--chat-list-text)'); ?>; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: flex; align-items: center;">
                                    <?php echo e($userName); ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->is_admin): ?>
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="#0d6efd" stroke="#0d6efd" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ms-1"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01" stroke="#fff"></polyline></svg>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </span>
                                <span class="d-flex align-items-center gap-1">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isPinned): ?>
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="#ff8c00" stroke="#ff8c00" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="me-1" title="Pinned"><line x1="12" y1="17" x2="12" y2="22"></line><path d="M5 17h14l-1.5-6H6.5L5 17z"></path><path d="M9 11V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v7"></path></svg>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <span style="font-size: 0.62rem; color: <?php echo e($unread > 0 ? '#ff8c00' : 'var(--chat-list-muted-light)'); ?>; white-space: nowrap; font-weight: 600;">
                                        <?php echo e($timeAgo); ?>

                                    </span>
                                </span>
                            </div>

                            
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="font-size: 0.78rem; color: <?php echo e($unread > 0 ? 'var(--chat-list-text)' : 'var(--chat-list-muted)'); ?>; font-weight: <?php echo e($unread > 0 ? '600' : '400'); ?>; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; flex: 1; margin-right: 0.5rem;">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($lastMsg && $lastMsg->sender_id === auth()->id()): ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($lastMsg->is_read): ?>
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0d6efd" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 2px; margin-top: -2px;">
                                              <polyline points="22 7 12 17 8 13"></polyline>
                                              <polyline points="16 7 12 11"></polyline>
                                              <polyline points="6 15 2 11"></polyline>
                                            </svg>
                                        <?php elseif($user->isOnline()): ?>
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-50" style="margin-right: 2px; margin-top: -2px;">
                                              <polyline points="22 7 12 17 8 13"></polyline>
                                              <polyline points="16 7 12 11"></polyline>
                                              <polyline points="6 15 2 11"></polyline>
                                            </svg>
                                        <?php else: ?>
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-50" style="margin-right: 2px; margin-top: -2px;">
                                              <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php echo e($snippet); ?>

                                </span>
                                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($online): ?>
                                        <span style="font-size: 0.62rem; font-weight: 700; color: #ff8c00; letter-spacing: 0.03em;">Online</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($unread > 0): ?>
                                        <span style="min-width: 16px; height: 16px; background: #ff8c00; border-radius: 50px; font-size: 0.55rem; font-weight: 800; color: #000; display: flex; align-items: center; justify-content: center; padding: 0 4px;">
                                            <?php echo e($unread); ?>

                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>



            </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <div class="d-flex flex-column align-items-center justify-content-center px-4" style="min-height: 260px; text-align: center;">

                
                <div style="width: 72px; height: 72px; border-radius: 50%; background: linear-gradient(135deg, rgba(255,140,0,0.18), rgba(255,140,0,0.05)); border: 1.5px solid rgba(255,140,0,0.25); box-shadow: 0 0 24px rgba(255,140,0,0.12); display: flex; align-items: center; justify-content: center; margin-bottom: 1.25rem;">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showArchived): ?>
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ff8c00" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" style="opacity:0.8;"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg>
                    <?php else: ?>
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ff8c00" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" style="opacity:0.8;"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <p style="font-size: 1rem; font-weight: 700; color: rgba(255,255,255,0.75); margin: 0 0 0.4rem; letter-spacing: 0.01em;">
                    <?php echo e($showArchived ? 'No archived chats' : 'No conversations yet'); ?>

                </p>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$showArchived): ?>
                    <p style="font-size: 0.8rem; color: rgba(255,255,255,0.35); margin: 0; line-height: 1.6; max-width: 200px;">
                        Head to a member's profile and tap <strong style="color: rgba(255,140,0,0.7);">Message</strong> to start chatting.
                    </p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$showArchived && count($archivedConversations) > 0): ?>
                    <a href="<?php echo e(route('chat.index') . '?showArchived=1'); ?>" wire:navigate
                       class="d-flex align-items-center gap-2 text-decoration-none mt-4"
                       style="padding: 0.55rem 1.2rem; border-radius: 50px; background: rgba(255,140,0,0.1); border: 1px solid rgba(255,140,0,0.28); color: #ff8c00; font-size: 0.82rem; font-weight: 600; letter-spacing: 0.02em; transition: background 0.2s, box-shadow 0.2s; box-shadow: 0 2px 12px rgba(255,140,0,0.08);"
                       onmouseenter="this.style.background='rgba(255,140,0,0.2)'; this.style.boxShadow='0 4px 18px rgba(255,140,0,0.2)'"
                       onmouseleave="this.style.background='rgba(255,140,0,0.1)'; this.style.boxShadow='0 2px 12px rgba(255,140,0,0.08)'">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ff8c00" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg>
                        <?php echo e(count($archivedConversations)); ?> Archived <?php echo e(count($archivedConversations) === 1 ? 'Chat' : 'Chats'); ?>

                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
    <style>
        /* ── Desktop / Mouse: real hover that fades in fast, disappears instantly on leave ── */
        @media (hover: hover) and (pointer: fine) {
            .chat-row {
                transition: none !important;
            }
            .chat-row:hover {
                background: rgba(255,140,0,0.08) !important;
                border-left-color: rgba(255,140,0,0.5) !important;
                transition: background 0.08s ease-out, border-left-color 0.08s ease-out !important;
            }
            .chat-row-wrapper:hover .chat-row {
                background: rgba(255,140,0,0.08) !important;
            }
            .chat-action-btn {
                transition: none !important;
            }
            .chat-action-btn:hover {
                color: #ff8c00 !important;
                opacity: 1 !important;
                background: rgba(255,140,0,0.18) !important;
                transition: color 0.08s ease-out, background 0.08s ease-out !important;
            }
        }

        /* ── Mobile / Touch: :active fires on press and clears the INSTANT finger lifts ── */
        @media (hover: none) {
            .chat-row:active {
                background: rgba(255,140,0,0.10) !important;
                border-left-color: rgba(255,140,0,0.5) !important;
            }
            .chat-action-btn:active {
                color: #ff8c00 !important;
                background: rgba(255,140,0,0.18) !important;
            }
        }

        .chat-row-selected {
            background: rgba(255,140,0,0.12) !important;
        }
    </style>

    <script>
    
    
    </script>
</div>
<?php /**PATH C:\Users\willi\Desktop\Kenyan Baddies Club\resources\views/livewire/chat/chat-list.blade.php ENDPATH**/ ?>