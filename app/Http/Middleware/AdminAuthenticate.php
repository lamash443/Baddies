<?php

namespace App\Http\Middleware;

use Filament\Facades\Filament;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Http\Request;

class AdminAuthenticate extends Authenticate
{
    protected function authenticate($request, array $guards): void
    {
        $guard = Filament::auth();

        // Not logged in at all → redirect to normal login page
        if (! $guard->check()) {
            $this->unauthenticated($request, $guards);
            return;
        }

        $user = $guard->user();

        // Logged in but NOT an admin → redirect to user dashboard silently
        if (! $user->is_admin) {
            redirect()->route('dashboard')->send();
            exit;
        }

        // Admin user → let Filament handle it normally
        parent::authenticate($request, $guards);
    }

    protected function redirectTo($request): ?string
    {
        // Unauthenticated users go to the standard site login
        return route('login');
    }
}
