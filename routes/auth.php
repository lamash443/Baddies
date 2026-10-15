
<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

    // Google Authentication
    Route::get('auth/google', [
        \App\Http\Controllers\Auth\GoogleController::class,
        'redirectToGoogle',
    ])->name('auth.google');

    Route::get('auth/google/callback', [
        \App\Http\Controllers\Auth\GoogleController::class,
        'handleGoogleCallback',
    ])->name('auth.google.callback');

    // Registration
    Route::get('register', [
        RegisteredUserController::class,
        'create',
    ])->name('register');

    Route::post('register', [
        RegisteredUserController::class,
        'store',
    ]);

    // Standard Login
    Route::get('login', function (Request $request) {
        if ($request->filled('ref')) {
            session(['ref_code' => $request->input('ref')]);

            return redirect()->route('referral.login', [
                'ref' => $request->input('ref'),
            ]);
        }

        return redirect('/?auth=login');
    })->name('login');

    Route::post('login', [
        AuthenticatedSessionController::class,
        'store',
    ])->name('login.post');

    // Referral Login Page
    Route::get('referral', function (Request $request) {
        if ($request->filled('ref')) {
            session(['ref_code' => $request->input('ref')]);
        }

        if ($request->filled('referral_code')) {
            session(['ref_code' => $request->input('referral_code')]);
        }

        $hasReferral = session()->has('ref_code');

        if ($hasReferral) {
            return view('auth.login');
        }

        return redirect('/?auth=login');
    })->name('referral.login');

    // Referral Login Submission
    Route::post('referral', [
        AuthenticatedSessionController::class,
        'store',
    ])->name('referral.store');

    // Password Reset
    Route::get('forgot-password', [
        PasswordResetLinkController::class,
        'create',
    ])->name('password.request');

    Route::post('forgot-password', [
        PasswordResetLinkController::class,
        'store',
    ])->name('password.email');

    Route::get('reset-password/{token}', [
        NewPasswordController::class,
        'create',
    ])->name('password.reset');

    Route::post('reset-password', [
        NewPasswordController::class,
        'store',
    ])->name('password.store');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {

    // Email Verification
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [
        EmailVerificationNotificationController::class,
        'store',
    ])->middleware('throttle:6,1')
        ->name('verification.send');

    // Password Confirmation
    Route::get('confirm-password', [
        ConfirmablePasswordController::class,
        'show',
    ])->name('password.confirm');

    Route::post('confirm-password', [
        ConfirmablePasswordController::class,
        'store',
    ]);

    // Update Password
    Route::put('password', [
        PasswordController::class,
        'update',
    ])->name('password.update');

    // Logout
    Route::post('logout', [
        AuthenticatedSessionController::class,
        'destroy',
    ])->name('logout');
});