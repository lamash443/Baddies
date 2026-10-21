<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use App\Services\GeoLocationService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only track GET requests on public-facing web pages
        if ($request->isMethod('GET')
            && !$request->is('api/*')
            && !$request->is('admin/*')
            && !$request->is('admin')
            && !$request->is('visitor/*')
            && !$request->is('login')
            && !$request->is('register')
            && !$request->ajax()
        ) {
            try {
                $ip = $request->ip();
                $date = now()->toDateString();

                if ($ip) {
                    $now = now();
                    $hasNewColumns = Schema::hasColumn('visitors', 'total_time_seconds');

                    if ($hasNewColumns) {
                        $visitor = Visitor::firstOrCreate(
                            ['ip_address' => $ip, 'visit_date' => $date],
                            [
                                'user_agent' => $request->userAgent(),
                                'first_visit_at' => $now,
                                'visits_count' => 0,
                                'total_time_seconds' => 30,
                            ]
                        );

                        if (empty($visitor->country) || empty($visitor->city)) {
                            $geo = GeoLocationService::lookup($ip);
                            if (!empty($geo['country'])) {
                                $visitor->country = $geo['country'];
                                $visitor->country_code = $geo['country_code'];
                                $visitor->city = $geo['city'];
                                $visitor->region = $geo['region'];
                            }
                        }

                        $timeToAdd = 0;
                        if ($visitor->last_visit_at) {
                            $diffInSeconds = $now->diffInSeconds($visitor->last_visit_at);
                            if ($diffInSeconds > 0 && $diffInSeconds <= 1800) {
                                $timeToAdd = min($diffInSeconds, 600);
                            } else {
                                $timeToAdd = 30;
                            }
                        }

                        $visitor->visits_count = ($visitor->visits_count ?? 0) + 1;
                        $visitor->total_time_seconds = ($visitor->total_time_seconds ?? 0) + $timeToAdd;
                        $visitor->last_visit_at = $now;

                        if (!$visitor->first_visit_at) {
                            $visitor->first_visit_at = $visitor->created_at ?? $now;
                        }

                        if ($request->userAgent() && empty($visitor->user_agent)) {
                            $visitor->user_agent = $request->userAgent();
                        }

                        if (auth()->check() && Schema::hasColumn('visitors', 'user_id')) {
                            $visitor->user_id = auth()->id();
                        }

                        $visitor->save();
                    } else {
                        // Safe fallback for unmigrated database
                        $visitor = Visitor::firstOrCreate(
                            ['ip_address' => $ip, 'visit_date' => $date],
                            ['user_agent' => $request->userAgent(), 'visits_count' => 0]
                        );

                        $visitor->increment('visits_count');
                        $visitor->update(['last_visit_at' => $now]);
                    }
                }
            } catch (\Throwable $e) {
                // Log and silently continue - never fail a user request due to analytics tracking
                Log::warning('TrackVisitor middleware error: ' . $e->getMessage());
            }
        }

        return $next($request);
    }
}


