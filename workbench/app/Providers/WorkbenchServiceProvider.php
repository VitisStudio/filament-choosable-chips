<?php

namespace Workbench\App\Providers;

use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Support\ServiceProvider;

class WorkbenchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Make the extra palette names used by the demo chips resolvable.
        FilamentColor::register([
            'indigo' => Color::Indigo,
            'purple' => Color::Purple,
            'teal' => Color::Teal,
            'cyan' => Color::Cyan,
        ]);
    }
}
