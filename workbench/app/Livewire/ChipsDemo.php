<?php

namespace Workbench\App\Livewire;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use VitisStudio\FilamentChoosableChips\Forms\Components\ChoosableChips;

class ChipsDemo extends Component implements HasForms
{
    use InteractsWithForms;

    /**
     * @var array<string, mixed>
     */
    public array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'color' => 'blue',
            'tags' => ['blue', 'purple'],
            'plan' => 'pro',
            'sizes' => ['sm', 'lg'],
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                ChoosableChips::make('color')
                    ->label('Pick one color (single)')
                    ->options([
                        'blue' => 'Blue',
                        'red' => 'Red',
                        'green' => 'Green',
                        'amber' => 'Amber',
                    ])
                    ->colors([
                        'blue' => 'info',
                        'red' => 'danger',
                        'green' => 'success',
                        'amber' => 'warning',
                    ])
                    ->icons([
                        'blue' => Heroicon::OutlinedSwatch,
                        'red' => Heroicon::OutlinedFire,
                    ]),

                ChoosableChips::make('tags')
                    ->label('Pick several tags (multiple)')
                    ->multiple()
                    ->options([
                        'blue' => 'Blue',
                        'indigo' => 'Indigo',
                        'purple' => 'Purple',
                        'teal' => 'Teal',
                        'cyan' => 'Cyan',
                    ])
                    ->colors([
                        'blue' => 'info',
                        'indigo' => 'indigo',
                        'purple' => 'purple',
                        'teal' => 'teal',
                        'cyan' => 'cyan',
                    ])
                    ->descriptions([
                        'purple' => 'A regal choice.',
                    ]),

                ChoosableChips::make('plan')
                    ->label('With icons & a disabled option')
                    ->options([
                        'free' => 'Free',
                        'pro' => 'Pro',
                        'team' => 'Team',
                        'enterprise' => 'Enterprise',
                    ])
                    ->colors([
                        'free' => 'gray',
                        'pro' => 'success',
                        'team' => 'info',
                        'enterprise' => 'warning',
                    ])
                    ->icons([
                        'free' => Heroicon::OutlinedGift,
                        'pro' => Heroicon::OutlinedBolt,
                        'team' => Heroicon::OutlinedUsers,
                        'enterprise' => Heroicon::OutlinedBuildingOffice2,
                    ])
                    ->disableOptionWhen(fn (string $value): bool => $value === 'enterprise'),

                ChoosableChips::make('sizes')
                    ->label('With a check on selected (multiple)')
                    ->multiple()
                    ->checkSelected()
                    ->options([
                        'xs' => 'XS',
                        'sm' => 'S',
                        'md' => 'M',
                        'lg' => 'L',
                        'xl' => 'XL',
                    ]),
            ]);
    }

    public function render(): View
    {
        return view('workbench-chips-demo')->layout('components.layout');
    }
}
