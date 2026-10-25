<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set remember-me login persistence cookie duration to 10,080 minutes (7 days / 1 week)
        if (Auth::guard('web') instanceof \Illuminate\Auth\SessionGuard) {
            Auth::guard('web')->setRememberDuration(10080);
        }
    }
}
