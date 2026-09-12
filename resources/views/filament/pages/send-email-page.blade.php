<x-filament-panels::page>
@php
    $totalUsers      = \App\Models\User::whereNotNull('email')->count();
    $verifiedUsers   = \App\Models\User::where('is_verified', true)->count();
    $subscribedUsers = \App\Models\User::whereNotNull('subscription_plan')->count();
    $blockedUsers    = \App\Models\User::where('is_blocked', true)->count();
@endphp

<style>
  /* ── Page hero ─────────────────────────────────────────── */
  .be-hero {
    background: linear-gradient(135deg, rgba(255,140,0,0.08) 0%, rgba(0,0,0,0) 60%);
    border: 1px solid rgba(255,140,0,0.18);
    border-radius: 1rem;
    padding: 1.75rem 2rem;
    margin-bottom: 1.75rem;
    display: flex;
    align-items: center;
    gap: 1.25rem;
  }
  .be-hero-icon {
    flex-shrink: 0;
    width: 56px; height: 56px;
    background: rgba(255,140,0,0.14);
    border: 1px solid rgba(255,140,0,0.35);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: #ff8c00;
  }
  .be-hero-title { font-size: 1.35rem; font-weight: 800; color: #fff; margin: 0 0 .2rem; }
  .be-hero-sub   { font-size: .85rem; color: rgba(255,255,255,.5); margin: 0; }

  /* ── Stat strip ────────────────────────────────────────── */
  .be-stats { display: grid; grid-template-columns: repeat(4,1fr); gap: .9rem; margin-bottom: 1.75rem; }
  @media(max-width:768px){ .be-stats { grid-template-columns: repeat(2,1fr); } }
  .be-stat {
    border-radius: .75rem; padding: 1rem 1.1rem;
    display: flex; align-items: center; gap: .75rem;
    border: 1px solid;
  }
  .be-stat.orange { background:rgba(255,140,0,.06); border-color:rgba(255,140,0,.2); }
  .be-stat.green  { background:rgba(34,197,94,.06);  border-color:rgba(34,197,94,.2); }
  .be-stat.blue   { background:rgba(99,102,241,.06); border-color:rgba(99,102,241,.2); }
  .be-stat.red    { background:rgba(239,68,68,.06);  border-color:rgba(239,68,68,.2); }
  .be-stat-icon {
    width:38px; height:38px; border-radius:50%;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
  }
  .be-stat.orange .be-stat-icon { background:rgba(255,140,0,.15); color:#ff8c00; }
  .be-stat.green  .be-stat-icon { background:rgba(34,197,94,.15);  color:#22c55e; }
  .be-stat.blue   .be-stat-icon { background:rgba(99,102,241,.15); color:#818cf8; }
  .be-stat.red    .be-stat-icon { background:rgba(239,68,68,.15);  color:#f87171; }
  .be-stat-num  { font-size:1.5rem; font-weight:800; color:#fff; line-height:1; }
  .be-stat-label{ font-size:.72rem; color:rgba(255,255,255,.45); margin-top:.15rem; text-transform:uppercase; letter-spacing:.06em; }

  /* ── Two-column layout ─────────────────────────────────── */
  .be-layout { display: grid; grid-template-columns: 1fr 300px; gap: 1.25rem; align-items: start; }
  @media(max-width:1024px){ .be-layout { grid-template-columns: 1fr; } }

  /* ── Sidebar ───────────────────────────────────────────── */
  .be-sidebar { display: flex; flex-direction: column; gap: 1rem; }
  .be-card {
    background: rgba(255,255,255,.03);
    border: 1px solid rgba(255,255,255,.08);
    border-radius: .85rem;
    padding: 1.15rem 1.25rem;
  }
  .be-card-title {
    font-size: .75rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .08em; color: #ff8c00; margin: 0 0 .85rem;
    display: flex; align-items: center; gap: .4rem;
  }
  .be-tip {
    display: flex; align-items: flex-start; gap: .6rem;
    font-size: .8rem; color: rgba(255,255,255,.6); line-height: 1.55;
    margin-bottom: .65rem;
  }
  .be-tip:last-child { margin-bottom: 0; }
  .be-tip-dot {
    flex-shrink: 0; width: 6px; height: 6px; border-radius: 50%;
    background: #ff8c00; margin-top: .42rem;
  }
  .be-checklist-item {
    display: flex; align-items: center; gap: .6rem;
    font-size: .8rem; color: rgba(255,255,255,.55);
    padding: .45rem 0;
    border-bottom: 1px solid rgba(255,255,255,.05);
  }
  .be-checklist-item:last-child { border-bottom: none; padding-bottom: 0; }
  .be-check-icon { color: #22c55e; flex-shrink: 0; }
  .be-shortcut {
    display: flex; justify-content: space-between; align-items: center;
    font-size: .8rem; padding: .4rem 0;
    border-bottom: 1px solid rgba(255,255,255,.05);
    color: rgba(255,255,255,.55);
  }
  .be-shortcut:last-child { border-bottom: none; }
  .be-shortcut kbd {
    background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.12);
    border-radius: 4px; padding: 1px 7px; font-size: .72rem;
    font-family: monospace; color: rgba(255,255,255,.7);
  }

  /* ── Send bar ──────────────────────────────────────────── */
  .be-send-bar {
    margin-top: 1.25rem;
    background: rgba(255,140,0,.05);
    border: 1px solid rgba(255,140,0,.2);
    border-radius: .85rem;
    padding: 1rem 1.25rem;
    display: flex; align-items: center; justify-content: space-between; gap: 1rem;
    flex-wrap: wrap;
  }
  .be-send-hint { font-size: .82rem; color: rgba(255,255,255,.45); }
  .be-send-hint strong { color: rgba(255,255,255,.75); }
</style>

{{-- ── Hero ────────────────────────────────────────────────── --}}
<div class="be-hero">
    <div class="be-hero-icon">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.63 3.4 2 2 0 0 1 3.62 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.54a16 16 0 0 0 6 6l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
        </svg>
    </div>
    <div>
        <p class="be-hero-title">Broadcast Email Composer</p>
        <p class="be-hero-sub">Send targeted or bulk emails directly to your members. Emails are dispatched via the background queue.</p>
    </div>
</div>

{{-- ── Audience Stats ──────────────────────────────────────── --}}
<div class="be-stats">
    <div class="be-stat orange">
        <div class="be-stat-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <div>
            <div class="be-stat-num">{{ number_format($totalUsers) }}</div>
            <div class="be-stat-label">Total Members</div>
        </div>
    </div>
    <div class="be-stat green">
        <div class="be-stat-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        </div>
        <div>
            <div class="be-stat-num">{{ number_format($verifiedUsers) }}</div>
            <div class="be-stat-label">Verified</div>
        </div>
    </div>
    <div class="be-stat blue">
        <div class="be-stat-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        </div>
        <div>
            <div class="be-stat-num">{{ number_format($subscribedUsers) }}</div>
            <div class="be-stat-label">Subscribed</div>
        </div>
    </div>
    <div class="be-stat red">
        <div class="be-stat-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        </div>
        <div>
            <div class="be-stat-num">{{ number_format($blockedUsers) }}</div>
            <div class="be-stat-label">Blocked</div>
        </div>
    </div>
</div>

{{-- ── Two-column layout ────────────────────────────────────── --}}
<div class="be-layout">

    {{-- Left: Form --}}
    <div>
        <form wire:submit="send">
            {{ $this->form }}

            {{-- Send bar --}}
            <div class="be-send-bar">
                <div class="be-send-hint">
                    <svg style="display:inline;vertical-align:-3px;margin-right:4px" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Emails are sent <strong>via the background queue</strong>. Large sends won't slow the site.
                </div>
                <div style="display:flex;gap:.65rem;align-items:center;flex-wrap:wrap;">
                    @foreach ($this->getFormActions() as $action)
                        {{ $action }}
                    @endforeach
                </div>
            </div>
        </form>
    </div>

    {{-- Right: Sidebar --}}
    <div class="be-sidebar">

        {{-- Tips --}}
        <div class="be-card">
            <p class="be-card-title">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a7 7 0 0 1 7 7c0 2.86-1.72 5.3-4.2 6.42L14 22H10l-.8-6.58C6.72 14.3 5 11.86 5 9a7 7 0 0 1 7-7z"/></svg>
                Best Practices
            </p>
            <div class="be-tip"><div class="be-tip-dot"></div><span>Keep subject lines under <strong style="color:#fff">50 characters</strong> for best open rates.</span></div>
            <div class="be-tip"><div class="be-tip-dot"></div><span>Address members by name — the template does this automatically.</span></div>
            <div class="be-tip"><div class="be-tip-dot"></div><span>Send to <strong style="color:#fff">verified users</strong> for higher deliverability.</span></div>
            <div class="be-tip"><div class="be-tip-dot"></div><span>Test with a <strong style="color:#fff">specific user</strong> (yourself) before blasting all.</span></div>
            <div class="be-tip"><div class="be-tip-dot"></div><span>Make sure <strong style="color:#fff">SMTP credentials</strong> are set in Site Settings first.</span></div>
        </div>

        {{-- Pre-flight checklist --}}
        <div class="be-card">
            <p class="be-card-title">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                Pre-send Checklist
            </p>
            <div class="be-checklist-item">
                <svg class="be-check-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                SMTP configured in Site Settings
            </div>
            <div class="be-checklist-item">
                <svg class="be-check-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                Queue worker is running
            </div>
            <div class="be-checklist-item">
                <svg class="be-check-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                Subject line is clear & concise
            </div>
            <div class="be-checklist-item">
                <svg class="be-check-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                Message body is proofread
            </div>
            <div class="be-checklist-item">
                <svg class="be-check-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                Correct audience selected
            </div>
        </div>

        {{-- Queue tip --}}
        <div class="be-card" style="border-color:rgba(255,140,0,.2);background:rgba(255,140,0,.04);">
            <p class="be-card-title" style="color:#f59e0b;">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                Queue Worker
            </p>
            <p style="font-size:.79rem;color:rgba(255,255,255,.5);margin:0;line-height:1.6;">
                Run the queue to process emails:<br>
                <code style="background:rgba(0,0,0,.4);border:1px solid rgba(255,255,255,.1);border-radius:4px;padding:3px 7px;font-size:.75rem;color:#ff8c00;display:inline-block;margin-top:.4rem;">php artisan queue:work</code>
            </p>
        </div>

    </div>
</div>

<x-filament-actions::modals />
</x-filament-panels::page>
