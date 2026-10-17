<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Set up dynamic Google config from SiteSetting if available.
     */
    protected function setupGoogleConfig(): bool
    {
        $clientId     = SiteSetting::get('google_client_id') ?: config('services.google.client_id');
        $clientSecret = SiteSetting::get('google_client_secret') ?: config('services.google.client_secret');
        $redirectUri  = SiteSetting::get('google_redirect_uri') ?: config('services.google.redirect');

        if (empty($redirectUri) || str_contains($redirectUri, '127.0.0.1') || str_contains($redirectUri, 'localhost')) {
            $redirectUri = 'https://kenyanbaddies.com/auth/google/callback';
        }

        // Always force HTTPS for live domain
        if (str_contains($redirectUri, 'kenyanbaddies.com') && str_starts_with($redirectUri, 'http://')) {
            $redirectUri = 'https://' . substr($redirectUri, 7);
        }

        $redirectUri = rtrim($redirectUri, '/');

        if (empty($clientId) || empty($clientSecret)) {
            return false;
        }

        config([
            'services.google.client_id'     => $clientId,
            'services.google.client_secret' => $clientSecret,
            'services.google.redirect'      => $redirectUri,
        ]);

        return true;
    }

    /**
     * Redirect user to Google OAuth page.
     */
    public function redirectToGoogle(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            Auth::guard('web')->logout();
            if ($user) {
                $user->forceFill(['remember_token' => null])->saveQuietly();
            }
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        // Determine mode: 'login' or 'register'
        $mode = $request->query('mode') === 'register' ? 'register' : 'login';
        session(['google_auth_mode' => $mode]);

        if (!$this->setupGoogleConfig()) {
            Log::warning('Google OAuth attempted, but credentials are missing in SiteSetting / .env');
            return redirect()->route('home')->with('error', 'Google Login is currently being configured. Please log in with email and password.');
        }

        try {
            return Socialite::driver('google')
                ->with(['prompt' => 'select_account'])
                ->redirect();
        } catch (\Exception $e) {
            Log::error('Google OAuth Redirect Error: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Could not connect to Google authentication. Please try again.');
        }
    }

    /**
     * Handle Google OAuth Callback.
     */
    public function handleGoogleCallback()
    {
        if (!$this->setupGoogleConfig()) {
            return redirect()->route('home')->with('error', 'Google authentication credentials missing.');
        }

        $mode = session()->pull('google_auth_mode', 'login');

        try {
            $googleUser = Socialite::driver('google')->user();

            if (!$googleUser || !$googleUser->getEmail()) {
                return redirect()->route('home')->with('error', 'Could not retrieve user email from Google.');
            }

            $googleEmail = strtolower(trim((string) $googleUser->getEmail()));

            // Find existing user by Google ID or Email
            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleEmail)
                ->first();

            // ── SCENARIO 1: User clicked "Sign up with Google" (mode === 'register') ──
            if ($mode === 'register') {
                if ($user) {
                    // User email already in the system: reject signup, display toast, do NOT redirect to dashboard
                    return redirect('/?auth=login')
                        ->withErrors(['email' => 'This email address is already registered. Please log in instead.'])
                        ->with('toast_type',  'warning')
                        ->with('toast_title', 'Email Already Registered')
                        ->with('toast_msg',   'This Google email (' . $googleEmail . ') is already registered. Please log in instead.');
                }

                // Create new user if not found
                $currentIp = request()->ip();
                $refCode   = session('ref_code');
                $referrer  = null;

                if ($refCode) {
                    $referrer = User::where('referral_code', trim($refCode))->first();
                    session()->forget('ref_code');

                    // Block referral if same IP
                    if ($referrer) {
                        if ($referrer->registration_ip === $currentIp) {
                            $referrer = null;
                        } elseif (User::where('registration_ip', $currentIp)->exists()) {
                            $referrer = null;
                        }
                    }
                }

                $newUser = User::create([
                    'name'              => $googleUser->getName() ?: ($googleUser->getNickname() ?: 'Google User'),
                    'email'             => $googleEmail,
                    'google_id'         => $googleUser->getId(),
                    'avatar'            => $googleUser->getAvatar(),
                    'password'          => Hash::make(Str::random(24)),
                    'email_verified_at' => now(),
                    'is_verified'       => false,
                    'registration_ip'   => $currentIp,
                    'referred_by_id'    => $referrer?->id,
                ]);

                Auth::login($newUser, false);
                session(['last_activity' => time()]);
                request()->session()->save();

                activity()
                    ->causedBy($newUser)
                    ->log('Registered account via Google OAuth');

                return redirect('/dashboard')
                    ->with('login_success', 'Welcome to Kenyan Baddies Club, ' . $newUser->name . '! Your account has been created via Google.');
            }

            // ── SCENARIO 2: User clicked "Log in with Google" (mode === 'login') ──
            if (! $user) {
                // User can NOT signup by clicking Google auth login
                return redirect('/?auth=register')
                    ->withErrors(['email' => 'No account exists with this Google email. Please sign up first.'])
                    ->with('toast_type',  'warning')
                    ->with('toast_title', 'Email Not Registered')
                    ->with('toast_msg',   'No account exists for ' . $googleEmail . '. Please sign up first to create an account.');
            }

            // Update existing user with Google ID and avatar if missing
            $updateData = [];
            if (empty($user->google_id)) {
                $updateData['google_id'] = $googleUser->getId();
            }
            if (empty($user->avatar)) {
                $updateData['avatar'] = $googleUser->getAvatar();
            }
            if (empty($user->email_verified_at)) {
                $updateData['email_verified_at'] = now();
            }

            if (!empty($updateData)) {
                $user->update($updateData);
            }

            if ($user->deletion_requested_at) {
                $user->update(['deletion_requested_at' => null]);
            }

            Auth::login($user, false);
            session(['last_activity' => time()]);
            request()->session()->save();

            activity()
                ->causedBy($user)
                ->log('Logged in via Google OAuth');

            if ($user->is_admin) {
                return redirect('/admin');
            }

            $intended = session()->pull('url.intended');
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
                        return redirect($normalizedPath)->with('login_success', 'Welcome back, ' . $user->name . '! Successfully logged in with Google.');
                    }
                }
            }

            return redirect('/dashboard')
                ->with('login_success', 'Welcome back, ' . $user->name . '! Successfully logged in with Google.');

        } catch (\Exception $e) {
            Log::error('Google OAuth Callback Exception: ' . $e->getMessage());
            return redirect('/?auth=login')->with('error', 'Google authentication failed: ' . $e->getMessage());
        }
    }
}
