<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AutoLogoutInactive
{
    /**
     * Inactivity timeout in minutes before the user is automatically logged out.
     * ⚠️ TESTING: set to 10 min — change back to 30 for production.
     */
    protected int $timeoutMinutes = 10;

    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $lastSeen = $user->last_seen_at;

            if ($lastSeen && now()->diffInMinutes($lastSeen) >= $this->timeoutMinutes) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Session expired due to inactivity.'], 401);
                }

                return redirect()->route('login')
                    ->with('status', 'You have been logged out due to 30 minutes of inactivity.');
            }
        }

        return $next($request);
    }
}
