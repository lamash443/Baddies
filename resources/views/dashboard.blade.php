<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <x-site-favicon />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard - Baddies Club</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing:border-box; }
    html, body { margin:0; padding:0; font-family:"Outfit",sans-serif; background:#0d0d0d; color:#fff; min-height:100vh; }

    /* NAVBAR STYLES (Required for x-navbar) */
    .nr-navbar { background:linear-gradient(160deg,#0d0d0d 0%,#1a0f00 50%,#0d0d0d 100%) !important; border-bottom:2px solid rgba(255,140,0,0.6); box-shadow:inset 0 -2px 30px rgba(255,140,0,0.06); padding-top:1.25rem !important; padding-bottom:1.25rem !important; }
    .nr-navbar .nav-link { font-weight:500; font-size:0.82rem; color:rgba(255,140,0,0.92) !important; text-decoration:none !important; display:inline-block !important; position:relative !important; padding-bottom:3px !important; box-shadow:none !important; transition:color 0.3s ease !important; }
    .nr-navbar .nav-link::after { content:"" !important; position:absolute !important; left:0 !important; bottom:0 !important; width:100% !important; height:1.5px !important; background:linear-gradient(90deg,rgba(255,255,255,0) 0%,rgba(255,255,255,0.9) 50%,rgba(255,255,255,0) 100%) !important; border-radius:2px !important; transform:scaleX(0) !important; transform-origin:center !important; transition:transform 0.35s cubic-bezier(0.4,0,0.2,1) !important; }
    .nr-navbar .nav-link.active, .nr-navbar .nav-link:hover, .nr-navbar .nav-link:focus { color:#ffffff !important; text-decoration:none !important; box-shadow:none !important; }
    .nr-navbar .nav-link.active::after, .nr-navbar .nav-link:hover::after, .nr-navbar .nav-link:focus::after { transform:scaleX(1) !important; }

    /* DASHBOARD LAYOUT */
    .dashboard-header { padding:3rem 0 2rem; border-bottom:1px solid rgba(255,140,0,0.12); margin-bottom:2.5rem; }
    .dashboard-title { font-size:clamp(1.8rem,4vw,2.5rem); font-weight:900; letter-spacing:-0.02em; line-height:1.1; margin-bottom:0.5rem; }
    .dashboard-title span { background:linear-gradient(135deg,#ff8c00,#ffb347); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
    .dashboard-sub { font-size:0.9rem; color:rgba(255,255,255,0.5); font-weight:400; }

    /* CARDS */
    .dash-card {
      background:rgba(17,17,17,0.85);
      backdrop-filter:blur(15px);
      border:1px solid rgba(255,140,0,0.2);
      border-radius:18px;
      padding:1.25rem 1.5rem;
      height:100%;
      display:flex;
      flex-direction:column;
      position:relative;
      overflow:hidden;
      box-shadow:0 8px 32px rgba(0,0,0,0.5);
      transition:transform 0.3s ease, box-shadow 0.3s ease;
    }
    .dash-card:hover {
      transform:translateY(-5px);
      box-shadow:0 12px 40px rgba(0,0,0,0.6), 0 0 0 1px rgba(255,140,0,0.3) inset;
    }
    .dash-card::before {
      content:""; position:absolute; top:-50px; right:-50px; width:150px; height:150px;
      background:radial-gradient(circle, rgba(255,140,0,0.08) 0%, transparent 70%);
      pointer-events:none;
    }
    .dash-card-icon {
      position:absolute;
      top:1.25rem;
      right:1.5rem;
      width:36px; height:36px;
      background:rgba(255,140,0,0.1); border:1px solid rgba(255,140,0,0.25); border-radius:10px;
      display:flex; align-items:center; justify-content:center;
      color:orange;
    }
    .dash-card-icon svg { width:18px; height:18px; }
    .dash-card-title { font-size:1rem; font-weight:700; color:#fff; margin-bottom:0.4rem; }
    .dash-card-text { font-size:0.8rem; color:rgba(255,255,255,0.6); margin-bottom:1rem; line-height:1.5; }
    
    .dash-value { font-size:1.8rem; font-weight:900; color:#fff; margin-bottom:1rem; letter-spacing:-1px; }
    .dash-value span { font-size:0.85rem; font-weight:500; color:rgba(255,255,255,0.4); margin-left:0.3rem; }

    /* STATUS BADGE */
    .status-badge {
      display:inline-flex; align-items:center; gap:0.3rem;
      font-size:0.75rem; font-weight:700; color:#ff4d4d;
      text-transform:uppercase; letter-spacing:1px; margin-bottom:0.8rem;
    }

    /* ── UNIFIED BUTTON STYLE (same as /profile) ── */
    .btn-orange,
    .btn-ghost,
    .btn-verify {
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      gap: 0.45rem !important;
      background: transparent !important;
      border: 2px solid orange !important;
      color: orange !important;
      padding: 0.6rem 1.4rem !important;
      border-radius: 8px !important;
      font-size: 0.88rem !important;
      font-weight: 700 !important;
      font-family: "Outfit", sans-serif !important;
      text-decoration: none !important;
      transition: all 0.3s ease !important;
      cursor: pointer;
      letter-spacing: 0.02em;
      white-space: nowrap;
      width: 100%;
    }

    /* Hover: fill + orange glow */
    .btn-orange:hover,
    .btn-ghost:hover,
    .btn-verify:hover {
      background: orange !important;
      color: #000 !important;
      border-color: orange !important;
      box-shadow: 0 0 18px 4px rgba(255, 165, 0, 0.55), 0 0 35px rgba(255, 165, 0, 0.25) !important;
      transform: translateY(-1px) !important;
    }

    /* Active / pressed */
    .btn-orange:active,
    .btn-ghost:active,
    .btn-verify:active {
      transform: translateY(0) !important;
      box-shadow: 0 0 10px 2px rgba(255,165,0,0.4) !important;
    }

    /* Banner buttons keep their original larger size */
    .btn-verify {
      padding: 0.75rem 1.5rem !important;
      font-size: 0.95rem !important;
      width: auto !important;
    }

    /* VERIFY BANNER */
    .verify-banner {
      background: linear-gradient(135deg, rgba(255,140,0,0.15) 0%, rgba(255,179,71,0.05) 100%);
      border: 1px solid rgba(255,140,0,0.3);
      border-radius: 16px;
      padding: 1.5rem 2rem;
      margin-top: 1.5rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1.5rem;
      backdrop-filter: blur(10px);
    }
    .verify-banner-content h3 { font-size: 1.2rem; font-weight: 800; margin-bottom: 0.3rem; color: #fff; }
    .verify-banner-content p { font-size: 0.9rem; color: rgba(255,255,255,0.75); margin-bottom: 0; }

    @media (max-width: 768px) {
      .verify-banner { flex-direction: column; align-items: flex-start; }
      .btn-verify { width: 100%; justify-content: center; }
    }


    /* LIGHT THEME */
    [data-bs-theme="light"] body { background:#f9f9f9; color:#111; }
    [data-bs-theme="light"] .dashboard-header { border-color:rgba(0,0,0,0.1); }
    [data-bs-theme="light"] .dashboard-sub { color:rgba(0,0,0,0.6); }
    [data-bs-theme="light"] .dash-card { background:#fff; border-color:rgba(255,140,0,0.3); box-shadow:0 5px 20px rgba(0,0,0,0.05); }
    [data-bs-theme="light"] .dash-card:hover { box-shadow:0 10px 30px rgba(0,0,0,0.1); border-color:orange; }
    [data-bs-theme="light"] .dash-card-title { color:#000; }
    [data-bs-theme="light"] .dash-card-text { color:rgba(0,0,0,0.6); }
    [data-bs-theme="light"] .dash-value { color:#000; }
    [data-bs-theme="light"] .dash-value span { color:rgba(0,0,0,0.5); }
    /* Banner light theme fixes */
    [data-bs-theme="light"] .verify-banner {
      background: linear-gradient(135deg, rgba(255,140,0,0.1) 0%, rgba(255,179,71,0.04) 100%);
      border-color: rgba(255,140,0,0.4);
    }
    [data-bs-theme="light"] .verify-banner-content h3 { color: #111; }
    [data-bs-theme="light"] .verify-banner-content p { color: rgba(0,0,0,0.65); }
    [data-bs-theme="light"] .status-badge { color: #cc0000; }
  </style>
</head>
<body>

  <!-- NAVBAR -->
  <x-navbar :hideSearch="true" />

  <!-- HEADER -->
  <div class="dashboard-header">
    <div class="container">
      @php
        $dashSetting = \App\Models\Setting::getSettings();
      @endphp
      
      @if($dashSetting->unlock_banner_enabled && is_null(Auth::user()->email_verified_at))
      <div class="verify-banner">
        <div class="verify-banner-content">
          <h3>{{ $dashSetting->unlock_banner_title ?? 'Verify Email' }} <svg style="display:inline; width:20px; height:20px; color:orange; margin-left:0.2rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></h3>
          <p>{{ $dashSetting->unlock_banner_description ?? 'Please verify your email address to unlock full account features and priority visibility.' }}</p>
        </div>
        <a href="{{ route('account.verify') }}" class="btn-verify">
          {{ $dashSetting->unlock_banner_button_text ?? 'Verify Now' }}
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5l10 -10"/></svg>
        </a>
      </div>
      @endif

      @php
        $user = Auth::user();
        $profileComplete = $user->phone_number && $user->gender && $user->age && $user->nationality && $user->city_town;
        $showUnlockBanner = $dashSetting->unlock_banner_enabled && is_null($user->email_verified_at);
      @endphp
      @if($dashSetting->profile_banner_enabled && !$profileComplete)
      <div class="verify-banner" style="margin-top: {{ $showUnlockBanner ? '1rem' : '1.5rem' }};">
        <div class="verify-banner-content">
          <h3>{{ $dashSetting->profile_banner_title }}
            <svg style="display:inline; width:20px; height:20px; color:orange; margin-left:0.2rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
              <circle cx="12" cy="7" r="4"/>
            </svg>
          </h3>
          <p>{{ $dashSetting->profile_banner_description }}</p>
        </div>
        <a href="{{ route('profile.edit') }}" class="btn-verify">
          {{ $dashSetting->profile_banner_button_text }}
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
          </svg>
        </a>
      </div>
      @endif
    </div>
  </div>

  <!-- DASHBOARD CONTENT -->
  <div class="container pb-5 mb-5">
    <div class="row g-4 justify-content-center">
      
      <!-- WALLET CARD -->
      <div class="col-12 col-md-6 col-xl-4">
        <div class="dash-card">
          <div class="dash-card-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
          </div>
          <h3 class="dash-card-title">Available Wallet Balance</h3>
          <div class="dash-value" style="color: #4ade80;">{{ number_format($user->wallet_balance ?? 0, 2) }}<span style="color: #4ade80; opacity: 0.8;">KES</span></div>
          <p class="dash-card-text">Top up your wallet to activate your profile, boost your visibility, or unlock premium features.</p>
          <a href="{{ route('wallet.add') }}" class="btn-ghost mt-auto">
            Add Funds
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          </a>
        </div>
      </div>
      
      <!-- PROFILE STATUS CARD -->
      <div class="col-12 col-md-6 col-xl-4">
        <div class="dash-card">
          <div class="dash-card-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
          </div>
          @if($user->hasActiveSubscription())
          <div class="status-badge" style="color: #4ade80;">
            Active
          </div>
          <h3 class="dash-card-title">Profile Status</h3>
          <p class="dash-card-text">Your profile is currently active and visible online. Plan: <strong style="color: orange;">{{ ucwords(str_replace('_', ' ', $user->subscription_plan)) }}</strong></p>
          <a href="{{ route('profile.edit') }}#tab-membership" class="btn-ghost mt-auto">
            Manage Plan
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
          @else
          <div class="status-badge">
            Inactive
          </div>
          <h3 class="dash-card-title">Profile Status</h3>
          <p class="dash-card-text">Your profile is currently not active and will not be visible online to other users.</p>
          <a href="{{ route('profile.edit') }}#tab-membership" class="btn-orange mt-auto">
            Activate Now
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
          @endif
        </div>
      </div>

      <!-- CHAT CARD -->
      <div class="col-12 col-md-6 col-xl-4">
        <div class="dash-card">
          <div class="dash-card-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
          </div>
          @if($user->hasActiveChatSubscription())
          <div class="status-badge" style="color: #4ade80;">
            Active
          </div>
          <h3 class="dash-card-title">Chat Active</h3>
          <p class="dash-card-text">Your chat subscription is active. Plan: <strong style="color: orange;">{{ ucwords(str_replace('_', ' ', $user->chat_plan)) }}</strong></p>
          <a href="{{ route('chat.memberships') }}" class="btn-ghost mt-auto">
            Manage Plan
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
          @else
          <div class="status-badge">
            Inactive
          </div>
          <h3 class="dash-card-title">Chat Inactive</h3>
          <p class="dash-card-text">Your chat subscription is not active.</p>
          <a href="{{ route('chat.memberships') }}" class="btn-orange mt-auto">
            Activate Now
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
          @endif
        </div>
      </div>


      <!-- MESSAGES CARD -->
      @php
        $unreadMessages = \App\Models\Message::where('receiver_id', $user->id)
            ->where('is_read', false)
            ->with(['sender' => function($q){ $q->with('photos'); }])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('sender_id');
        $totalUnread = $unreadMessages->sum(fn($group) => $group->count());
      @endphp
      <div class="col-12">
        <div class="dash-card" style="padding: 1.5rem;">

          {{-- Header row --}}
          <div class="d-flex align-items-center justify-content-between mb-4 position-relative">
            <div class="d-flex align-items-center gap-3">
              <div class="d-none d-md-flex" style="width:40px; height:40px; background:rgba(255,140,0,0.1); border:1px solid rgba(255,140,0,0.25); border-radius:10px; align-items:center; justify-content:center; color:orange; position:relative; flex-shrink:0;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                @if($totalUnread > 0)
                  <span class="msg-pulse"></span>
                @endif
              </div>
              <div class="dash-card-icon d-md-none" style="top: -0.25rem; right: 0;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                @if($totalUnread > 0)
                  <span class="msg-pulse"></span>
                @endif
              </div>
              <div>
                <h3 class="dash-card-title mb-0" style="text-align:left; font-size:1.15rem;">Messages</h3>
                <p class="mb-0" style="font-size:0.78rem; color:rgba(255,255,255,0.45); margin-top:2px;">
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
            <div class="text-center py-4" style="border:1px dashed rgba(255,140,0,0.2); border-radius:12px;">
              <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color:rgba(255,140,0,0.4); margin-bottom:0.75rem;"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
              <p class="mb-3" style="color:rgba(255,255,255,0.5); font-size:0.88rem;">Activate a chat plan to send &amp; receive private messages.</p>
              <a href="{{ route('chat.memberships') }}" class="btn-orange" style="width:auto; display:inline-flex; padding:0.55rem 1.4rem; font-size:0.85rem;">Get Chat Plan</a>
            </div>
          @elseif($unreadMessages->isEmpty())
            <div class="text-center py-4" style="border:1px dashed rgba(255,255,255,0.07); border-radius:12px;">
              <svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" style="color:rgba(255,255,255,0.15); margin-bottom:0.75rem;"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
              <p class="mb-0" style="color:rgba(255,255,255,0.3); font-size:0.88rem;">Your inbox is empty. Start a conversation from a member profile!</p>
            </div>
          @else
            <div class="d-flex flex-column" style="gap:0.6rem;">
              @foreach($unreadMessages as $senderId => $msgs)
                @php
                  $sender  = $msgs->first()->sender;
                  $count   = $msgs->count();
                  $latest  = $msgs->first();
                  $cover   = $sender->profile_photo
                             ? asset('storage/'.$sender->profile_photo)
                             : ($sender->photos->first() ? asset('storage/'.$sender->photos->first()->path) : asset('callboy-1.png'));
                  $snippet = \Illuminate\Support\Str::limit($latest->body, 55);
                  $timeAgo = $latest->created_at->diffForHumans(null, true);
                @endphp
                <a href="{{ route('chat.show', $senderId) }}"
                   class="msg-row d-flex align-items-center gap-3 text-decoration-none"
                   style="background:rgba(255,255,255,0.04); border:1px solid rgba(255,140,0,0.15); border-radius:12px; padding:0.85rem 1rem; transition:all 0.2s ease;">
                  <div class="position-relative flex-shrink-0">
                    <img src="{{ $cover }}" alt="{{ $sender->name }}"
                         style="width:46px; height:46px; border-radius:50%; object-fit:cover; border:2px solid rgba(255,140,0,0.3);">
                    <span style="position:absolute; bottom:1px; right:1px; width:11px; height:11px; background:#4ade80; border-radius:50%; border:2px solid #111;"></span>
                  </div>
                  <div class="flex-grow-1" style="min-width:0;">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                      <span style="font-size:0.9rem; font-weight:700; color:#fff;">{{ $sender->name }}</span>
                      <span style="font-size:0.7rem; color:rgba(255,255,255,0.35); white-space:nowrap; margin-left:0.5rem;">{{ $timeAgo }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between gap-2">
                      <span style="font-size:0.8rem; color:rgba(255,255,255,0.5); white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $snippet }}</span>
                      <span style="flex-shrink:0; min-width:20px; height:20px; background:#ff8c00; border-radius:50px; font-size:0.68rem; font-weight:800; color:#000; display:flex; align-items:center; justify-content:center; padding:0 5px;">{{ $count }}</span>
                    </div>
                  </div>
                </a>
              @endforeach
            </div>
          @endif

        </div>
      </div>
    </div>
  </div>

  <x-footer />

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
