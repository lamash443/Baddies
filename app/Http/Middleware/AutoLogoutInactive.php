<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AutoLogoutInactive
{
    /**
     * Inactivity timeout in minutes before the user is automatically logged out.
     */
    protected int $timeoutMinutes = 20;

    public function handle(Request $request, Closure $next)
    {
        // Never intercept authentication, logout, registration, heartbeat, or admin panel routes
        if (
            $request->is('login') ||
            $request->is('login/*') ||
            $request->is('logout') ||
            $request->is('register') ||
            $request->is('visitor/heartbeat') ||
            $request->is('visitor/*') ||
            $request->is('admin') ||
            $request->is('admin/*')
        ) {
            return $next($request);
        }

        if (Auth::check()) {
            $lastActivity = session('last_activity');

            if ($lastActivity && (time() - $lastActivity) >= ($this->timeoutMinutes * 60)) {
                $user = Auth::user();

                Auth::guard('web')->logout();

                if ($user) {
                    $user->forceFill(['remember_token' => null])->saveQuietly();
                }

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                $cookie = Cookie::forget(Auth::guard('web')->getRecallerName());

                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Session expired due to inactivity.'], 401);
                }

                return redirect('/')
                    ->withCookie($cookie)
                    ->with('toast_type', 'warning')
                    ->with('toast_title', 'Session Expired')
                    ->with('toast_msg', 'You have been logged out due to inactivity.');
            }

            // Update session last_activity on every authenticated request
            session(['last_activity' => time()]);
        }

        return $next($request);
    }
}
