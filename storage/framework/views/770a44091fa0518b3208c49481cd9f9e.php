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
</style>
<div class="chat-list border-end border-secondary position-relative" style="height: 75vh; overflow-y: auto;">
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

    
    <div x-transition.opacity 
         :class="selectedChats.length > 0 ? 'd-flex' : 'd-none'"
         class="position-absolute top-0 start-0 w-100 p-3 align-items-center justify-content-between" 
         style="display: none; z-index: 50; border-bottom: 1px solid rgba(255,255,255,0.1); height: 60px; background: #0d0d0d;">
         
         <div class="d-flex align-items-center gap-3">
             <button @click="selectedChats = []" class="btn text-white p-0 d-flex align-items-center justify-content-center">
                 <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
             </button>
             <span class="text-white fw-bold fs-5" x-text="selectedChats.length"></span>
         </div>
         <div class="d-flex align-items-center gap-4">
             <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$showArchived): ?>
             <button @click="archiveSelected" class="btn text-white p-0" title="Archive">
                 <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg>
             </button>
             <?php else: ?>
             <button @click="unarchiveSelected" class="btn text-white p-0" title="Unarchive">
                 <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 10 4 15 9 20"></polyline><path d="M20 4v7a4 4 0 0 1-4 4H4"></path></svg>
             </button>
             <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
             <button @click="deleteSelected" class="btn text-danger p-0" title="Delete">
                 <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
             </button>
         </div>
    </div>

    
    <div class="p-3 border-bottom border-secondary d-flex align-items-center gap-2">
        <div class="d-flex align-items-center gap-2 flex-grow-1">
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
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!auth()->user()->is_admin): ?>
        <?php
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
        ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($announcementActive && $latestAnnouncement): ?>
            <a href="<?php echo e(route('chat.show', 'announcement')); ?>" wire:navigate class="chat-row text-decoration-none d-block w-100 position-relative" style="border-bottom: 1px solid rgba(255,140,0,0.15); padding: 0.55rem 0.75rem; transition: all 0.2s ease;">
                <div class="d-flex align-items-start gap-3">
                    
                    <div class="position-relative flex-shrink-0">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($announcementLogo): ?>
                            <div class="d-flex align-items-center justify-content-center bg-dark" style="width:52px; height:52px; border-radius:50%; border: 2px solid #ff8c00; padding:2px; box-shadow: 0 0 10px rgba(255,140,0,0.4);">
                                <img src="<?php echo e($announcementLogo); ?>" alt="Kenyan Baddies" class="rounded-circle w-100 h-100" style="object-fit: contain;">
                            </div>
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center" style="width:52px; height:52px; border-radius:50%; border: 2px solid #ff8c00; box-shadow: 0 0 10px rgba(255,140,0,0.4); background: linear-gradient(135deg, rgba(255,140,0,0.3), rgba(255,140,0,0.1));">
                                <span class="fw-bold text-white">KB</span>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        
                        <div class="position-absolute align-items-center justify-content-center bg-primary rounded-circle d-flex" 
                             style="width: 20px; height: 20px; bottom: -2px; right: -2px; border: 2px solid #1a1a1a;">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path></svg>
                        </div>
                    </div>

                    
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
                        <div style="font-size: 0.85rem; color: var(--chat-list-text); line-height: 1.5;" class="d-flex justify-content-between align-items-center">
                            <div class="text-truncate" style="max-width: 80%;">
                                <?php echo nl2br(e($latestAnnouncement->body)); ?>

                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($unreadCount > 0): ?>
                                <span class="badge rounded-pill ms-2" style="background: #ff8c00; color: #000; font-size: 0.65rem; font-weight: 800;">
                                    <?php echo e($unreadCount); ?>

                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>
            </a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="list-group list-group-flush mt-2" wire:poll.10s>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$showArchived && count($archivedConversations) > 0): ?>
            <div class="position-relative chat-row-wrapper mb-2 mx-2" style="border-radius: 12px; border: 1px solid rgba(255,255,255,0.06); cursor: pointer;" wire:click="toggleArchived">
                <div class="chat-row text-decoration-none d-block w-100" style="padding: 0.5rem 1rem; transition: all 0.2s ease;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ff8c00" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg>
                            </div>
                            <div class="fw-bold" style="color: var(--chat-list-text); font-size: 0.9rem;">Archived</div>
                        </div>
                        <div class="text-muted fw-bold pe-2" style="font-size: 0.8rem;">
                            <?php echo e(count($archivedConversations)); ?>

                        </div>
                    </div>
                </div>
            </div>
        <?php elseif($showArchived): ?>
            <div class="position-relative chat-row-wrapper mb-2 mx-2" style="border-radius: 12px; border: 1px solid rgba(255,255,255,0.06); cursor: pointer;" wire:click="toggleArchived">
                <div class="chat-row text-decoration-none d-block w-100" style="padding: 0.5rem 1rem; transition: all 0.2s ease;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#4ade80" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                            </div>
                            <div class="fw-bold" style="color: var(--chat-list-text); font-size: 0.9rem;">Back to Active Chats</div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php
            $displayConversations = $showArchived ? $archivedConversations : $conversations;
        ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $displayConversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!auth()->user()->is_admin && $user->is_admin): ?>
                <?php continue; ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php
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
            ?>

            <div class="position-relative chat-row-wrapper mb-1" 
                 :class="{ 'bg-secondary bg-opacity-25': selectedChats.includes(<?php echo e($user->id); ?>) }"
                 style="background: <?php echo e($isActive ? 'rgba(255,140,0,0.08)' : 'transparent'); ?>; border-left: 3px solid <?php echo e($isActive ? '#ff8c00' : 'transparent'); ?>; transition: background 0.2s;">
                
                <a href="<?php echo e(route('chat.show', $user->id)); ?>" wire:navigate class="chat-row text-decoration-none d-block w-100" 
                   style="padding: 0.55rem 0.75rem; transition: all 0.2s ease; -webkit-touch-callout: none; user-select: none; -webkit-user-select: none; -webkit-user-drag: none;"
                   @contextmenu.prevent
                   @touchstart="startPress(<?php echo e($user->id); ?>)"
                   @touchend="endPress()"
                   @touchmove="endPress()"
                   @mousedown="startPress(<?php echo e($user->id); ?>)"
                   @mouseup="endPress()"
                   @mouseleave="endPress()"
                   @click="handleClick(<?php echo e($user->id); ?>, $event)">
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

                            
                            <div :class="selectedChats.includes(<?php echo e($user->id); ?>) ? 'd-flex' : 'd-none'" 
                                 class="position-absolute align-items-center justify-content-center bg-success rounded-circle" 
                                 style="display: none; width: 22px; height: 22px; bottom: -2px; right: -2px; z-index: 5; border: 2px solid #1a1a1a;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                        </div>

                        
                        <div class="flex-grow-1" style="min-width: 0;">
                            
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span style="font-size: 0.92rem; font-weight: 700; color: <?php echo e($unread > 0 ? 'var(--chat-list-unread)' : 'var(--chat-list-text)'); ?>; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <?php echo e($user->name); ?>

                                </span>
                                <span style="font-size: 0.62rem; color: <?php echo e($unread > 0 ? '#ff8c00' : 'var(--chat-list-muted-light)'); ?>; white-space: nowrap; margin-left: 0.5rem; font-weight: 600;">
                                    <?php echo e($timeAgo); ?>

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
            <div class="d-flex flex-column align-items-center justify-content-center py-5 px-3" style="color: rgba(255,255,255,0.3);">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem; opacity: 0.3;">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                <p class="mb-1 fw-bold" style="font-size: 0.95rem; color: rgba(255,255,255,0.5);"><?php echo e($showArchived ? 'No archived chats' : 'No conversations yet'); ?></p>
                <p class="mb-0" style="font-size: 0.78rem;"><?php echo e($showArchived ? '' : 'Start a chat from a member\'s profile!'); ?></p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <style>
        .chat-row:hover {
            background: rgba(255,140,0,0.06) !important;
            border-left-color: rgba(255,140,0,0.4) !important;
        }
    </style>
    </div>
</div>
<?php /**PATH C:\Users\willi\Desktop\Kenyan Baddies Club\resources\views\livewire\chat\chat-list.blade.php ENDPATH**/ ?>