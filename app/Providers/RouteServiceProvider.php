<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->routes(function () {

            // ROUTY WEB (panel firmy, admin itd.)
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            // ROUTY PUBLICZNE (rejestracja kart klientów)
            Route::middleware('web')
                ->group(base_path('routes/public.php'));

            // API (jeśli kiedyś będzie)
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        });
    }
}
