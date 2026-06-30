<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Size;
use Filament\Support\Icons\Heroicon;
use VitisStudio\FilamentChoosableChips\Forms\Components\ChoosableChips;

class ChoosableChipsDemo extends Page
{
    protected string $view = 'filament.pages.choosable-chips-demo';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $title = 'Choosable Chips';

    /**
     * @var array<string, mixed>
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'color' => 'blue',
            'tags' => ['blue', 'purple'],
            'plan' => 'pro',
            'priority' => 'medium',
            'size' => 'sm',
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Single select (radio)')
                    ->description('Default mode — stores one value. Options carry colors and icons.')
                    ->schema([
                        ChoosableChips::make('color')
                            ->label('Brand color')
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
                    ]),

                Section::make('Multiple select (checkbox)')
                    ->description('Call ->multiple() to store an array. With no per-option icons the selected check turns on automatically.')
                    ->schema([
                        ChoosableChips::make('tags')
                            ->label('Tags')
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
                    ]),

                Section::make('Icons, disabled options & required')
                    ->schema([
                        ChoosableChips::make('plan')
                            ->label('Plan')
                            ->required()
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
                    ]),

                Section::make('Check on selected & sizes')
                    ->description('checkSelected() shows a green check on selected chips; size() controls the badge size.')
                    ->schema([
                        ChoosableChips::make('priority')
                            ->label('Priority (check on selected)')
                            ->checkSelected()
                            ->options([
                                'low' => 'Low',
                                'medium' => 'Medium',
                                'high' => 'High',
                            ]),

                        ChoosableChips::make('size')
                            ->label('Pick a t-shirt size (extra small chips)')
                            ->multiple()
                            ->size(Size::ExtraSmall)
                            ->options([
                                'xs' => 'XS',
                                's' => 'S',
                                'm' => 'M',
                                'l' => 'L',
                                'xl' => 'XL',
                            ]),
                    ]),
            ]);
    }

    /**
     * @return array<Action>
     */
    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save')
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $state = $this->form->getState();

        Notification::make()
            ->title('Saved')
            ->body('State: '.json_encode($state))
            ->success()
            ->send();
    }
}
