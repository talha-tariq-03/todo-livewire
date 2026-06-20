<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Livewire\Volt\Volt;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Volt::mount([
            resource_path('views/livewire'),
            resource_path('views/components'),
        ]);

        RateLimiter::for('resend-emails', function ($job) {
            return Limit::perSecond(1);
        });
    }
}