<?php

namespace VitisStudio\FilamentChoosableChips;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentChoosableChipsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-choosable-chips')
            ->hasViews();
    }
}
