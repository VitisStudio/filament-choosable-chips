<?php

namespace App\Providers;

use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
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
        // The demo uses a few colors that aren't registered by default.
        FilamentColor::register([
            'indigo' => Color::Indigo,
            'purple' => Color::Purple,
            'teal' => Color::Teal,
            'cyan' => Color::Cyan,
        ]);
    }
}
