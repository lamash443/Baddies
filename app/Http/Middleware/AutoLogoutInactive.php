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
    protected int $timeoutMinutes = 3; // ⚠️ TESTING: change back to 20 after testing

    public function handle(Request $request, Closure $next)
    {
        // Never intercept authentication, logout, registration, heartbeat, livewire, or admin panel routes.
        // Also skip Google OAuth routes so the OAuth state token stored in the session is preserved
        // between the initial redirect and the callback — interrupting it causes InvalidStateException.
        if (
            $request->is('login') ||
            $request->is('login/*') ||
            $request->is('logout') ||
            $request->is('register') ||
            $request->is('auth/google') ||
            $request->is('auth/google/*') ||
            $request->is('visitor/heartbeat') ||
            $request->is('visitor/*') ||
            $request->is('admin') ||
            $request->is('admin/*') ||
            $request->is('livewire') ||
            $request->is('livewire/*')
        ) {
            return $next($request);
        }

        // Never auto-logout admin users under any circumstances
        if ($request->user()?->is_admin || Auth::user()?->is_admin) {
            return $next($request);
        }

        if (Auth::check()) {
            $user = Auth::user();

            // Double-check: if user is admin, skip completely
            if ($user && $user->is_admin) {
                return $next($request);
            }

            $lastActivity = session('last_activity');

            if ($lastActivity && (time() - $lastActivity) >= ($this->timeoutMinutes * 60)) {
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
