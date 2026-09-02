<?php

namespace App\Providers;

use App\Http\View\Composers\SiteSettingsComposer;
use App\Http\Responses\Filament\LogoutResponse as FilamentLogoutResponse;
use Filament\Auth\Http\Responses\Contracts\LogoutResponse as LogoutResponseContract;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            LogoutResponseContract::class,
            FilamentLogoutResponse::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Inject site settings into front-end views only (exclude admin/Filament views)
        if (!request()->is('admin') && !request()->is('admin/*')) {
            View::composer('*', SiteSettingsComposer::class);
        }

        // Log user logins
        Event::listen(Login::class, function (Login $event) {
            activity()
                ->causedBy($event->user)
                ->withProperties([
                    'ip' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ])
                ->log('User logged in');
        });

        // Log user logouts
        Event::listen(Logout::class, function (Logout $event) {
            if ($event->user) {
                activity()
                    ->causedBy($event->user)
                    ->withProperties([
                        'ip' => request()->ip(),
                    ])
                    ->log('User logged out');
            }
        });
    }
}
