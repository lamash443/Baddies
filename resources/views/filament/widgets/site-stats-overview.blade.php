@php
    $columns = $this->getColumns();
    $pollingInterval = $this->getPollingInterval();
    $visitors = $this->uniqueVisitors ?? collect();
    $totalCount = $visitors->count();
@endphp

<x-filament-widgets::widget
    :attributes="
        (new \Filament\Support\View\ComponentAttributeBag)
            ->merge([
                'wire:poll.' . $pollingInterval => $pollingInterval ? true : null,
            ], escape: false)
            ->class([
                'fi-wi-stats-overview',
            ])
    "
>
    {{ $this->content }}

    {{-- Slide-Over Modal for Total Unique Visitors --}}
    <x-filament::modal
        id="unique-visitors-modal"
        width="6xl"
        :slide-over="true"
    >
        <x-slot name="heading">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary-500/10 text-primary-600 dark:bg-primary-400/10 dark:text-primary-400">
                    <x-filament::icon
                        icon="heroicon-o-users"
                        class="h-6 w-6"
                    />
                </div>
                <div>
                    <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">
                        Total Unique Visitors
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        IP addresses, geographic locations, and total time spent browsing
                    </p>
                </div>
            </div>
        </x-slot>

        <div class="space-y-4 py-2">
            {{-- Quick Summary Stats --}}
            <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
                <div class="rounded-xl border border-gray-200/80 bg-gray-50/50 p-3 dark:border-white/10 dark:bg-white/5">
                    <div class="text-xs font-medium text-gray-500 dark:text-gray-400">Unique IPs</div>
                    <div class="mt-1 text-lg font-bold text-gray-900 dark:text-white">
                        {{ number_format($totalCount) }}
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200/80 bg-gray-50/50 p-3 dark:border-white/10 dark:bg-white/5">
                    <div class="text-xs font-medium text-gray-500 dark:text-gray-400">Avg Time on Site</div>
                    <div class="mt-1 text-lg font-bold text-emerald-600 dark:text-emerald-400">
                        @php
                            $avgSeconds = $totalCount > 0 ? (int) ($visitors->sum('total_time_seconds') / $totalCount) : 0;
                            if ($avgSeconds < 60) {
                                $avgFormatted = "{$avgSeconds}s";
                            } else {
                                $avgMins = floor($avgSeconds / 60);
                                $avgSecs = $avgSeconds % 60;
                                $avgFormatted = "{$avgMins}m " . ($avgSecs > 0 ? "{$avgSecs}s" : '');
                            }
                        @endphp
                        {{ $avgFormatted }}
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200/80 bg-gray-50/50 p-3 dark:border-white/10 dark:bg-white/5">
                    <div class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Visits (Hits)</div>
                    <div class="mt-1 text-lg font-bold text-primary-600 dark:text-primary-400">
                        {{ number_format($visitors->sum('visits_count')) }}
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200/80 bg-gray-50/50 p-3 dark:border-white/10 dark:bg-white/5">
                    <div class="text-xs font-medium text-gray-500 dark:text-gray-400">Top Country</div>
                    <div class="mt-1 truncate text-lg font-bold text-gray-900 dark:text-white">
                        @php
                            $topCountry = $visitors->whereNotNull('country')->where('country', '!=', '')->pluck('country')->countBy()->sortDesc()->keys()->first();
                        @endphp
                        {{ $topCountry ?: 'Kenya 🇰🇪' }}
                    </div>
                </div>
            </div>

            {{-- Search Bar --}}
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <x-filament::icon
                        icon="heroicon-m-magnifying-glass"
                        class="h-4 w-4 text-gray-400"
                    />
                </div>
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search by IP address, country, city..."
                    class="block w-full rounded-lg border border-gray-300 bg-white py-2 pl-9 pr-10 text-sm text-gray-900 placeholder-gray-400 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-white/10 dark:bg-gray-900 dark:text-white dark:placeholder-gray-500"
                />
                @if(!empty($this->search))
                    <button
                        type="button"
                        wire:click="$set('search', '')"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-xs text-gray-400 hover:text-gray-600 dark:hover:text-gray-200"
                    >
                        Clear
                    </button>
                @endif
            </div>

            {{-- Visitors Table --}}
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-white/10 dark:bg-gray-900">
                <div class="max-h-[500px] overflow-y-auto">
                    <table class="w-full divide-y divide-gray-200 text-left text-sm dark:divide-white/10">
                        <thead class="sticky top-0 z-10 bg-gray-50 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                            <tr>
                                <th scope="col" class="px-4 py-3">IP Address</th>
                                <th scope="col" class="px-4 py-3">Location</th>
                                <th scope="col" class="px-4 py-3">Total Time in Site</th>
                                <th scope="col" class="px-4 py-3">Visits</th>
                                <th scope="col" class="px-4 py-3">Last Active</th>
                                <th scope="col" class="px-4 py-3">Device / Browser</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white dark:divide-white/5 dark:bg-gray-900">
                            @forelse($visitors as $visitor)
                                <tr class="transition hover:bg-gray-50/70 dark:hover:bg-white/5">
                                    {{-- IP Address --}}
                                    <td class="whitespace-nowrap px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-block h-2 w-2 rounded-full bg-emerald-500"></span>
                                            <code class="font-mono text-xs font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $visitor->ip_address }}
                                            </code>
                                            <button
                                                type="button"
                                                x-data="{ copied: false }"
                                                x-on:click="
                                                    navigator.clipboard.writeText('{{ $visitor->ip_address }}');
                                                    copied = true;
                                                    setTimeout(() => copied = false, 1500);
                                                "
                                                class="rounded p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-700 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                                title="Copy IP address"
                                            >
                                                <template x-if="!copied">
                                                    <x-filament::icon icon="heroicon-m-clipboard" class="h-3.5 w-3.5" />
                                                </template>
                                                <template x-if="copied">
                                                    <x-filament::icon icon="heroicon-m-check" class="h-3.5 w-3.5 text-emerald-500" />
                                                </template>
                                            </button>
                                        </div>
                                    </td>

                                    {{-- Location --}}
                                    <td class="whitespace-nowrap px-4 py-3">
                                        <div class="flex items-center gap-1.5">
                                            <span class="text-base">{{ $visitor->country_flag }}</span>
                                            <div>
                                                <div class="text-xs font-medium text-gray-900 dark:text-white">
                                                    {{ $visitor->city ?: 'Unknown City' }}
                                                </div>
                                                <div class="text-[11px] text-gray-500 dark:text-gray-400">
                                                    {{ $visitor->country ?: 'Unknown Country' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Total Time on Site --}}
                                    <td class="whitespace-nowrap px-4 py-3">
                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20 dark:bg-emerald-500/10 dark:text-emerald-400 dark:ring-emerald-500/20">
                                            <x-filament::icon icon="heroicon-m-clock" class="h-3.5 w-3.5" />
                                            {{ $visitor->formatted_time_on_site }}
                                        </span>
                                    </td>

                                    {{-- Visits / Hits --}}
                                    <td class="whitespace-nowrap px-4 py-3">
                                        <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-0.5 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10 dark:bg-blue-400/10 dark:text-blue-400 dark:ring-blue-400/30">
                                            {{ number_format($visitor->visits_count) }} {{ Str::plural('visit', $visitor->visits_count) }}
                                        </span>
                                    </td>

                                    {{-- Last Active --}}
                                    <td class="whitespace-nowrap px-4 py-3 text-xs text-gray-600 dark:text-gray-400">
                                        @if($visitor->last_visit_at)
                                            <div>{{ \Carbon\Carbon::parse($visitor->last_visit_at)->diffForHumans() }}</div>
                                            <div class="text-[10px] text-gray-400">{{ \Carbon\Carbon::parse($visitor->last_visit_at)->format('d M, H:i') }}</div>
                                        @else
                                            <span>—</span>
                                        @endif
                                    </td>

                                    {{-- Device & Browser --}}
                                    <td class="whitespace-nowrap px-4 py-3 text-xs text-gray-500 dark:text-gray-400">
                                        <span class="truncate" title="{{ $visitor->user_agent }}">
                                            {{ $visitor->device }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center justify-center space-y-2">
                                            <x-filament::icon
                                                icon="heroicon-o-magnifying-glass"
                                                class="h-8 w-8 text-gray-400"
                                            />
                                            <p class="font-medium text-gray-900 dark:text-white">No unique visitors found</p>
                                            <p class="text-xs text-gray-500">
                                                @if(!empty($this->search))
                                                    Try a different search term or clear the filter.
                                                @else
                                                    Visitor sessions will appear here as users access the site.
                                                @endif
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex w-full items-center justify-between">
                <div class="text-xs text-gray-500 dark:text-gray-400">
                    Displaying up to {{ $totalCount }} unique visitor records
                </div>

                <div class="flex items-center gap-3">
                    <a
                        href="{{ url('/admin/visitors') }}"
                        class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-xs font-semibold text-gray-700 shadow-sm hover:bg-gray-50 dark:border-white/10 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
                    >
                        <span>Open Full Visitors Page</span>
                        <x-filament::icon icon="heroicon-m-arrow-top-right-on-square" class="h-3.5 w-3.5" />
                    </a>

                    <x-filament::button
                        color="gray"
                        x-on:click="$dispatch('close-modal', { id: 'unique-visitors-modal' })"
                    >
                        Close
                    </x-filament::button>
                </div>
            </div>
        </x-slot>
    </x-filament::modal>
</x-filament-widgets::widget>
