<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use App\Services\GeoLocationService;
use Closure;
use Illuminate\Http\Request;
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
        // Don't track API, admin, or visitor heartbeat routes
        if (!$request->is('api/*') && !$request->is('admin/*') && !$request->is('admin') && !$request->is('visitor/*')) {
            $ip = $request->ip();
            $date = now()->toDateString();

            if ($ip) {
                $now = now();
                $visitor = Visitor::firstOrCreate(
                    ['ip_address' => $ip, 'visit_date' => $date],
                    [
                        'user_agent' => $request->userAgent(),
                        'first_visit_at' => $now,
                        'visits_count' => 0,
                        'total_time_seconds' => 30, // initial baseline of 30 seconds for landing
                    ]
                );

                // If location is not yet populated, resolve it
                if (empty($visitor->country) || empty($visitor->city)) {
                    $geo = GeoLocationService::lookup($ip);
                    if (!empty($geo['country'])) {
                        $visitor->country = $geo['country'];
                        $visitor->country_code = $geo['country_code'];
                        $visitor->city = $geo['city'];
                        $visitor->region = $geo['region'];
                    }
                }

                // Calculate time elapsed since last request if within reasonable browsing session (30 mins)
                $timeToAdd = 0;
                if ($visitor->last_visit_at) {
                    $diffInSeconds = $now->diffInSeconds($visitor->last_visit_at);
                    if ($diffInSeconds > 0 && $diffInSeconds <= 1800) {
                        // Cap at max 10 minutes between consecutive page clicks to avoid idle runaway
                        $timeToAdd = min($diffInSeconds, 600);
                    } else {
                        // New browsing burst after 30+ minutes
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

                $visitor->save();
            }
        }

        return $next($request);
    }
}

