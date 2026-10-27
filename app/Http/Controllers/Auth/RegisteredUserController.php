<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeEmail;
use App\Support\MailHelper;
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
        if (Auth::check()) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

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

        // ── Full Name Validation & Limits ────────────────────────────────────
        $rawName = trim((string) $request->input('name', ''));
        $emojiPattern = '/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{1F700}-\x{1F7FF}\x{1F800}-\x{1F8FF}\x{1F900}-\x{1F9FF}\x{1FA00}-\x{1FA6F}\x{1FA70}-\x{1FAFF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}\x{2300}-\x{23FF}]/u';

        // Disallow digits (0-9), emojis, and all other punctuation/symbols except hyphen, apostrophe, period
        if (
            preg_match('/[0-9]/', $rawName) ||
            preg_match($emojiPattern, $rawName) ||
            preg_match('/[^a-zA-Z\s\-\'\.]/', $rawName)
        ) {
            return redirect()->back()
                ->withErrors(['name' => 'Please enter a valid full name. Numbers, emojis, and special symbols are not allowed.'])
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('toast_type',  'warning')
                ->with('toast_title', 'Invalid Name')
                ->with('toast_msg',   'Please enter a valid full name. Numbers, emojis, and special symbols are not allowed.');
        }

        if (mb_strlen($rawName) < 2 || mb_strlen($rawName) > 40) {
            return redirect()->back()
                ->withErrors(['name' => 'Full name must be between 2 and 40 characters.'])
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('toast_type',  'warning')
                ->with('toast_title', 'Invalid Name')
                ->with('toast_msg',   'Full name must be between 2 and 40 characters.');
        }

        $cleanName = trim(preg_replace('/\s+/', ' ', $rawName), " -'.");
        $request->merge(['name' => $cleanName]);

        // Email: alphanumeric, @, ., _, -, + only (max 40 chars)
        $rawEmail = (string) $request->input('email', '');
        $cleanEmail = strtolower(trim(preg_replace('/[^a-zA-Z0-9@._\-+]/', '', $rawEmail)));
        $cleanEmail = mb_substr($cleanEmail, 0, 40);
        $request->merge(['email' => $cleanEmail]);

        // Password & Confirm: safe alphanumeric + specific password punctuation (@$#&!%*?._\-+=~), max 12 chars
        $rawPassword = (string) $request->input('password', '');
        $cleanPassword = preg_replace('/[^a-zA-Z0-9@$#&!%*?._\-+=~]/', '', $rawPassword);
        $cleanPassword = mb_substr($cleanPassword, 0, 12);

        $rawConfirm = (string) $request->input('password_confirmation', '');
        $cleanConfirm = preg_replace('/[^a-zA-Z0-9@$#&!%*?._\-+=~]/', '', $rawConfirm);
        $cleanConfirm = mb_substr($cleanConfirm, 0, 12);

        $request->merge([
            'password' => $cleanPassword,
            'password_confirmation' => $cleanConfirm,
        ]);

        $email = $cleanEmail;
        if ($email && User::where('email', $email)->exists()) {
            return redirect()->back()
                ->withErrors(['email' => 'This email address is already registered. Please log in instead.'])
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('toast_type',  'warning')
                ->with('toast_title', 'Email Already Registered')
                ->with('toast_msg',   'This email address is already registered. Please log in instead or use another email.');
        }

        if (Auth::check()) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:40', 'regex:/^[a-zA-Z\s\-\'\.]+$/'],
            'email' => ['required', 'string', 'lowercase', 'email:rfc', 'max:40', 'unique:'.User::class],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:12',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\d$@#&!%*?._\-+=~])[a-zA-Z0-9$@#&!%*?._\-+=~]{8,12}$/',
            ],
        ], [
            'name.required' => 'Please enter your full name.',
            'name.min' => 'Full name must be at least 2 characters.',
            'name.max' => 'Full name cannot exceed 40 characters.',
            'name.regex' => 'Full name may only contain letters, spaces, hyphens, apostrophes, and periods.',
            'email.required' => 'Please enter your email address.',
            'email.max' => 'Email address cannot exceed 40 characters.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email address is already registered. Please log in instead.',
            'password.required' => 'Please enter a password.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.max' => 'Password cannot exceed 12 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.regex' => 'The password must be 8 to 12 characters long and contain at least one uppercase letter, one lowercase letter, and one number or symbol.',
        ]);

        // Resolve referrer from URL param, form field, or session
        $refCode  = $request->input('ref') ?? $request->input('referral_code') ?? session('ref_code');
        $referrer = null;
        if ($refCode) {
            $referrer = User::where('referral_code', trim($refCode))->first();
            session()->forget('ref_code');
        }

        // Check for self-referral / IP abuse
        $currentIp = $request->ip();
        if ($referrer) {
            // Prevent if referrer's registration IP matches current IP
            if ($referrer->registration_ip === $currentIp) {
                $referrer = null;
            } else {
                // Also prevent if any other user has already registered with this IP
                $ipExists = User::where('registration_ip', $currentIp)->exists();
                if ($ipExists) {
                    $referrer = null;
                }
            }
        }

        $user = User::create([
            'name'            => $request->name,
            'email'           => $request->email,
            'password'        => Hash::make($request->password),
            'registration_ip' => $currentIp,
            'referred_by_id'  => $referrer?->id,
        ]);

        // event(new Registered($user)); // Disabled to prevent Laravel from sending the default plain-text verification email

        Auth::login($user);
        session(['last_activity' => time()]);
        session()->flash('login_success', 'Welcome to Baddies Club, ' . $user->name . '! Your account has been created.');

        // ── Send welcome + verification email ─────────────────────────────────
        $this->sendWelcomeEmail($user);

        return redirect('/dashboard');
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

            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(60),
                ['id' => $user->id, 'hash' => sha1($user->email)]
            );

            // Build the mailable first — all SiteSetting DB calls happen here
            // inside the try-catch so any error is properly logged
            $mailable = new WelcomeEmail($user, $verificationUrl);

            $log->info('[WelcomeEmail] SMTP — host: ' . config('mail.mailers.smtp.host') . ' port: ' . config('mail.mailers.smtp.port') . ' user: ' . config('mail.mailers.smtp.username'));

            // Apply admin-panel SMTP settings (with .env fallback) then send
            // Use mailer('smtp') explicitly — same pattern as the working TestSmtp command
            MailHelper::applySmtpSettings();

            $log->info('[WelcomeEmail] Calling Mail::mailer(smtp)->to()->send() now...');

            Mail::mailer('smtp')
                ->to($user->email, $user->name)
                ->send($mailable);

            // ── Log success ──────────────────────────────────────────────────
            \App\Models\EmailLog::create([
                'user_id'        => $user->id,
                'recipient_email'=> $user->email,
                'recipient_name' => $user->name,
                'subject'        => $mailable->emailSubject,
                'type'           => 'welcome',
                'status'         => 'sent',
            ]);

            $log->info('[WelcomeEmail] SUCCESS — email sent to ' . $user->email);

        } catch (\Throwable $e) {
            // Catch Throwable (not just Exception) to also catch PHP fatal errors
            $log->error('[WelcomeEmail] FAILED for user ' . $user->id . ': ' . $e->getMessage() . ' | ' . $e->getFile() . ':' . $e->getLine());

            // ── Log failure ──────────────────────────────────────────────────
            \App\Models\EmailLog::create([
                'user_id'        => $user->id,
                'recipient_email'=> $user->email,
                'recipient_name' => $user->name,
                'subject'        => 'Welcome to Baddies Club',
                'type'           => 'welcome',
                'status'         => 'failed',
                'error_message'  => $e->getMessage() . ' (' . basename($e->getFile()) . ':' . $e->getLine() . ')',
            ]);
        }
    }

}
