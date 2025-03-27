<?php

namespace App\Providers;

use App\Enums\CodeStatus;
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
        // dd(array_map( fn($case) => $case->value, CodeStatus::cases()));
    }
}
