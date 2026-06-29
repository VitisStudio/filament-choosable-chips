<?php

namespace VitisStudio\FilamentChoosableChips\Tests\Fixtures;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use VitisStudio\FilamentChoosableChips\Forms\Components\ChoosableChips;

/**
 * Minimal Livewire host used to mount the ChoosableChips field inside a real
 * Filament schema for state/rendering assertions.
 */
class ChipsTestComponent extends Component implements HasForms
{
    use InteractsWithForms;

    /**
     * @var array<string, mixed>
     */
    public array $data = [];

    public bool $multiple = false;

    public bool $checkSelected = false;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                ChoosableChips::make('flavor')
                    ->options([
                        'blue' => 'Blue',
                        'red' => 'Red',
                        'green' => 'Green',
                    ])
                    ->colors([
                        'blue' => 'info',
                        'red' => 'danger',
                        'green' => 'success',
                    ])
                    ->icons([
                        'blue' => 'heroicon-o-sparkles',
                    ])
                    ->checkSelected($this->checkSelected)
                    ->multiple($this->multiple),
            ]);
    }

    public function render(): View
    {
        return view('choosable-chips-tests::test-component');
    }
}
