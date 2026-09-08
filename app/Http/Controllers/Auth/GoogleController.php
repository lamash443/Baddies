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
        $clientId     = SiteSetting::get('google_client_id', config('services.google.client_id'));
        $clientSecret = SiteSetting::get('google_client_secret', config('services.google.client_secret'));
        $redirectUri  = SiteSetting::get('google_redirect_uri', config('services.google.redirect', url('/auth/google/callback')));

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
    public function redirectToGoogle()
    {
        if (!$this->setupGoogleConfig()) {
            Log::warning('Google OAuth attempted, but credentials are missing in SiteSetting / .env');
            return redirect()->route('home')->with('error', 'Google Login is currently being configured. Please log in with email and password.');
        }

        try {
            return Socialite::driver('google')->redirect();
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

        try {
            $googleUser = Socialite::driver('google')->user();

            if (!$googleUser || !$googleUser->getEmail()) {
                return redirect()->route('home')->with('error', 'Could not retrieve user email from Google.');
            }

            // Find existing user by Google ID or Email
            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            if ($user) {
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

                Auth::login($user, true);

                activity()
                    ->causedBy($user)
                    ->log('Logged in via Google OAuth');

                return redirect()->intended(route('dashboard'))
                    ->with('success', 'Successfully logged in with Google!');
            }

            // Create new user if not found
            $newUser = User::create([
                'name'              => $googleUser->getName() ?: ($googleUser->getNickname() ?: 'Google User'),
                'email'             => $googleUser->getEmail(),
                'google_id'         => $googleUser->getId(),
                'avatar'            => $googleUser->getAvatar(),
                'password'          => Hash::make(Str::random(24)),
                'email_verified_at' => now(),
                'is_verified'       => false,
            ]);

            Auth::login($newUser, true);

            activity()
                ->causedBy($newUser)
                ->log('Registered account via Google OAuth');

            return redirect()->route('dashboard')
                ->with('success', 'Welcome to Kenyan Baddies Club! Your account has been created via Google.');

        } catch (\Exception $e) {
            Log::error('Google OAuth Callback Exception: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Google authentication failed: ' . $e->getMessage());
        }
    }
}
