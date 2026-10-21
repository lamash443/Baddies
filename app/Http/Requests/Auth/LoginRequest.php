<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Strip emojis from input fields before validation.
     */
    protected function prepareForValidation(): void
    {
        $emojiPattern = '/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{1F700}-\x{1F7FF}\x{1F800}-\x{1F8FF}\x{1F900}-\x{1F9FF}\x{1FA00}-\x{1FA6F}\x{1FA70}-\x{1FAFF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}\x{2300}-\x{23FF}]/u';
        $inputs = $this->all();
        foreach ($inputs as $key => $value) {
            if (is_string($value)) {
                $inputs[$key] = preg_replace($emojiPattern, '', $value);
            }
        }

        // Email sanitization: lowercase, allowed email punctuation only (@._-+), max 40 chars
        if (isset($inputs['email']) && is_string($inputs['email'])) {
            $cleanEmail = strtolower(trim(preg_replace('/[^a-zA-Z0-9@._\-+]/', '', $inputs['email'])));
            $inputs['email'] = mb_substr($cleanEmail, 0, 40);
        }

        // Password sanitization: remove spaces and dangerous characters (<>'"`), max 64 chars
        if (isset($inputs['password']) && is_string($inputs['password'])) {
            $cleanPassword = preg_replace('/[\s\'\"\`\<\>]/', '', $inputs['password']);
            $inputs['password'] = mb_substr($cleanPassword, 0, 64);
        }

        $this->replace($inputs);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email:rfc', 'max:40'],
            'password' => ['required', 'string', 'max:64'],
        ];
    }

    /**
     * Custom validation error messages.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email address cannot exceed 40 characters.',
            'password.required' => 'Please enter your password.',
            'password.max' => 'Password cannot exceed 64 characters.',
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $email = strtolower(trim((string) $this->input('email')));
        $user = User::where('email', $email)->first();

        if (! $user) {
            RateLimiter::hit($this->throttleKey());

            session()->flash('toast_type', 'warning');
            session()->flash('toast_title', 'Email Not Registered');
            session()->flash('toast_msg', 'No account exists with this email address. Please check your spelling or sign up.');

            throw ValidationException::withMessages([
                'email' => 'No account exists with this email address. Please sign up.',
            ]);
        }

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            session()->flash('toast_type', 'danger');
            session()->flash('toast_title', 'Incorrect Password');
            session()->flash('toast_msg', 'The password you entered is incorrect. Please try again or click Forgot Password.');

            throw ValidationException::withMessages([
                'email' => 'The password you entered is incorrect. Please try again.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email')).'|'.$this->ip());
    }
}