<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    @if(request('deletion_pending'))
    {{-- Deletion Pending Toast --}}
    <style>
      .del-toast {
        position: fixed; bottom: 2rem; right: 2rem; z-index: 9999;
        display: flex; align-items: flex-start; gap: 0.85rem;
        background: #0d0d0d;
        border: 1px solid rgba(220,53,69,0.4);
        border-left: 4px solid #dc3545;
        border-radius: 14px;
        padding: 1rem 1.25rem;
        max-width: 360px; width: calc(100vw - 4rem);
        box-shadow: 0 20px 60px rgba(0,0,0,0.7), 0 0 0 1px rgba(255,255,255,0.04);
        font-family: ui-sans-serif, system-ui, sans-serif;
        animation: delToastIn 0.45s cubic-bezier(0.34,1.56,0.64,1) both;
        overflow: hidden;
      }
      @keyframes delToastIn {
        from { opacity:0; transform: translateY(24px) scale(0.94); }
        to   { opacity:1; transform: translateY(0)    scale(1); }
      }
      .del-toast__icon {
        flex-shrink:0; margin-top:2px;
        width:36px; height:36px; border-radius:10px;
        background:rgba(220,53,69,0.12); border:1px solid rgba(220,53,69,0.3);
        display:flex; align-items:center; justify-content:center; color:#ff4d4d;
      }
      .del-toast__body { flex:1; min-width:0; }
      .del-toast__title {
        font-size:0.875rem; font-weight:700; color:#ff4d4d;
        margin:0 0 0.2rem; line-height:1.2;
      }
      .del-toast__msg {
        font-size:0.8rem; color:rgba(255,255,255,0.6);
        margin:0; line-height:1.5;
      }
      .del-toast__close {
        flex-shrink:0; align-self:flex-start;
        background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1);
        border-radius:7px; width:26px; height:26px;
        display:flex; align-items:center; justify-content:center;
        color:rgba(255,255,255,0.45); cursor:pointer; padding:0;
        transition:all 0.2s;
      }
      .del-toast__close:hover { background:rgba(220,53,69,0.15); border-color:rgba(220,53,69,0.35); color:#ff4d4d; }
      .del-toast__bar {
        position:absolute; bottom:0; left:0; height:3px;
        background:linear-gradient(90deg,#dc3545,rgba(220,53,69,0.2));
        border-radius:0 0 0 14px;
        animation:delToastBar 6s linear both;
      }
      @keyframes delToastBar { from{width:100%} to{width:0%} }
    </style>

    <div class="del-toast" id="delToast" role="alert" aria-live="assertive">
        <div class="del-toast__icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
        </div>
        <div class="del-toast__body">
            <p class="del-toast__title">Deletion Request Pending</p>
            <p class="del-toast__msg">Your account deletion request is pending admin approval.</p>
        </div>
        <button class="del-toast__close" onclick="document.getElementById('delToast').remove();" aria-label="Dismiss">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
        <div class="del-toast__bar"></div>
    </div>
    <script>setTimeout(()=>{const t=document.getElementById('delToast');if(t)t.remove();},6000);</script>
    @endif

</x-guest-layout>
