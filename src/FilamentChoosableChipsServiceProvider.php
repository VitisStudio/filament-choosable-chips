<?php

namespace VitisStudio\FilamentChoosableChips;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use VitisStudio\FilamentChoosableChips\Commands\FilamentChoosableChipsCommand;

class FilamentChoosableChipsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('filament-choosable-chips')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_filament_choosable_chips_table')
            ->hasCommand(FilamentChoosableChipsCommand::class);
    }
}
