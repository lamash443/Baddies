<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');
        $middleware->web(prepend: [
            \App\Http\Middleware\BlockIpMiddleware::class,
        ], append: [
            \App\Http\Middleware\TrackVisitor::class,
            \App\Http\Middleware\UpdateLastSeen::class,
            \App\Http\Middleware\AutoLogoutInactive::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            'webhook/payhero',
            'webhook/payhero/*',
            'api/webhook/payhero',
            'api/webhook/payhero/*',
            'payhero/webhook',
            'payhero/webhook/*',
            'payhero/callback',
            'payhero/callback/*',
            'api/payhero/webhook',
            'api/payhero/callback',
            'payment/callback',
            'payment/callback/*',
            'payment/webhook',
            'payment/webhook/*',
            'api/payment/callback',
            'api/payment/webhook',
            'callback/payhero',
            'payhero-callback',
            'mpesa/callback',
            'mpesa/callback/*',
            'mpesa/webhook',
            'mpesa/webhook/*',
            'api/mpesa/callback',
            'api/mpesa/webhook',
            'callback',
            'api/callback',
            'webhook',
            'api/webhook',
            'server-setup',
            'visitor/heartbeat',
            'visitor/*',
            'api/*',
            'logout',
        ]);

        // Send unauthenticated users to the landing page without popping up login modal
        $middleware->redirectGuestsTo(fn ($request) => '/');

        // Send already-authenticated users who hit guest-only routes to dashboard.
        $middleware->redirectUsersTo(fn ($request) => '/dashboard');
    })

    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, \Illuminate\Http\Request $request) {
            if ($e->getStatusCode() === 419) {
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Page Expired.'], 419);
                }

                return redirect('/')->with('toast_type', 'warning')
                    ->with('toast_title', 'Session Expired')
                    ->with('toast_msg', 'Your session has expired. Please log in again.');
            }
        });
    })->create();
