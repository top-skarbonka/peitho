<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // tutaj na razie nic nie potrzeba
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Wymuszenie HTTPS w środowisku produkcyjnym
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
