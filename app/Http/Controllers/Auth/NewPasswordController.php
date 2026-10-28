<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        // Validate the token exists before showing the form — catches expired tokens on GET
        $token = $request->route('token');
        $email = $request->query('email', '');

        $tokenExpired = false;
        if ($token && $email) {
            $user = \App\Models\User::where('email', $email)->first();
            if ($user) {
                $tokenExpired = !\Illuminate\Support\Facades\Password::tokenExists($user, $token);
            }
        }

        return view('auth.reset-password', [
            'request'      => $request,
            'tokenExpired' => $tokenExpired,
        ]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Sanitize email and password inputs
        $rawEmail = (string) $request->input('email', '');
        $cleanEmail = strtolower(trim(preg_replace('/[^a-zA-Z0-9@._\-+]/', '', $rawEmail)));
        $cleanEmail = mb_substr($cleanEmail, 0, 40);

        $rawPassword = (string) $request->input('password', '');
        $cleanPassword = preg_replace('/[^a-zA-Z0-9@$#&!%*?._\-+=~]/', '', $rawPassword);
        $cleanPassword = mb_substr($cleanPassword, 0, 12);

        $rawConfirm = (string) $request->input('password_confirmation', '');
        $cleanConfirm = preg_replace('/[^a-zA-Z0-9@$#&!%*?._\-+=~]/', '', $rawConfirm);
        $cleanConfirm = mb_substr($cleanConfirm, 0, 12);

        $request->merge([
            'email' => $cleanEmail,
            'password' => $cleanPassword,
            'password_confirmation' => $cleanConfirm,
        ]);

        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email:rfc', 'max:40'],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:12',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\d$@#&!%*?._\-+=~])[a-zA-Z0-9$@#&!%*?._\-+=~]{8,12}$/',
            ],
        ], [
            'email.required' => 'Please enter your email address.',
            'email.max' => 'Email address cannot exceed 40 characters.',
            'email.email' => 'Please provide a valid email address.',
            'password.required' => 'Please enter a password.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.max' => 'Password cannot exceed 12 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.regex' => 'The password must be 8 to 12 characters long and contain at least one uppercase letter, one lowercase letter, and one number or symbol.',
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        }

        // Expired or invalid token — show a dedicated expiry notice
        if ($status === Password::INVALID_TOKEN) {
            return back()
                ->withInput($request->only('email'))
                ->with('link_expired', true);
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}
