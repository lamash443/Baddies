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
        $middleware->append(\App\Http\Middleware\TrackVisitor::class);
        $middleware->append(\App\Http\Middleware\UpdateLastSeen::class);
        $middleware->append(\App\Http\Middleware\AutoLogoutInactive::class);
        $middleware->validateCsrfTokens(except: [
            'webhook/payhero',
        ]);

        // Send unauthenticated users directly to the homepage login modal.
        // Skipping the /login GET route avoids a double-redirect that can
        // fragment the session on shared-hosting DB backends (Truehost).
        $middleware->redirectGuestsTo(fn ($request) => '/?auth=login');

        // Send already-authenticated users who hit guest-only routes to dashboard.
        $middleware->redirectUsersTo(fn ($request) => route('dashboard'));
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

                return redirect('/?auth=login')->with('error', 'Your session has expired. Please log in again.');
            }
        });
    })->create();
