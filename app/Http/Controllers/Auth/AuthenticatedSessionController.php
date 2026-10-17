<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
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
        // If an already-authenticated session exists, log them out cleanly first
        // so that new credentials are fully validated and authenticated
        if (Auth::check()) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        $email = strtolower(trim((string) $request->input('email')));
        $user = User::where('email', $email)->first();

        if (! $user) {
            RateLimiter::hit($request->throttleKey());

            return redirect()->back()
                ->withErrors(['email' => 'No account exists with this email address. Please sign up.'])
                ->withInput($request->only('email', 'remember'))
                ->with('toast_type',  'warning')
                ->with('toast_title', 'Email Not Registered')
                ->with('toast_msg',   'No account exists with this email address. Please check your spelling or sign up.');
        }

        try {
            $request->authenticate();
        } catch (ValidationException $e) {
            $errorMsg = $e->errors()['email'][0] ?? 'Authentication failed.';
            $isNotReg = stripos($errorMsg, 'No account exists') !== false || stripos($errorMsg, 'not registered') !== false;

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput($request->only('email', 'remember'))
                ->with('toast_type',  $isNotReg ? 'warning' : 'danger')
                ->with('toast_title', $isNotReg ? 'Email Not Registered' : 'Incorrect Password')
                ->with('toast_msg',   $isNotReg
                    ? 'No account exists with this email address. Please check your spelling or sign up.'
                    : 'The password you entered is incorrect. Please try again or click Forgot Password.');
        }

        // Pull url.intended BEFORE session regenerate to avoid losing it on
        // shared-hosting DB backends where the old session row may be deleted
        // before the new one is committed, causing the next request to see an
        // empty session and treat the user as a guest.
        $intended = $request->session()->pull('url.intended');

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

        // Set last_activity and regenerate session
        session(['last_activity' => time()]);
        $request->session()->regenerate();
        $request->session()->put('last_activity', time());
        $request->session()->save();

        if ($request->user()->is_admin) {
            return redirect('/admin');
        }

        // Only redirect to intended destination if it is an explicit authenticated member area
        if ($intended) {
            $path = parse_url($intended, PHP_URL_PATH) ?? '/';
            $normalizedPath = '/' . trim($path, '/');

            $allowedMemberPrefixes = [
                '/dashboard',
                '/profile',
                '/wallet',
                '/chat',
                '/verification',
                '/user-photos',
                '/user-videos',
                '/classifieds/create',
            ];
            foreach ($allowedMemberPrefixes as $prefix) {
                if (str_starts_with($normalizedPath, $prefix)) {
                    return redirect($normalizedPath);
                }
            }
        }

        return redirect('/dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();

        Auth::guard('web')->logout();

        if ($user) {
            $user->forceFill(['remember_token' => null])->saveQuietly();
        }

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $cookie = \Illuminate\Support\Facades\Cookie::forget(Auth::guard('web')->getRecallerName());

        return redirect('/')
            ->withCookie($cookie)
            ->with('toast_type', 'success')
            ->with('toast_title', 'Logged Out')
            ->with('toast_msg', 'You have been successfully logged out.');
    }
}
