<div class="chat-box d-flex flex-column bg-dark position-relative" style="height: 75vh;"
     @keydown.window.escape="clear()"
     x-data="{ 
        selectedIds: [],
        pressTimer: null,
        isLongPress: false,
        showDeleteModal: false,
        canDeleteForEveryone: false,
        replyData: null,
        lightboxImage: null,
        openLightbox(imgUrl) {
            this.lightboxImage = imgUrl;
        },
        closeLightbox() {
            this.lightboxImage = null;
        },
        get canReply() {
            if (this.selectedIds.length !== 1) return false;
            const bubble = document.querySelector(`.msg-bubble[data-msg-id='${this.selectedIds[0]}']`);
            return bubble && bubble.getAttribute('data-is-deleted') !== '1';
        },
        init() {
            if (window.Livewire) {
                Livewire.on('messageSent', () => {
                    this.replyData = null;
                });
            }
        },
        startPress(id) {
            this.isLongPress = false;
            if (this.pressTimer) clearTimeout(this.pressTimer);
            this.pressTimer = setTimeout(() => {
                this.isLongPress = true;
                if (!this.selectedIds.includes(id)) {
                    this.selectedIds.push(id);
                    if (navigator.vibrate) navigator.vibrate(40);
                }
            }, 400);
        },
        endPress() {
            if (this.pressTimer) {
                clearTimeout(this.pressTimer);
                this.pressTimer = null;
            }
        },
        cancelPress() {
            if (this.pressTimer) {
                clearTimeout(this.pressTimer);
                this.pressTimer = null;
            }
        },
        handleClick(id, e) {
            if (this.isLongPress) {
                e.preventDefault();
                e.stopPropagation();
                this.isLongPress = false;
                return;
            }
            if (this.selectedIds.length > 0) {
                e.preventDefault();
                e.stopPropagation();
                let idx = this.selectedIds.indexOf(id);
                if (idx > -1) {
                    this.selectedIds.splice(idx, 1);
                } else {
                    this.selectedIds.push(id);
                }
            }
        },
        clear() {
            this.selectedIds = [];
            this.showDeleteModal = false;
        },
        reply() {
            if (this.selectedIds.length === 1) {
                const id = this.selectedIds[0];
                const bubble = document.querySelector(`.msg-bubble[data-msg-id='${id}']`);
                if (bubble) {
                    const textEl = bubble.querySelector('.msg-body-text');
                    const senderId = bubble.getAttribute('data-sender-id');
                    const isMe = senderId == <?php echo e(auth()->id()); ?>;
                    
                    this.replyData = {
                        id: id,
                        name: isMe ? 'Yourself' : '<?php echo e($activeUser ? addslashes($activeUser->name) : 'User'); ?>',
                        text: textEl ? textEl.innerText.trim() : 'Message'
                    };
                    
                    const el = $el.closest('[wire\\:id]') || document.querySelector('.chat-box[wire\\:id]');
                    if (el && window.Livewire) {
                        Livewire.find(el.getAttribute('wire:id')).call('setReply', id);
                    }
                }
                this.clear();
            }
        },
        cancelReply() {
            this.replyData = null;
            const el = $el.closest('[wire\\:id]') || document.querySelector('.chat-box[wire\\:id]');
            if (el && window.Livewire) {
                Livewire.find(el.getAttribute('wire:id')).call('cancelReply');
            }
        },
        openDeleteModal() {
            if (this.selectedIds.length === 0) return;
            const currentUserId = <?php echo e(auth()->id()); ?>;
            const selectedBubbles = document.querySelectorAll('.msg-bubble');
            let allMine = true;
            this.selectedIds.forEach(id => {
                const el = Array.from(selectedBubbles).find(b => b.getAttribute('data-msg-id') == id);
                if (el && el.getAttribute('data-sender-id') != currentUserId) {
                    allMine = false;
                }
            });
            this.canDeleteForEveryone = allMine;
            this.showDeleteModal = true;
        },
        confirmDeleteForEveryone() {
            if (this.selectedIds.length > 0) {
                const ids = [...this.selectedIds];
                const el = $el.closest('[wire\\:id]') || document.querySelector('.chat-box[wire\\:id]');
                if (el && window.Livewire) {
                    Livewire.find(el.getAttribute('wire:id')).call('deleteMessagesForEveryone', ids);
                }
                this.clear();
            }
            this.showDeleteModal = false;
        },
        confirmDeleteForMe() {
            if (this.selectedIds.length > 0) {
                const ids = [...this.selectedIds];
                const el = $el.closest('[wire\\:id]') || document.querySelector('.chat-box[wire\\:id]');
                if (el && window.Livewire) {
                    Livewire.find(el.getAttribute('wire:id')).call('deleteMessagesForMe', ids);
                }
                this.clear();
            }
            this.showDeleteModal = false;
        }
    }">

    <style>
        [x-cloak] { display: none !important; }
        .chat-modal-overlay {
            display: none !important;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 99999;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(5px);
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .chat-modal-overlay.active {
            display: flex !important;
        }
        .msg-bubble, #sel-cancel-btn, #sel-reply-btn, #sel-delete-btn {
            touch-action: manipulation;
            cursor: pointer;
            -webkit-tap-highlight-color: transparent;
        }
        #sel-cancel-btn:active, #sel-reply-btn:active, #sel-delete-btn:active {
            transform: scale(0.90) !important;
            transition: transform 0.05s ease !important;
        }
        .msg-bubble {
            transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease, opacity 0.15s ease;
        }
        .msg-bubble.selected-bubble {
            box-shadow: 0 0 0 3px #ff8c00, 0 4px 18px rgba(255,140,0,0.45) !important;
            transform: scale(1.02);
        }
        .chat-box {
            --chat-bg: #efeae2;
            --bubble-sent-bg: #e2ffc7;
            --bubble-received-bg: #ffffff;
            --bubble-text: #1a1a1a;
            --bubble-meta: rgba(0,0,0,0.55);
            --date-bg: #ffffff;
            --date-text: rgba(0,0,0,0.6);
            --deleted-bg: rgba(240, 242, 245, 0.95);
            --deleted-text: #6c757d;
            --doodle-opacity: 0.08;
            --doodle-filter: none;
            --reply-bg: rgba(0,0,0,0.04);
            --header-text: #111111;
            --header-subtext: rgba(0,0,0,0.6);
            --input-bg-color: #ffffff;
            --input-text-color: #111111;
            --input-placeholder-color: rgba(0,0,0,0.55);
            --btn-cancel-bg: rgba(0,0,0,0.06);
        }

        [data-bs-theme="dark"] .chat-box, .dark .chat-box {
            --chat-bg: #0b141a;
            --bubble-sent-bg: #005c4b;
            --bubble-received-bg: #202c33;
            --bubble-text: #e9edef;
            --bubble-meta: rgba(255,255,255,0.6);
            --date-bg: #182229;
            --date-text: rgba(255,255,255,0.6);
            --deleted-bg: rgba(32, 44, 51, 0.95);
            --deleted-text: #8696a0;
            --doodle-opacity: 0.05;
            --doodle-filter: invert(1);
            --reply-bg: rgba(255,255,255,0.05);
            --header-text: #ffffff;
            --header-subtext: rgba(255,255,255,0.4);
            --input-bg-color: rgba(255,255,255,0.07);
            --input-text-color: #ffffff;
            --input-placeholder-color: rgba(255,255,255,0.5);
            --btn-cancel-bg: rgba(255,255,255,0.12);
        }

        @media (max-width: 767.98px) {
            .chat-box {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                width: 100vw !important;
                height: 100dvh !important;
                z-index: 9999 !important;
                border-radius: 0 !important;
                margin: 0 !important;
            }
            body {
                overflow: hidden !important;
            }
        }
        .chat-bg-pattern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('https://user-images.githubusercontent.com/15075759/28719144-86dc0f70-73b1-11e7-911d-60d70fcded21.png');
            background-repeat: repeat;
            background-size: 350px;
            opacity: var(--doodle-opacity);
            filter: var(--doodle-filter);
            pointer-events: none;
            z-index: 0;
        }
        #chat-messages > * {
            position: relative;
            z-index: 1;
        }
        /* Custom scrollbar for chat */
        #chat-messages::-webkit-scrollbar {
            width: 6px;
        }
        #chat-messages::-webkit-scrollbar-track {
            background: transparent;
        }
        #chat-messages::-webkit-scrollbar-thumb {
            background: rgba(0,0,0,0.15);
            border-radius: 10px;
        }
        
        .chat-input-field::placeholder {
            color: var(--input-placeholder-color) !important;
            opacity: 1;
        }
        .chat-input-field {
            color: var(--input-text-color) !important;
            background-color: var(--input-bg-color) !important;
        }
    </style>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeUser || $activeUserId === 'announcement'): ?>
        <!-- Header -->
        <div class="position-relative flex-shrink-0" style="height: 62px; min-height: 62px; max-height: 62px; overflow: hidden; border-bottom: 1px solid rgba(255,140,0,0.25); background: linear-gradient(135deg, rgba(255,140,0,0.15) 0%, rgba(255,140,0,0.05) 100%);">
            
            
            <div id="chat-std-header" :class="selectedIds.length === 0 ? 'd-flex' : 'd-none'" class="d-flex align-items-center px-3 py-2 h-100 w-100">
                
                
                <a href="<?php echo e(route('chat.index')); ?>" class="text-decoration-none me-2 d-flex align-items-center justify-content-center flex-shrink-0" title="Back"
                   style="width: 34px; height: 34px; border-radius: 50%; color: #ff8c00;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                </a>



                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeUserId === 'announcement'): ?>
                    <?php
                        $announcementLogoPath = \App\Models\SiteSetting::get('chat_announcement_logo') ?: \App\Models\SiteSetting::get('logo');
                        $announcementLogo = $announcementLogoPath ? asset('storage/'.$announcementLogoPath) : null;
                    ?>
                    <div class="text-decoration-none d-block flex-shrink-0">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($announcementLogo): ?>
                            <div class="d-flex align-items-center justify-content-center bg-dark" style="width:44px; height:44px; border-radius:50%; border: 2px solid #ff8c00; padding:2px; box-shadow: 0 0 8px rgba(255,140,0,0.5);">
                                <img src="<?php echo e($announcementLogo); ?>" alt="Kenyan Baddies" class="rounded-circle w-100 h-100" style="object-fit: contain;">
                            </div>
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center" style="width:44px; height:44px; border-radius:50%; border: 2px solid #ff8c00; padding:2px; box-shadow: 0 0 8px rgba(255,140,0,0.5);">
                                <div class="rounded-circle w-100 h-100 d-flex justify-content-center align-items-center text-white fw-bold" style="font-size: 1rem; background: linear-gradient(135deg, rgba(255,140,0,0.4), rgba(255,140,0,0.2));">
                                    KB
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php else: ?>
                    <?php
                        $hasPhoto = $activeUser->profile_photo || $activeUser->photos->first();
                        $cover = $activeUser->profile_photo ? asset('storage/'.$activeUser->profile_photo) : ($hasPhoto ? asset('storage/'.$activeUser->photos->first()->path) : null);
                        $initials = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $activeUser->name), 0, 2));
                    ?>
                    <a href="<?php echo e(route('profile.view', $activeUser->id)); ?>" class="text-decoration-none d-block flex-shrink-0">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasPhoto): ?>
                            <div class="d-flex align-items-center justify-content-center" style="width:44px; height:44px; border-radius:50%; border: 2px solid <?php echo e($activeUser->isOnline() ? '#ff8c00' : 'rgba(255,140,0,0.3)'); ?>; padding:2px; box-shadow: <?php echo e($activeUser->isOnline() ? '0 0 8px rgba(255,140,0,0.5)' : 'none'); ?>;">
                                <img src="<?php echo e($cover); ?>" alt="<?php echo e($activeUser->name); ?>" class="rounded-circle w-100 h-100" style="object-fit: cover;">
                            </div>
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center" style="width:44px; height:44px; border-radius:50%; border: 2px solid <?php echo e($activeUser->isOnline() ? '#ff8c00' : 'rgba(255,140,0,0.3)'); ?>; padding:2px; box-shadow: <?php echo e($activeUser->isOnline() ? '0 0 8px rgba(255,140,0,0.5)' : 'none'); ?>;">
                                <div class="rounded-circle w-100 h-100 d-flex justify-content-center align-items-center text-white fw-bold" style="font-size: 1rem; background: linear-gradient(135deg, rgba(255,140,0,0.4), rgba(255,140,0,0.2));">
                                    <?php echo e($initials ?: 'U'); ?>

                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <div class="ms-3 flex-grow-1" style="min-width: 0;">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeUserId === 'announcement'): ?>
                        <div class="fw-bold text-white d-flex align-items-center gap-1" style="font-size: 0.95rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            Kenyan Baddies
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="#0d6efd" stroke="#0d6efd" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ms-1"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01" stroke="#fff"></polyline></svg>
                        </div>
                        <small style="color: #ff8c00; font-size: 0.7rem; font-weight: 600;">System Message</small>
                    <?php else: ?>
                        <a href="<?php echo e(route('profile.view', $activeUser->id)); ?>" class="text-decoration-none">
                            <div class="fw-bold text-white" style="font-size: 0.95rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo e($activeUser->name); ?></div>
                        </a>
                        <?php
                            $chatSettings = \App\Models\Setting::getSettings();
                            $showStatusInChat = $activeUser->show_online_status_in_chat ?? $chatSettings->show_online_status_in_chat;
                        ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showStatusInChat): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeUser->isOnline()): ?>
                                <small style="color: #ff8c00; font-size: 0.7rem; font-weight: 600;">Online</small>
                            <?php elseif($activeUser->last_seen_at): ?>
                                <small style="color: rgba(255,255,255,0.5); font-size: 0.7rem;">Last seen <?php echo e($activeUser->last_seen_at->diffForHumans()); ?></small>
                            <?php else: ?>
                                <small style="color: rgba(255,255,255,0.4); font-size: 0.7rem;">Offline</small>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeUser && $activeUser->phone_number): ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeUser->calls_enabled ?? true): ?>
                        <a href="tel:<?php echo e($activeUser->phone_number); ?>" class="flex-shrink-0 d-flex align-items-center justify-content-center text-decoration-none ms-2" title="Call <?php echo e($activeUser->name); ?>"
                           style="width: 38px; height: 38px; border-radius: 50%; background: rgba(255,140,0,0.15); border: 1px solid rgba(255,140,0,0.4); color: #ff8c00; transition: all 0.2s; box-shadow: 0 0 10px rgba(255,140,0,0.2);">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="transform: rotate(270deg);">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12.34a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.62h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.22a16 16 0 0 0 6.29 6.29l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                        </a>
                    <?php else: ?>
                        <button type="button" class="flex-shrink-0 d-flex align-items-center justify-content-center border-0 ms-2" title="Call <?php echo e($activeUser->name); ?>"
                           style="width: 38px; height: 38px; border-radius: 50%; background: rgba(255,140,0,0.15); border: 1px solid rgba(255,140,0,0.4) !important; color: #ff8c00; transition: all 0.2s; box-shadow: 0 0 10px rgba(255,140,0,0.2); padding: 0;"
                           onclick="showCallsDisabledToast()">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="transform: rotate(270deg);">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12.34a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.62h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.22a16 16 0 0 0 6.29 6.29l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                        </button>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            
            <div id="chat-sel-header" x-cloak x-show="selectedIds.length > 0" :class="selectedIds.length > 0 ? 'd-flex' : 'd-none'"
                 class="align-items-center justify-content-between position-absolute top-0 start-0 w-100 h-100 px-3"
                 style="z-index: 50; background: linear-gradient(135deg, rgba(255,140,0,0.15) 0%, rgba(255,140,0,0.05) 100%);">
                <div class="d-flex align-items-center gap-3">
                    <button type="button" @touchstart.prevent.stop="clear()" @click.prevent.stop="clear()" id="sel-cancel-btn" class="btn p-0 d-flex align-items-center justify-content-center text-white" style="width:36px;height:36px;border-radius:50%;background:var(--btn-cancel-bg);touch-action:manipulation;cursor:pointer;" title="Cancel">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="pointer-events:none;"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                    <span id="sel-count" class="fw-bold fs-5 text-white" x-text="selectedIds.length">0</span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <button type="button" x-show="canReply" :class="canReply ? 'd-flex' : 'd-none'" @touchstart.prevent.stop="reply()" @click.prevent.stop="reply()" id="sel-reply-btn" class="btn p-0 align-items-center justify-content-center" title="Reply" style="width:38px;height:38px;border-radius:50%;background:rgba(255,140,0,0.2);border:1px solid rgba(255,140,0,0.5);touch-action:manipulation;cursor:pointer;">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#ff8c00" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="pointer-events:none;"><polyline points="9 17 4 12 9 7"></polyline><path d="M20 18v-2a4 4 0 0 0-4-4H4"></path></svg>
                    </button>
                    <button type="button" @touchstart.prevent.stop="openDeleteModal()" @click.prevent.stop="openDeleteModal()" id="sel-delete-btn" class="btn p-0 d-flex align-items-center justify-content-center" title="Delete" style="width:38px;height:38px;border-radius:50%;background:rgba(220,53,69,0.2);border:1px solid rgba(220,53,69,0.5);touch-action:manipulation;cursor:pointer;">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#dc3545" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="pointer-events:none;"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Messages Body -->
        <div class="flex-grow-1 p-3 position-relative" id="chat-messages" wire:poll.3s style="background-color: var(--chat-bg); overflow-x: hidden; overflow-y: auto;">
            <!-- WhatsApp Doodle Background Pattern -->
            <div class="chat-bg-pattern"></div>
            
            <!-- End-to-End Encryption Notice -->
            <div class="d-flex justify-content-center mb-4 mt-2">
                <div class="text-center px-3 py-2" style="background: rgba(255,140,0,0.15); border: 1px solid rgba(255,140,0,0.25); border-radius: 8px; max-width: 90%;">
                    <div class="d-flex align-items-center justify-content-center gap-2 mb-1" style="color: var(--bubble-text); font-size: 0.75rem; font-weight: 700;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #d97700;"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        Messages and calls are end-to-end encrypted.
                    </div>
                    <div style="color: var(--bubble-meta); font-size: 0.7rem; line-height: 1.3; font-weight: 500;">
                        Only people in this chat can read, listen to, or share them.
                    </div>
                </div>
            </div>

            <?php $lastDate = null; ?>



            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php
                    $msgDateObj = $message->created_at;
                    if ($msgDateObj->isToday()) {
                        $dateString = 'Today';
                    } elseif ($msgDateObj->isYesterday()) {
                        $dateString = 'Yesterday';
                    } else {
                        $dateString = $msgDateObj->format('d/m/Y');
                    }
                ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($lastDate !== $dateString): ?>
                    <div class="d-flex justify-content-center my-3 position-sticky" style="top: 12px; z-index: 5;">
                        <div class="px-3 py-1 shadow-sm rounded-pill" style="background-color: var(--date-bg); color: var(--date-text); font-size: 0.72rem; font-weight: 600; border: 1px solid rgba(0,0,0,0.05); backdrop-filter: blur(4px);">
                            <?php echo e($dateString); ?>

                        </div>
                    </div>
                    <?php $lastDate = $dateString; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php
                    $isSender = $message->sender_id === auth()->id();
                    $bgStyle = '';
                    $borderStyle = '';
                    if ($message->is_deleted) {
                        $bgStyle = 'var(--deleted-bg)';
                        $borderStyle = '1px solid rgba(0,0,0,0.08)';
                    } elseif ($message->image_path) {
                        $bgStyle = 'transparent';
                        $borderStyle = '2px solid ' . ($isSender ? '#ff8c00' : 'var(--bubble-received-bg)');
                    } else {
                        $bgStyle = $isSender ? 'var(--bubble-sent-bg)' : 'var(--bubble-received-bg)';
                        $borderStyle = 'none';
                    }
                ?>
                <div class="d-flex w-100 mb-3 align-items-center position-relative message-wrapper <?php echo e($isSender ? 'justify-content-end' : 'justify-content-start'); ?>" data-msg-id="<?php echo e($message->id); ?>">
                    
                    <div class="px-2 py-2 shadow-sm position-relative msg-bubble" 
                         :class="{ 'selected-bubble': selectedIds.includes(<?php echo e($message->id); ?>) }"
                         @touchstart="startPress(<?php echo e($message->id); ?>)"
                         @touchend="endPress()"
                         @touchmove="cancelPress()"
                         @mousedown="startPress(<?php echo e($message->id); ?>)"
                         @mouseup="endPress()"
                         @mouseleave="cancelPress()"
                         @click="handleClick(<?php echo e($message->id); ?>, $event)"
                         data-msg-id="<?php echo e($message->id); ?>"
                         data-sender-id="<?php echo e($message->sender_id); ?>"
                         data-is-deleted="<?php echo e($message->is_deleted ? '1' : '0'); ?>"
                         style="max-width: 75%; border-radius: 12px; cursor: pointer; user-select: none; touch-action: pan-y; background-color: <?php echo e($bgStyle); ?>; border: <?php echo e($borderStyle); ?>; <?php echo e($isSender ? 'border-top-right-radius: 0px;' : 'border-top-left-radius: 0px;'); ?>">
                        
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$message->is_deleted): ?>
                            <div class="reply-swipe-icon position-absolute d-flex align-items-center justify-content-center text-warning opacity-0" 
                                 style="width: 30px; height: 30px; border-radius: 50%; background: rgba(255,140,0,0.2); transition: opacity 0.15s ease, transform 0.15s ease; transform: scale(0.5); flex-shrink: 0; pointer-events: none; top: 50%; transform: translateY(-50%) scale(0.5); <?php echo e($message->sender_id === auth()->id() ? 'left: -38px;' : 'right: -38px;'); ?>">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#d97700" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 17 4 12 9 7"></polyline><path d="M20 18v-2a4 4 0 0 0-4-4H4"></path></svg>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($message->replyTo && !$message->is_deleted): ?>
                            <div class="mb-2 p-2 rounded" style="background-color: var(--reply-bg); border-left: 4px solid <?php echo e($message->sender_id === auth()->id() ? 'var(--reply-border-me)' : 'var(--reply-border-other)'); ?>; font-size: 0.8rem;">
                                <div class="fw-bold mb-1" style="color: <?php echo e($message->sender_id === auth()->id() ? 'var(--reply-border-me)' : 'var(--reply-border-other)'); ?>;"><?php echo e($message->replyTo->sender_id === auth()->id() ? 'You' : ($message->replyTo->sender ? $message->replyTo->sender->name : 'User')); ?></div>
                                <div class="text-truncate <?php echo e($message->replyTo->is_deleted ? 'fst-italic opacity-50' : ''); ?>" style="opacity: 0.75; color: var(--bubble-text);">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($message->replyTo->is_deleted): ?>
                                        This message was deleted
                                    <?php elseif($message->replyTo->image_path): ?>
                                        📷 Photo <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($message->replyTo->body): ?> - <?php echo e($message->replyTo->body); ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php else: ?>
                                        <?php echo e($message->replyTo->body); ?>

                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($message->is_deleted): ?>
                            <div class="d-flex align-items-center justify-content-between gap-3 text-secondary fst-italic py-0.5" style="font-size: 0.82rem; color: var(--deleted-text) !important;">
                                <div class="d-flex align-items-center gap-2">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line>
                                    </svg>
                                    <span style="font-weight: 450; white-space: nowrap;">This message was deleted</span>
                                </div>
                                <span class="fst-normal" style="font-size: 0.64rem; white-space: nowrap; flex-shrink: 0; margin-left: 6px; color: var(--bubble-meta);">
                                    <?php echo e($message->created_at->format('g:i A')); ?>

                                </span>
                            </div>
                        <?php else: ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($message->image_path): ?>
                                <div class="mb-1 text-center" 
                                     @click.stop="openLightbox('<?php echo e(asset('storage/' . $message->image_path)); ?>')"
                                     @contextmenu.prevent
                                     style="-webkit-touch-callout: none; user-select: none; -webkit-user-select: none;">
                                    <img src="<?php echo e(asset('storage/' . $message->image_path)); ?>" 
                                         alt="Photo" 
                                         class="img-fluid rounded" 
                                         style="max-width: 260px; max-height: 300px; object-fit: cover; cursor: pointer; pointer-events: none; -webkit-user-drag: none;">
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($message->body): ?>
                                <div class="msg-body-text" style="font-size: 0.95rem; color: var(--bubble-text);"><?php echo e($message->body); ?></div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <div class="d-flex align-items-center mt-1 justify-content-end" style="font-size: 0.65rem; gap: 4px; color: var(--bubble-meta);">
                                <span><?php echo e($message->created_at->format('g:i A')); ?></span>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($message->sender_id === auth()->id()): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($message->is_read): ?>
                                        
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#0d6efd" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                          <polyline points="22 7 12 17 8 13"></polyline>
                                          <polyline points="16 7 12 11"></polyline>
                                          <polyline points="6 15 2 11"></polyline>
                                        </svg>
                                    <?php elseif($activeUser->isOnline()): ?>
                                        
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-50">
                                          <polyline points="22 7 12 17 8 13"></polyline>
                                          <polyline points="16 7 12 11"></polyline>
                                          <polyline points="6 15 2 11"></polyline>
                                        </svg>
                                    <?php else: ?>
                                        
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-50">
                                          <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeUserId !== 'announcement'): ?>
                    <div class="text-center text-muted mt-5">
                        Say hello to start the conversation!
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Instant Alpine Reply Preview -->
        <div x-cloak x-show="replyData" class="px-3 py-2 position-relative flex-shrink-0" style="background: var(--reply-preview-bg); border-top: 1px solid rgba(255,140,0,0.2); z-index: 10; margin-bottom: -1px;">
            <div class="p-2 rounded-3 d-flex justify-content-between align-items-center" style="background-color: var(--input-bg-color); border-left: 5px solid #ff8c00; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <div class="flex-grow-1" style="min-width: 0;">
                    <div class="fw-bold text-truncate" style="color: #ff8c00; font-size: 0.85rem; margin-bottom: 2px;" x-text="replyData ? replyData.name : ''"></div>
                    <div class="text-truncate" style="font-size: 0.8rem; opacity: 0.85; color: var(--bubble-text);" x-text="replyData ? replyData.text : ''"></div>
                </div>
                <button @click="cancelReply()" type="button" class="btn btn-link p-2 m-0 ms-2 flex-shrink-0 d-flex align-items-center justify-content-center" style="text-decoration: none; border-radius: 50%; background: var(--reply-bg); color: var(--bubble-meta); transition: background 0.2s;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($replyToId): ?>
            <!-- Fallback for Livewire reload if replyData wasn't initialized -->
            <div x-init="if(!replyData) { replyData = { id: <?php echo e($replyToId); ?>, name: 'User', text: '...' }; }"></div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeUserId !== 'announcement'): ?>


            <!-- Input Area -->
            <div class="px-3 py-2 flex-shrink-0" style="background: linear-gradient(135deg, rgba(255,140,0,0.12) 0%, rgba(255,140,0,0.04) 100%); border-top: 1px solid rgba(255,140,0,0.2);">
                <form wire:submit.prevent="sendMessage" class="d-flex align-items-center gap-2">
                    <!-- Attach Photo Area -->
                    <div class="position-relative flex-shrink-0" style="width: 42px; height: 42px;">
                        <label class="btn d-flex align-items-center justify-content-center m-0 position-absolute top-0 start-0 w-100 h-100 p-0"
                               style="border-radius: 50%; background: var(--input-bg-color); border: 1px solid rgba(255,140,0,0.3) !important; color: #ff8c00; cursor: pointer; transition: all 0.2s; overflow: hidden;"
                               title="Attach Photo">
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($photo): ?>
                                <img src="<?php echo e($photo->temporaryUrl()); ?>" class="w-100 h-100" style="object-fit: cover; border-radius: 50%;">
                            <?php else: ?>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
                                </svg>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <!-- Loader while uploading -->
                            <div wire:loading.flex wire:target="photo" class="position-absolute align-items-center justify-content-center w-100 h-100" style="background: rgba(0,0,0,0.5); border-radius: 50%; top: 0; left: 0; z-index: 10;">
                                <div class="spinner-border text-light" role="status" style="width: 1rem; height: 1rem; border-width: 0.15em;"></div>
                            </div>
                            <input type="file" wire:model="photo" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" class="d-none">
                        </label>
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($photo): ?>
                            <!-- Remove Photo Button -->
                            <button type="button" wire:click="removePhoto" class="btn btn-sm btn-danger position-absolute d-flex align-items-center justify-content-center shadow" style="width: 16px; height: 16px; padding: 0; border-radius: 50%; top: -2px; right: -2px; z-index: 15;">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <input type="text" wire:model="body"
                        class="form-control border-0 chat-input-field shadow-none flex-grow-1"
                        placeholder="<?php echo e($photo ? 'Add a caption...' : 'Type a message...'); ?>"
                        style="border-radius: 24px; padding: 0.5rem 1rem; font-size: 0.95rem; outline: none; border: 1px solid rgba(255,140,0,0.2) !important;">
                    <button type="submit"
                        class="btn d-flex align-items-center justify-content-center flex-shrink-0 position-relative"
                        style="width: 42px; height: 42px; border-radius: 50%; background: linear-gradient(135deg, #ff8c00, #ff6b00); border: none; box-shadow: 0 2px 10px rgba(255,140,0,0.4); padding: 0;"
                        wire:loading.attr="disabled"
                        wire:target="photo">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($photo): ?>
                            <span class="position-absolute d-flex align-items-center justify-content-center fw-bold shadow" style="width: 18px; height: 18px; font-size: 0.7rem; background: #dc3545; color: white; border-radius: 50%; top: -3px; right: -3px; z-index: 10;">
                                1
                            </span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </button>
                </form>
            </div>
        <?php else: ?>
            <!-- Announcement Footer (No Input) -->
            <div class="px-3 py-3 flex-shrink-0 text-center" style="background: linear-gradient(135deg, rgba(255,140,0,0.12) 0%, rgba(255,140,0,0.04) 100%); border-top: 1px solid rgba(255,140,0,0.2);">
                <small class="text-muted fw-bold">This is a system announcement. Replies are disabled.</small>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <script>
            // ── Toast config: re-runs each poll (reads PHP values) ───────────
            <?php
                $gSettings = \App\Models\Setting::getSettings();
                $tEnabled  = $activeUser?->online_toast_enabled ?? $gSettings->online_toast_enabled;
                $tMessage  = $activeUser?->online_toast_message ?: ($gSettings->online_toast_message ?? '💚 {name} is now online!');
                $tDuration = $activeUser?->online_toast_duration ?: ($gSettings->online_toast_duration ?? 4000);
                $tPosition = $activeUser?->online_toast_position ?: ($gSettings->online_toast_position ?? 'bottom-right');
                $tSound    = $activeUser?->online_toast_sound ?: ($gSettings->online_toast_sound ?? 'none');
            ?>
            window.chatToastConfig = {
                enabled:  <?php echo e($tEnabled ? 'true' : 'false'); ?>,
                message:  <?php echo json_encode($tMessage, 15, 512) ?>,
                duration: <?php echo e($tDuration); ?>,
                position: <?php echo json_encode($tPosition, 15, 512) ?>,
                sound:    <?php echo json_encode($tSound, 15, 512) ?>,
            };

            function scrollToBottom() { const el = document.getElementById('chat-messages'); if (el) el.scrollTop = el.scrollHeight; }
            document.addEventListener('livewire:initialized', () => {
                scrollToBottom();
                Livewire.on('messageSent', () => setTimeout(scrollToBottom, 50));
            });
            document.addEventListener('DOMContentLoaded', scrollToBottom);
            document.addEventListener('livewire:navigated', scrollToBottom);
        </script>

    <!-- WhatsApp-Style Delete Popup Modal -->
    <div x-cloak x-show="showDeleteModal" :class="showDeleteModal ? 'd-flex' : 'd-none'"
         @keydown.window.escape="showDeleteModal = false"
         class="position-fixed top-0 start-0 w-100 h-100 align-items-center justify-content-center p-3"
         style="z-index: 99999; background: rgba(0, 0, 0, 0.75); backdrop-filter: blur(5px);">
        <div @click.outside="showDeleteModal = false" 
             class="bg-dark text-white p-4 shadow-lg"
             style="width: 100%; max-width: 350px; border-radius: 18px; background: linear-gradient(145deg, #1f2937, #111827) !important; border: 1px solid rgba(255,140,0,0.35) !important;">
            <h6 class="fw-bold mb-3 text-white" style="font-size: 1.05rem;" x-text="selectedIds.length > 1 ? 'Delete ' + selectedIds.length + ' messages?' : 'Delete message?'">
                Delete message?
            </h6>
            
            <div class="d-flex flex-column gap-2 mt-3">
                <template x-if="canDeleteForEveryone">
                    <button type="button" 
                            @click="confirmDeleteForEveryone()"
                            class="btn w-100 text-start d-flex align-items-center justify-content-between py-2.5 px-3 rounded-3 text-danger border-danger"
                            style="background: rgba(220,53,69,0.12); border: 1px solid rgba(220,53,69,0.4); font-weight: 500;">
                        <span>Delete for Everyone</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    </button>
                </template>

                <button type="button" 
                        @click="confirmDeleteForMe()"
                        class="btn w-100 text-start d-flex align-items-center justify-content-between py-2.5 px-3 rounded-3 text-white"
                        style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.18); font-weight: 500;">
                    <span>Delete for Me</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                </button>

                <button type="button" 
                        @click="clear()"
                        class="btn btn-link text-warning text-decoration-none w-100 text-end pt-2 pb-0 pe-2 fw-semibold"
                        style="font-size: 0.92rem;">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <?php else: ?>
        <div class="d-flex flex-column h-100 justify-content-center align-items-center text-center p-4 position-relative" style="background: linear-gradient(135deg, rgba(255,140,0,0.05) 0%, rgba(0,0,0,0) 100%);">
            <div class="position-absolute w-100 h-100" style="top:0; left:0; background-image: url('https://user-images.githubusercontent.com/15075759/28719144-86dc0f70-73b1-11e7-911d-60d70fcded21.png'); background-repeat: repeat; background-size: 350px; opacity: 0.03; filter: invert(1); pointer-events: none;"></div>
            <div class="position-relative" style="z-index: 10;">
                <?php
                    $siteLogo = \App\Models\SiteSetting::get('logo');
                ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($siteLogo): ?>
                    <img src="<?php echo e(asset('storage/'.$siteLogo)); ?>" alt="Kenyan Baddies" class="mb-4" style="max-height: 80px; opacity: 0.9; filter: drop-shadow(0 0 15px rgba(255,140,0,0.25));">
                <?php else: ?>
                    <div class="mb-4 mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, rgba(255,140,0,0.2), rgba(255,140,0,0.05)); border: 2px solid rgba(255,140,0,0.3); box-shadow: 0 0 20px rgba(255,140,0,0.15);">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#ff8c00" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <h4 class="text-white fw-bold mb-2" style="letter-spacing: 0.02em;">Welcome to Your Messages</h4>
                <p class="text-muted mx-auto" style="max-width: 320px; font-size: 0.95rem; line-height: 1.5;">Select a conversation from the sidebar to start chatting, or browse profiles to find new connections.</p>
                <a href="<?php echo e(route('home')); ?>" class="btn mt-4 d-inline-flex align-items-center gap-2" style="background: rgba(255,140,0,0.15); color: #ff8c00; border: 1px solid rgba(255,140,0,0.3); border-radius: 6px; padding: 0.6rem 1.75rem; font-weight: 600; transition: all 0.2s;" onmouseover="this.style.background='rgba(255,140,0,0.25)'" onmouseout="this.style.background='rgba(255,140,0,0.15)'">
                    Browse Profiles
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                </a>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Image Lightbox Overlay -->
    <div x-cloak x-show="lightboxImage" 
         :class="lightboxImage ? 'd-flex' : 'd-none'"
         class="position-fixed top-0 start-0 w-100 h-100 align-items-center justify-content-center"
         style="z-index: 100000; background: rgba(0,0,0,0.9); backdrop-filter: blur(4px);"
         @keydown.window.escape="closeLightbox()">
        <!-- Lightbox Actions -->
        <div class="position-absolute top-0 end-0 m-3 d-flex align-items-center gap-2" style="z-index: 10;">
            <a :href="lightboxImage" download class="btn text-white d-flex align-items-center justify-content-center p-0" style="width:40px; height:40px; background: rgba(255,255,255,0.1); border-radius: 50%; border: none; backdrop-filter: blur(4px);" title="Download">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
            </a>

            <button type="button" @click="closeLightbox()" class="btn text-white d-flex align-items-center justify-content-center p-0" style="width:40px; height:40px; background: rgba(255,255,255,0.1); border-radius: 50%; border: none; backdrop-filter: blur(4px);" title="Close">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <img :src="lightboxImage" class="img-fluid" style="max-width: 90%; max-height: 90vh; object-fit: contain; box-shadow: 0 0 20px rgba(0,0,0,0.5);">
    </div>
</div>
<?php /**PATH C:\Users\willi\Desktop\Kenyan Baddies Club\resources\views/livewire/chat/chat-box.blade.php ENDPATH**/ ?>