<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeEmail;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     * Stores the referral code in session so it survives browsing before registering.
     */
    public function create(Request $request): View
    {
        if ($request->filled('ref') && ! session()->has('ref_code')) {
            session(['ref_code' => $request->input('ref')]);
        }
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $emojiPattern = '/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{1F700}-\x{1F7FF}\x{1F800}-\x{1F8FF}\x{1F900}-\x{1F9FF}\x{1FA00}-\x{1FA6F}\x{1FA70}-\x{1FAFF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}\x{2300}-\x{23FF}]/u';
        foreach ($request->all() as $key => $value) {
            if (is_string($value)) {
                $request->merge([$key => preg_replace($emojiPattern, '', $value)]);
            }
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\d$@#&!%*?]).{8,}$/'],
        ], [
            'password.regex' => 'The password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number or symbol.',
        ]);

        // Resolve referrer from URL param, form field, or session
        $refCode  = $request->input('ref') ?? $request->input('referral_code') ?? session('ref_code');
        $referrer = null;
        if ($refCode) {
            $referrer = User::where('referral_code', trim($refCode))->first();
            session()->forget('ref_code');
        }

        $user = User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'referred_by_id' => $referrer?->id,
        ]);

        // event(new Registered($user)); // Disabled to prevent Laravel from sending the default plain-text verification email

        Auth::login($user);

        // ── Send welcome + verification email ─────────────────────────────────
        $this->sendWelcomeEmail($user);

        return redirect(route('dashboard', absolute: false));
    }

    /**
     * Apply admin-panel SMTP settings and dispatch the welcome email
     * containing the signed email verification URL.
     */
    protected function sendWelcomeEmail(User $user): void
    {
        $log = \Illuminate\Support\Facades\Log::channel('single');

        try {
            $log->info('[WelcomeEmail] Starting for user: ' . $user->id . ' / ' . $user->email);

            $mailer      = SiteSetting::get('mail_mailer', config('mail.default', 'smtp'));
            $host        = SiteSetting::get('mail_host', config('mail.mailers.smtp.host'));
            $port        = SiteSetting::get('mail_port', config('mail.mailers.smtp.port', 587));
            $encryption  = SiteSetting::get('mail_encryption', config('mail.mailers.smtp.encryption', 'tls'));
            $username    = SiteSetting::get('mail_username', config('mail.mailers.smtp.username'));
            $password    = SiteSetting::get('mail_password', config('mail.mailers.smtp.password'));
            $fromAddress = SiteSetting::get('mail_from_address', config('mail.from.address', 'noreply@baddiesclub.com'));
            $fromName    = SiteSetting::get('mail_from_name', config('mail.from.name', 'Baddies Club'));
            $subject     = SiteSetting::get('welcome_email_subject', 'Welcome to Baddies Club');

            $log->info('[WelcomeEmail] SMTP — host: ' . $host . ' port: ' . $port . ' user: ' . $username);

            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(60),
                ['id' => $user->id, 'hash' => sha1($user->email)]
            );

            config([
                'mail.default'                 => $mailer,
                'mail.mailers.smtp.host'       => $host,
                'mail.mailers.smtp.port'       => (int) $port,
                'mail.mailers.smtp.encryption' => $encryption ?: null,
                'mail.mailers.smtp.username'   => $username,
                'mail.mailers.smtp.password'   => $password,
                'mail.from.address'            => $fromAddress,
                'mail.from.name'               => $fromName,
            ]);

            $log->info('[WelcomeEmail] Calling Mail::to()->send() now...');

            Mail::to($user->email, $user->name)
                ->send(new WelcomeEmail($user, $verificationUrl));

            // ── Log success ──────────────────────────────────────────────────
            \App\Models\EmailLog::create([
                'user_id'        => $user->id,
                'recipient_email'=> $user->email,
                'recipient_name' => $user->name,
                'subject'        => $subject,
                'type'           => 'welcome',
                'status'         => 'sent',
            ]);

            $log->info('[WelcomeEmail] SUCCESS — email sent to ' . $user->email);

        } catch (\Exception $e) {
            $log->error('[WelcomeEmail] FAILED for user ' . $user->id . ': ' . $e->getMessage());

            // ── Log failure ──────────────────────────────────────────────────
            \App\Models\EmailLog::create([
                'user_id'        => $user->id,
                'recipient_email'=> $user->email,
                'recipient_name' => $user->name,
                'subject'        => 'Welcome to Baddies Club',
                'type'           => 'welcome',
                'status'         => 'failed',
                'error_message'  => $e->getMessage(),
            ]);
        }
    }

}
