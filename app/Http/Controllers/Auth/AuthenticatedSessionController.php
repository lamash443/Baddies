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

        // Block login if user has a pending account deletion request
        if (Auth::user()->deletion_requested_at) {
            Auth::guard('web')->logout();

            return redirect('/?deletion_pending=1');
        }

        $request->session()->regenerate();

        $request->session()->flash('login_success', 'Welcome back, ' . $request->user()->name . '! You have successfully logged in.');

        // Determine the intended destination — skip it if it points back to login
        $intended = $request->session()->pull('url.intended');
        $loginUrl = route('login');
        if ($intended && $intended !== $loginUrl && !str_contains($intended, '/login')) {
            return redirect($intended);
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
