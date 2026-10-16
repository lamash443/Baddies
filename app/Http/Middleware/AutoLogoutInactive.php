<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AutoLogoutInactive
{
    /**
     * Inactivity timeout in minutes before the user is automatically logged out.
     */
    protected int $timeoutMinutes = 30;

    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $lastActivity = session('last_activity');

            if ($lastActivity && (time() - $lastActivity) >= ($this->timeoutMinutes * 60)) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Session expired due to inactivity.'], 401);
                }

                return redirect('/')
                    ->with('status', 'You have been logged out due to 30 minutes of inactivity.');
            }

            // Update session last_activity on every authenticated request
            session(['last_activity' => time()]);
        }

        return $next($request);
    }
}
