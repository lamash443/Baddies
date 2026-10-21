<div class="space-y-6 text-sm">
    {{-- Top Summary Bar --}}
    <div class="flex flex-wrap items-center justify-between gap-3 rounded-xl border border-gray-200 bg-gray-50/70 p-4 dark:border-white/10 dark:bg-white/5">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary-500/10 text-primary-600 dark:text-primary-400">
                <x-filament::icon icon="heroicon-m-globe-alt" class="h-6 w-6" />
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <code class="font-mono text-base font-bold text-gray-900 dark:text-white">{{ $visitor->ip_address }}</code>
                    <button
                        type="button"
                        x-data="{ copied: false }"
                        x-on:click="
                            navigator.clipboard.writeText('{{ $visitor->ip_address }}');
                            copied = true;
                            setTimeout(() => copied = false, 1500);
                        "
                        class="rounded p-1 text-gray-400 hover:bg-gray-200 hover:text-gray-700 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                        title="Copy IP"
                    >
                        <template x-if="!copied">
                            <x-filament::icon icon="heroicon-m-clipboard" class="h-4 w-4" />
                        </template>
                        <template x-if="copied">
                            <x-filament::icon icon="heroicon-m-check" class="h-4 w-4 text-emerald-500" />
                        </template>
                    </button>
                </div>
                <div class="text-xs text-gray-500 dark:text-gray-400">
                    Visit Date: {{ $visitor->visit_date ? $visitor->visit_date->format('d M Y') : '—' }}
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2">
            @if($visitor->is_online)
                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-400">
                    <span class="h-2 w-2 animate-pulse rounded-full bg-emerald-500"></span>
                    Online Now
                </span>
            @elseif($visitor->last_visit_at && $visitor->last_visit_at->greaterThanOrEqualTo(now()->startOfDay()))
                <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-950/40 dark:text-amber-400">
                    <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                    Active Today
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                    <span class="h-2 w-2 rounded-full bg-gray-400"></span>
                    Offline
                </span>
            @endif
        </div>
    </div>

    @php
        $regUser = $visitor->registered_user;
    @endphp

    {{-- Registered User Card --}}
    @if($regUser)
        <div class="rounded-xl border border-primary-500/30 bg-primary-500/10 p-4 dark:border-primary-400/20 dark:bg-primary-500/5">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-primary-600 text-white font-bold text-base shadow-sm">
                        {{ strtoupper(substr($regUser->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-base font-bold text-gray-900 dark:text-white">{{ $regUser->name }}</span>
                            @if($regUser->is_verified)
                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-semibold text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-400">
                                    <x-filament::icon icon="heroicon-m-check-badge" class="h-3 w-3" />
                                    Verified
                                </span>
                            @endif
                            @if($regUser->is_admin)
                                <span class="rounded-full bg-purple-100 px-2 py-0.5 text-[10px] font-semibold text-purple-700 dark:bg-purple-950/40 dark:text-purple-400">
                                    Admin
                                </span>
                            @endif
                        </div>
                        <div class="text-xs text-gray-600 dark:text-gray-400 mt-0.5">
                            <span class="font-mono">{{ $regUser->email }}</span>
                            @if($regUser->phone_number)
                                <span class="mx-1">•</span>
                                <span>{{ $regUser->phone_number }}</span>
                            @endif
                            <span class="mx-1">•</span>
                            <span>Registered: {{ $regUser->created_at?->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
                <a
                    href="{{ \App\Filament\Resources\Users\UserResource::getUrl('edit', ['record' => $regUser->id]) }}"
                    target="_blank"
                    class="inline-flex items-center gap-1.5 rounded-lg bg-primary-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-primary-500 transition-colors"
                >
                    View Account
                    <x-filament::icon icon="heroicon-m-arrow-top-right-on-square" class="h-3.5 w-3.5" />
                </a>
            </div>
        </div>
    @else
        <div class="rounded-xl border border-gray-200 bg-gray-50/50 p-3.5 text-xs text-gray-500 dark:border-white/10 dark:bg-white/5 dark:text-gray-400 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <x-filament::icon icon="heroicon-m-user" class="h-4 w-4 text-gray-400" />
                <span>Visitor Status: <strong class="text-gray-700 dark:text-gray-300">Guest (Unregistered)</strong></span>
            </div>
            <span class="text-[11px] text-gray-400">No registered user matches this IP</span>
        </div>
    @endif

    {{-- 2 Column Grid: Location and Activity Stats --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        {{-- Geolocation Card --}}
        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-gray-900">
            <div class="flex items-center gap-2 border-b border-gray-100 pb-2.5 text-xs font-bold uppercase tracking-wider text-gray-500 dark:border-white/10 dark:text-gray-400">
                <x-filament::icon icon="heroicon-m-map-pin" class="h-4 w-4 text-primary-500" />
                <span>Geographic Location</span>
            </div>

            <dl class="mt-3 space-y-2.5 text-xs">
                <div class="flex justify-between py-1">
                    <dt class="text-gray-500 dark:text-gray-400">Country:</dt>
                    <dd class="font-semibold text-gray-900 dark:text-white flex items-center gap-1.5">
                        <span>{{ $visitor->country_flag }}</span>
                        <span>{{ $visitor->country ?? 'Unknown' }}</span>
                        @if($visitor->country_code)
                            <span class="rounded bg-gray-100 px-1 py-0.5 text-[10px] text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                                {{ $visitor->country_code }}
                            </span>
                        @endif
                    </dd>
                </div>
                <div class="flex justify-between py-1 border-t border-gray-50 dark:border-white/5">
                    <dt class="text-gray-500 dark:text-gray-400">City:</dt>
                    <dd class="font-medium text-gray-900 dark:text-white">{{ $visitor->city ?? 'Unknown' }}</dd>
                </div>
                <div class="flex justify-between py-1 border-t border-gray-50 dark:border-white/5">
                    <dt class="text-gray-500 dark:text-gray-400">Region / County:</dt>
                    <dd class="font-medium text-gray-900 dark:text-white">{{ $visitor->region ?? '—' }}</dd>
                </div>
                <div class="flex justify-between py-1 border-t border-gray-50 dark:border-white/5">
                    <dt class="text-gray-500 dark:text-gray-400">Full String:</dt>
                    <dd class="text-gray-700 dark:text-gray-300">{{ $visitor->location_string }}</dd>
                </div>
            </dl>
        </div>

        {{-- Activity & Engagement Card --}}
        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-gray-900">
            <div class="flex items-center gap-2 border-b border-gray-100 pb-2.5 text-xs font-bold uppercase tracking-wider text-gray-500 dark:border-white/10 dark:text-gray-400">
                <x-filament::icon icon="heroicon-m-clock" class="h-4 w-4 text-emerald-500" />
                <span>Session & Engagement</span>
            </div>

            <dl class="mt-3 space-y-2.5 text-xs">
                <div class="flex justify-between py-1">
                    <dt class="text-gray-500 dark:text-gray-400">Time on Site:</dt>
                    <dd class="inline-flex items-center gap-1 font-bold text-emerald-600 dark:text-emerald-400">
                        <x-filament::icon icon="heroicon-m-clock" class="h-3.5 w-3.5" />
                        <span>{{ $visitor->formatted_time_on_site }}</span>
                    </dd>
                </div>
                <div class="flex justify-between py-1 border-t border-gray-50 dark:border-white/5">
                    <dt class="text-gray-500 dark:text-gray-400">Pageviews / Visits:</dt>
                    <dd class="font-bold text-blue-600 dark:text-blue-400">{{ $visitor->visits_count ?? 1 }} visits</dd>
                </div>
                <div class="flex justify-between py-1 border-t border-gray-50 dark:border-white/5">
                    <dt class="text-gray-500 dark:text-gray-400">First Visit At:</dt>
                    <dd class="text-gray-700 dark:text-gray-300">
                        {{ $visitor->first_visit_at ? $visitor->first_visit_at->format('d M Y, H:i:s') : ($visitor->created_at ? $visitor->created_at->format('d M Y, H:i:s') : '—') }}
                    </dd>
                </div>
                <div class="flex justify-between py-1 border-t border-gray-50 dark:border-white/5">
                    <dt class="text-gray-500 dark:text-gray-400">Last Active At:</dt>
                    <dd class="font-medium text-gray-900 dark:text-white">
                        {{ $visitor->last_visit_at ? $visitor->last_visit_at->format('d M Y, H:i:s') . ' (' . $visitor->last_visit_at->diffForHumans() . ')' : '—' }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    {{-- Device & Client Technical Information --}}
    <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-gray-900">
        <div class="flex items-center gap-2 border-b border-gray-100 pb-2.5 text-xs font-bold uppercase tracking-wider text-gray-500 dark:border-white/10 dark:text-gray-400">
            <x-filament::icon icon="heroicon-m-computer-desktop" class="h-4 w-4 text-purple-500" />
            <span>Device, Operating System & Browser</span>
        </div>

        <div class="mt-3 grid grid-cols-1 gap-3 sm:grid-cols-3">
            <div class="rounded-lg bg-gray-50 p-3 dark:bg-white/5">
                <div class="text-[11px] font-semibold text-gray-400 uppercase">Device Type</div>
                <div class="mt-1 font-semibold text-gray-900 dark:text-white flex items-center gap-1.5">
                    @if(str_contains(strtolower($visitor->device), 'mobile') || str_contains(strtolower($visitor->device), 'ios') || str_contains(strtolower($visitor->device), 'android'))
                        <x-filament::icon icon="heroicon-m-device-phone-mobile" class="h-4 w-4 text-primary-500" />
                    @elseif(str_contains(strtolower($visitor->device), 'tablet'))
                        <x-filament::icon icon="heroicon-m-device-tablet" class="h-4 w-4 text-primary-500" />
                    @else
                        <x-filament::icon icon="heroicon-m-computer-desktop" class="h-4 w-4 text-primary-500" />
                    @endif
                    <span>{{ explode('•', $visitor->device)[0] ?? 'Desktop' }}</span>
                </div>
            </div>

            <div class="rounded-lg bg-gray-50 p-3 dark:bg-white/5">
                <div class="text-[11px] font-semibold text-gray-400 uppercase">Browser</div>
                <div class="mt-1 font-semibold text-gray-900 dark:text-white">
                    {{ $visitor->browser_name }}
                </div>
            </div>

            <div class="rounded-lg bg-gray-50 p-3 dark:bg-white/5">
                <div class="text-[11px] font-semibold text-gray-400 uppercase">Operating System</div>
                <div class="mt-1 font-semibold text-gray-900 dark:text-white">
                    {{ $visitor->os_name }}
                </div>
            </div>
        </div>

        {{-- Raw User Agent --}}
        <div class="mt-4">
            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">
                Raw User-Agent String:
            </label>
            <div class="rounded-lg border border-gray-200 bg-gray-50 p-3 font-mono text-[11px] text-gray-700 break-all select-all dark:border-white/10 dark:bg-gray-950 dark:text-gray-300">
                {{ $visitor->user_agent ?: 'No User-Agent provided' }}
            </div>
        </div>
    </div>
</div>
