<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UpdateLastSeen
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $userId = Auth::id();
            // Only update DB every 2 minutes to reduce writes; use cache as a gate
            if (!Cache::has('user_last_seen_' . $userId)) {
                Auth::user()->update(['last_seen_at' => now()]);
                Cache::put('user_last_seen_' . $userId, true, now()->addMinutes(2));
            }
        }

        return $next($request);
    }
}
