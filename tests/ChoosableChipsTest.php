<?php

use Filament\Schemas\Components\StateCasts\OptionsArrayStateCast;
use Filament\Schemas\Components\StateCasts\OptionStateCast;
use Livewire\Livewire;
use VitisStudio\FilamentChoosableChips\Forms\Components\ChoosableChips;
use VitisStudio\FilamentChoosableChips\Tests\Fixtures\ChipsTestComponent;

it('exposes a fluent options API patterned after Select', function () {
    $field = ChoosableChips::make('flavor')
        ->options(['a' => 'A', 'b' => 'B'])
        ->colors(['a' => 'danger'])
        ->icons(['a' => 'heroicon-o-star'])
        ->descriptions(['a' => 'First option']);

    expect($field->getOptions())->toBe(['a' => 'A', 'b' => 'B'])
        ->and($field->getColor('a'))->toBe('danger')
        ->and($field->getIcon('a'))->toBe('heroicon-o-star')
        ->and($field->getDescription('a'))->toBe('First option');
});

it('is single-select by default and multi-select after multiple()', function () {
    $single = ChoosableChips::make('flavor');
    $multi = ChoosableChips::make('flavor')->multiple();

    expect($single->isMultiple())->toBeFalse()
        ->and($multi->isMultiple())->toBeTrue();
});

it('uses a scalar state cast in single mode and an array cast in multi mode', function () {
    $single = ChoosableChips::make('flavor')->options(['a' => 'A']);
    $multi = ChoosableChips::make('flavor')->options(['a' => 'A'])->multiple();

    expect($single->getDefaultStateCasts()[0])->toBeInstanceOf(OptionStateCast::class)
        ->and($multi->getDefaultStateCasts()[0])->toBeInstanceOf(OptionsArrayStateCast::class);
});

it('falls back to the default color when an option has none configured', function () {
    $field = ChoosableChips::make('flavor')
        ->options(['a' => 'A', 'b' => 'B'])
        ->colors(['a' => 'danger']);

    expect($field->getChipColor('a'))->toBe('danger')
        ->and($field->getChipColor('b'))->toBe('primary');

    $field->defaultColor('gray');

    expect($field->getChipColor('b'))->toBe('gray');
});

it('builds the in-validation values from enabled options only in multi mode', function () {
    $field = ChoosableChips::make('flavor')
        ->options(['a' => 'A', 'b' => 'B'])
        ->disableOptionWhen(fn (string $value): bool => $value === 'b')
        ->multiple();

    expect($field->getInValidationRuleValues())->toBe(['a'])
        ->and($field->hasInValidationOnMultipleValues())->toBeTrue();
});

it('auto-enables the selected check only when no per-option icons are set', function () {
    $withoutIcons = ChoosableChips::make('flavor')->options(['a' => 'A']);
    $withIcons = ChoosableChips::make('flavor')->options(['a' => 'A'])->icons(['a' => 'heroicon-o-star']);

    expect($withoutIcons->isCheckSelected())->toBeTrue()
        ->and($withIcons->isCheckSelected())->toBeFalse();
});

it('lets the selected check be toggled and recolored explicitly', function () {
    $field = ChoosableChips::make('flavor')
        ->options(['a' => 'A'])
        ->icons(['a' => 'heroicon-o-star'])
        ->checkSelected()
        ->selectedColor('success');

    expect($field->isCheckSelected())->toBeTrue()
        ->and($field->getSelectedColor())->toBe('success');

    expect(ChoosableChips::make('flavor')->checkSelected(false)->isCheckSelected())->toBeFalse();
});

it('defaults the selected color to primary', function () {
    expect(ChoosableChips::make('flavor')->getSelectedColor())->toBe('primary');
});

it('renders a check icon on selected chips when enabled', function () {
    Livewire::test(ChipsTestComponent::class, ['checkSelected' => true])
        ->assertOk()
        ->assertSeeHtml('fi-fo-choosable-chips-chip-check');
});

it('hides the dismiss button when the selected check is shown', function () {
    Livewire::test(ChipsTestComponent::class, ['checkSelected' => true])
        ->assertOk()
        ->assertDontSeeHtml('fi-badge-delete-btn');

    Livewire::test(ChipsTestComponent::class, ['checkSelected' => false])
        ->assertOk()
        ->assertSeeHtml('fi-badge-delete-btn');
});

it('renders each option as a badge chip', function () {
    Livewire::test(ChipsTestComponent::class)
        ->assertOk()
        ->assertSee('Blue')
        ->assertSee('Red')
        ->assertSee('Green')
        ->assertSeeHtml('fi-badge')
        ->assertSeeHtml('fi-fo-choosable-chips');
});

it('stores a single selected value as a scalar in single mode', function () {
    Livewire::test(ChipsTestComponent::class)
        ->set('data.flavor', 'red')
        ->assertSet('data.flavor', 'red');
});

it('stores selected values as an array in multi mode', function () {
    Livewire::test(ChipsTestComponent::class, ['multiple' => true])
        ->set('data.flavor', ['red', 'green'])
        ->assertSet('data.flavor', ['red', 'green']);
});
