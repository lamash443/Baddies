@php
  // Listing card image: Prioritize user-selected main published photo (is_main = true), then first published photo
  $mainPhoto = $user->photos->where('is_main', true)->first() ?? $user->photos->first();
  $cover = $mainPhoto
    ? asset('storage/' . $mainPhoto->path)
    : "https://ui-avatars.com/api/?name=".urlencode(substr($user->name, 0, 2))."&background=ff8c00&color=000&size=200&bold=true";
  // Formatted name
  $name = $user->name ?? 'Member';
  // Age & City
  $age = $user->age ? $user->age . ' Yo' : null;
  $city = $user->city_town ?? null;
  // Subscription plan badge
  $plan = $user->subscription_plan ?? null;
  // Gender-aware card label
  $gender = strtolower($user->gender ?? '');
  $cardLabel = $gender === 'female' ? 'Escort Girl' : ($gender === 'male' ? 'Call Boy' : 'Escort');
  // Animation index based on loop variable if available
  $animIndex = isset($loop) ? ($loop->index % 6) + 1 : 1;
@endphp

<article class="nr-listing-card fi{{ $animIndex }}" style="cursor:pointer;" onclick="window.location.href='{{ url('profile', $user->id) }}'" role="button" tabindex="0" aria-label="View {{ $name }} profile" onkeydown="if(event.key==='Enter')window.location.href='{{ url('profile', $user->id) }}'">
  <div class="nr-listing-card__media-shell">
    <div class="nr-listing-card__media-wrap">
      <img class="nr-listing-card__media" src="{{ $cover }}" alt="{{ $name }}" loading="lazy">

      @if($plan === 'prime_vip')
        <span class="nr-plan-badge nr-plan-badge--prime-vip">Prime VIP</span>
      @elseif($plan === 'prime')
        <span class="nr-plan-badge nr-plan-badge--prime">Prime</span>
      @elseif($plan === 'vip')
        <span class="nr-plan-badge nr-plan-badge--vip">VIP</span>
      @elseif($plan === 'regular')
        <span class="nr-plan-badge nr-plan-badge--regular">Regular</span>
      @endif
    </div>
  </div>

  <div class="nr-listing-card__body">
    <div class="nr-listing-card__eyebrow">{{ $cardLabel }}</div>

    <h3 class="nr-listing-card__title">
      <a href="{{ url('profile', $user->id) }}">{{ $name }}</a>
    </h3>

    <div class="nr-listing-card__values">
      @if($age)
      <div class="nr-listing-card__value">
        <span class="nr-listing-card__value-icon">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm0 2c4.42 0 8 2.24 8 5v1H4v-1c0-2.76 3.58-5 8-5Z"/></svg>
        </span>
        <span class="nr-listing-card__value-text">{{ $age }}</span>
      </div>
      @endif

      @if($city)
      <div class="nr-listing-card__value">
        <span class="nr-listing-card__value-icon">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21s-6-5.33-6-11a6 6 0 1 1 12 0c0 5.67-6 11-6 11Zm0-8.25A2.75 2.75 0 1 0 12 7.25a2.75 2.75 0 0 0 0 5.5Z"/></svg>
        </span>
        <span class="nr-listing-card__value-text">{{ $city }}</span>
      </div>
      @endif
    </div>

    <div class="mt-auto pt-2 d-flex gap-2">
      <a class="btn btn-primary flex-grow-1" href="{{ url('profile', $user->id) }}" onclick="event.stopPropagation();">View Profile</a>
      @auth
        @if(auth()->user()->hasActiveChatSubscription())
          <a class="btn flex-grow-1 d-flex align-items-center justify-content-center gap-1 btn-chat-card" href="{{ route('chat.show', $user->id) }}" onclick="event.stopPropagation();">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
            Chat
          </a>
        @else
          <a class="btn flex-grow-1 d-flex align-items-center justify-content-center gap-1 btn-chat-card" href="{{ route('chat.memberships') }}" onclick="event.stopPropagation();">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
            Chat
          </a>
        @endif
      @else
        <button type="button"
          class="btn flex-grow-1 d-flex align-items-center justify-content-center gap-1 btn-chat-card"
          onclick="event.stopPropagation(); openChatGuestFlow();">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
          Chat
        </button>
      @endauth
    </div>
  </div>
</article>
