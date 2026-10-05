<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        // If user logs back in, cancel any pending deletion request
        if (Auth::user()->deletion_requested_at) {
            Auth::user()->update(['deletion_requested_at' => null]);
            $request->session()->flash('login_success', 'Welcome back! Your account deletion request has been cancelled.');
        } else {
            $request->session()->flash('login_success', 'Welcome back, ' . $request->user()->name . '! You have successfully logged in.');
        }

        // Update last_seen_at to prevent immediate AutoLogoutInactive trigger for dormant accounts
        Auth::user()->update(['last_seen_at' => now()]);
        \Illuminate\Support\Facades\Cache::put('user_last_seen_' . Auth::id(), true, now()->addMinutes(2));

        $request->session()->regenerate();

        // Determine the intended destination — skip it if it points back to login or the landing page
        $intended = $request->session()->pull('url.intended');
        
        if ($intended) {
            $path = parse_url($intended, PHP_URL_PATH) ?? '/';
            $normalizedPath = rtrim($path, '/');
            
            // Only redirect to intended if it's a specific inner page (not root '/', not '/login')
            if ($normalizedPath !== '' && $normalizedPath !== '/login') {
                return redirect($intended);
            }
        }

        if ($request->user()->is_admin) {
            return redirect('/admin');
        }

        return redirect(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
