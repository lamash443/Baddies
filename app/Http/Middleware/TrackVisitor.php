<?php

namespace App\Http\Middleware;

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
        // Don't track API or admin routes
        if (!$request->is('api/*') && !$request->is('admin/*') && !$request->is('admin')) {
            $ip = $request->ip();
            $date = now()->toDateString();

            if ($ip) {
                $visitor = \App\Models\Visitor::firstOrCreate(
                    ['ip_address' => $ip, 'visit_date' => $date],
                    ['user_agent' => $request->userAgent(), 'visits_count' => 0]
                );

                $visitor->increment('visits_count');
                $visitor->update(['last_visit_at' => now()]);
            }
        }

        return $next($request);
    }
}
