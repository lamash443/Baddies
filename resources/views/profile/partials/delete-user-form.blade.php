<section class="dash-card" style="border-color: rgba(220,53,69,0.2);">
    <header>
        <h2 class="dash-card-title" style="color: #ff4d4d !important;">
            <svg style="display:inline; width:20px; height:20px; margin-right:0.4rem; vertical-align:-3px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
            </svg>
            {{ __('Delete Account') }}
        </h2>
        <p class="dash-card-text">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. This action cannot be undone.') }}</p>
    </header>

    <button type="button" class="btn-danger-custom mt-2" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/>
        </svg>
        {{ __('Request Account Deletion') }}
    </button>
</section>

<!-- ══ ACCOUNT DELETION MODAL ══ -->
<div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
        <div class="modal-content del-modal">
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <!-- Header -->
                <div class="del-modal__header">
                    <div class="del-modal__icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                            <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                        </svg>
                    </div>
                    <div class="del-modal__heading-wrap">
                        <h5 class="del-modal__title" id="confirmUserDeletionModalLabel">{{ __('Delete Account') }}</h5>
                        <p class="del-modal__sub">{{ __('This action requires admin approval') }}</p>
                    </div>
                    <button type="button" class="del-modal__close" data-bs-dismiss="modal" aria-label="Close">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                    </button>
                </div>

                <!-- What happens callout -->
                <div class="del-modal__body">
                    <div class="del-modal__info-box">
                        <div class="del-modal__info-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                        </div>
                        <div>
                            <p class="del-modal__info-title">What happens when you delete your account</p>
                            <ul class="del-modal__info-list">
                                <li>Your profile will be hidden from the public immediately.</li>
                                <li>You will be logged out of your account.</li>
                                <li>An admin will review and permanently delete your data.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="del-modal__field">
                        <label for="del_password" class="del-modal__label">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:5px; vertical-align:-2px;">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            {{ __('Confirm Your Password') }}
                        </label>
                        <input id="del_password" name="password" type="password" class="del-modal__input" placeholder="Enter your current password" autocomplete="current-password" />
                        @error('password', 'userDeletion')
                            <div class="del-modal__error">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Footer -->
                <div class="del-modal__footer">
                    <button type="button" class="del-modal__btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="del-modal__btn-delete">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                        </svg>
                        {{ __('Submit Deletion Request') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* ══ DELETE MODAL STYLES ══ */
.del-modal {
    background: #0d0d0d;
    border: 1px solid rgba(220, 53, 69, 0.35);
    border-radius: 20px;
    box-shadow: 0 30px 80px rgba(220, 53, 69, 0.15), 0 0 0 1px rgba(255,255,255,0.04);
    overflow: hidden;
    font-family: "Outfit", sans-serif;
}

/* Header */
.del-modal__header {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem 1.75rem 1.25rem;
    border-bottom: 1px solid rgba(255,255,255,0.07);
    position: relative;
}
.del-modal__icon {
    flex-shrink: 0;
    width: 48px; height: 48px;
    border-radius: 14px;
    background: rgba(220,53,69,0.1);
    border: 1px solid rgba(220,53,69,0.25);
    display: flex; align-items: center; justify-content: center;
    color: #ff4d4d;
}
.del-modal__heading-wrap { flex: 1; min-width: 0; }
.del-modal__title {
    font-size: 1.1rem;
    font-weight: 800;
    color: #ff4d4d;
    margin: 0 0 0.15rem;
    line-height: 1.2;
}
.del-modal__sub {
    font-size: 0.78rem;
    color: rgba(255,255,255,0.4);
    margin: 0;
    font-weight: 500;
    letter-spacing: 0.02em;
}
.del-modal__close {
    flex-shrink: 0;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 8px;
    width: 32px; height: 32px;
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,0.5);
    cursor: pointer;
    transition: all 0.2s ease;
    padding: 0;
}
.del-modal__close:hover { background: rgba(220,53,69,0.15); border-color: rgba(220,53,69,0.3); color: #ff4d4d; }

/* Body */
.del-modal__body { padding: 1.5rem 1.75rem; }

.del-modal__info-box {
    display: flex;
    gap: 0.85rem;
    background: rgba(220,53,69,0.05);
    border: 1px solid rgba(220,53,69,0.15);
    border-radius: 12px;
    padding: 1rem 1.1rem;
    margin-bottom: 1.25rem;
}
.del-modal__info-icon {
    flex-shrink: 0;
    color: #ff6b6b;
    margin-top: 2px;
}
.del-modal__info-title {
    font-size: 0.82rem;
    font-weight: 700;
    color: #ff6b6b;
    margin: 0 0 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.del-modal__info-list {
    list-style: none;
    padding: 0; margin: 0;
}
.del-modal__info-list li {
    font-size: 0.82rem;
    color: rgba(255,255,255,0.6);
    padding: 0.2rem 0;
    padding-left: 1.1rem;
    position: relative;
    line-height: 1.5;
}
.del-modal__info-list li::before {
    content: '›';
    position: absolute;
    left: 0;
    color: #ff4d4d;
    font-weight: 700;
}

/* Password Field */
.del-modal__field { margin-bottom: 0.25rem; }
.del-modal__label {
    display: block;
    font-size: 0.82rem;
    font-weight: 600;
    color: rgba(255,255,255,0.65);
    margin-bottom: 0.5rem;
}
.del-modal__input {
    width: 100%;
    background: rgba(255,255,255,0.04);
    border: 1.5px solid rgba(255,255,255,0.1);
    border-radius: 10px;
    color: #fff;
    padding: 0.7rem 1rem;
    font-size: 0.9rem;
    font-family: "Outfit", sans-serif;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
    outline: none;
}
.del-modal__input:focus {
    border-color: rgba(220,53,69,0.5);
    box-shadow: 0 0 0 3px rgba(220,53,69,0.1);
    background: rgba(255,255,255,0.06);
}
.del-modal__input::placeholder { color: rgba(255,255,255,0.25); }

.del-modal__error {
    display: flex;
    align-items: center;
    gap: 0.3rem;
    color: #ff4d4d;
    font-size: 0.8rem;
    margin-top: 0.45rem;
    font-weight: 500;
}

/* Footer */
.del-modal__footer {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1.1rem 1.75rem 1.5rem;
    border-top: 1px solid rgba(255,255,255,0.07);
}
.del-modal__btn-cancel {
    flex: 1;
    background: transparent;
    border: 1.5px solid rgba(255,255,255,0.15);
    color: rgba(255,255,255,0.65);
    border-radius: 10px;
    padding: 0.65rem 1.25rem;
    font-size: 0.88rem;
    font-weight: 600;
    font-family: "Outfit", sans-serif;
    cursor: pointer;
    transition: all 0.2s ease;
}
.del-modal__btn-cancel:hover {
    background: rgba(255,255,255,0.06);
    border-color: rgba(255,255,255,0.3);
    color: #fff;
}
.del-modal__btn-delete {
    flex: 1.5;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.45rem;
    background: linear-gradient(135deg, #dc3545, #c82333);
    border: none;
    color: #fff;
    border-radius: 10px;
    padding: 0.65rem 1.25rem;
    font-size: 0.88rem;
    font-weight: 700;
    font-family: "Outfit", sans-serif;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(220,53,69,0.3);
}
.del-modal__btn-delete:hover {
    background: linear-gradient(135deg, #e84055, #dc3545);
    box-shadow: 0 6px 20px rgba(220,53,69,0.45);
    transform: translateY(-1px);
}
.del-modal__btn-delete:active {
    transform: translateY(0);
    box-shadow: 0 2px 10px rgba(220,53,69,0.3);
}

/* Modal backdrop tint */
#confirmUserDeletionModal .modal-backdrop { background: rgba(0,0,0,0.85); }
</style>

@if($errors->userDeletion->isNotEmpty())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var myModal = new bootstrap.Modal(document.getElementById('confirmUserDeletionModal'));
        myModal.show();
    });
</script>
@endif
