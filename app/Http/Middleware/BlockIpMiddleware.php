<?php

namespace App\Http\Middleware;

use App\Models\BlockedIp;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockIpMiddleware
{
    /**
     * Handle an incoming request and block blacklisted IP addresses.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();

        if ($ip && BlockedIp::isBlocked($ip)) {
            // Allow admin panel access so administrators are not locked out
            if ($request->is('admin') || $request->is('admin/*')) {
                return $next($request);
            }

            // Return JSON for API or AJAX requests
            if ($request->expectsJson() || $request->is('api/*') || $request->ajax()) {
                return response()->json([
                    'status' => 'blocked',
                    'message' => 'Your IP address (' . $ip . ') has been blocked from accessing Kenyan Baddies Club.',
                    'ip' => $ip,
                ], 403);
            }

            // Render branded blocked IP error page
            if (view()->exists('errors.blocked-ip')) {
                return response()->view('errors.blocked-ip', ['ip' => $ip], 403);
            }

            return response('Access Denied: Your IP address (' . htmlspecialchars($ip) . ') has been restricted by administrators.', 403);
        }

        return $next($request);
    }
}
