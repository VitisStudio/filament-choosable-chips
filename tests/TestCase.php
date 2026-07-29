<?php

namespace VitisStudio\FilamentChoosableChips\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Schemas\SchemasServiceProvider;
use Filament\Support\SupportServiceProvider;
use Livewire\LivewireServiceProvider;
use Livewire\Mechanisms\DataStore;
use Orchestra\Testbench\TestCase as Orchestra;
use VitisStudio\FilamentChoosableChips\FilamentChoosableChipsServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        view()->addNamespace('choosable-chips-tests', __DIR__.'/Fixtures/views');

        // Filament's SupportServiceProvider rebinds Livewire's DataStore via a plain
        // (non-shared) ->bind(DataStore::class, DataStoreOverride::class), which overwrites
        // the shared instance Livewire registers for it. In a normal HTTP request that's
        // fine, but under Livewire::test() every store($this) call (set/has/get) then
        // resolves a brand-new DataStore with an empty WeakMap, so the error bag set inside
        // getErrorBag() is never read back and SupportValidation::viewErrorBag() receives
        // null. Resolving the configured override once and pinning it as a shared instance
        // makes the per-component store persist across those calls again.
        $this->app->instance(DataStore::class, $this->app->make(DataStore::class));
    }

    protected function getPackageProviders($app)
    {
        return [
            LivewireServiceProvider::class,
            BladeIconsServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            SupportServiceProvider::class,
            ActionsServiceProvider::class,
            SchemasServiceProvider::class,
            FormsServiceProvider::class,
            InfolistsServiceProvider::class,
            FilamentChoosableChipsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        // Livewire snapshots are encrypted/signed, and Filament's badge view emits
        // @js() payloads, both of which need an application key. Testbench does not
        // provide one by default, so set a deterministic key for the test run.
        config()->set('app.key', 'base64:'.base64_encode(random_bytes(32)));
    }
}
