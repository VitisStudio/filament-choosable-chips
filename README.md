# Choosable Chips for Filament

[![Latest Version on Packagist](https://img.shields.io/packagist/v/vitisstudio/filament-choosable-chips.svg?style=flat-square)](https://packagist.org/packages/vitisstudio/filament-choosable-chips)
[![Total Downloads](https://img.shields.io/packagist/dt/vitisstudio/filament-choosable-chips.svg?style=flat-square)](https://packagist.org/packages/vitisstudio/filament-choosable-chips)

A FilamentPHP v5 form field that renders checkbox/radio options as dismissable, colorable, icon-bearing badge **chips**. The API is patterned after `Select`/`ToggleButtons`, so per-option labels, colors, and icons are supplied through the same fluent option map you already know. Each chip is a native Filament badge, so it inherits Filament's theme out of the box.

![Choosable Chips](art/choosable-chips.png)

## Features

- **Single or multi select** from one field — radio semantics by default, checkbox semantics with `->multiple()`.
- **Per-option color, icon, and description**, keyed by option value (same shape as `Select::options()`).
- **Dismissable chips** using the badge's built-in delete button — click a chip to toggle it, or click the × to clear it.
- Reuses the Filament **badge** component and color tokens, so it matches your panel with no extra CSS.
- Enum support and an `in` validation rule derived from the enabled options, like the built-in option fields.

## Requirements

- PHP 8.4+
- `filament/forms` ^5.0

## Installation

Install via Composer:

```bash
composer require vitisstudio/filament-choosable-chips
```

The field renders with Filament's existing badge styles. If you use a [custom theme](https://filamentphp.com/docs/forms/installation#building-themes), register the package views as a Tailwind source so the chip utility classes are compiled:

```css
@source '../../../../vendor/vitisstudio/filament-choosable-chips/resources/views';
```

## Usage

Single-select (radio semantics) is the default — the field stores a single scalar value:

```php
use VitisStudio\FilamentChoosableChips\Forms\Components\ChoosableChips;

ChoosableChips::make('color')
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
        'blue' => \Filament\Support\Icons\Heroicon::OutlinedSwatch,
        'red' => \Filament\Support\Icons\Heroicon::OutlinedFire,
    ]);
```

![Single select](art/single-select.png)

### Multiple selection

Call `->multiple()` for checkbox semantics. The field then stores an **array** of values (cast the underlying Eloquent attribute as `array`):

```php
ChoosableChips::make('tags')
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
        'purple' => 'purple',
    ])
    ->descriptions([
        'purple' => 'A regal choice.',
    ]);
```

![Multiple select](art/multi-select.png)

### Icons and disabled options

Per-option icons accept a `Heroicon` enum case or an icon name. Disable individual options with `->disableOptionWhen()`:

```php
use Filament\Support\Icons\Heroicon;

ChoosableChips::make('plan')
    ->options([
        'free' => 'Free',
        'pro' => 'Pro',
        'team' => 'Team',
        'enterprise' => 'Enterprise',
    ])
    ->icons([
        'free' => Heroicon::OutlinedGift,
        'pro' => Heroicon::OutlinedBolt,
        'team' => Heroicon::OutlinedUsers,
        'enterprise' => Heroicon::OutlinedBuildingOffice2,
    ])
    ->disableOptionWhen(fn (string $value): bool => $value === 'enterprise');
```

![Icons and a disabled option](art/icons-disabled.png)

### Check on selected

Call `->checkSelected()` to prepend a check mark to selected chips. The check is colored with `->selectedColor()` (defaults to `success`). When you don't configure `checkSelected()` explicitly, it turns on automatically for fields that have no per-option `icons()`, so it never collides with a leading icon. While the check is shown it replaces the dismiss × (the check already signals selection, and clicking the chip clears it):

```php
ChoosableChips::make('sizes')
    ->multiple()
    ->checkSelected()                 // also auto-on when no icons() are set
    ->selectedColor('success')        // color of the check (default: success)
    ->options([
        'sm' => 'S',
        'md' => 'M',
        'lg' => 'L',
    ]);
```

![Check on selected](art/check-selected.png)

### Enums

Pass a backed enum to `options()`. Labels, colors, and icons are read automatically from the enum when it implements Filament's `HasLabel`, `HasColor`, and `HasIcon` contracts:

```php
ChoosableChips::make('status')
    ->options(OrderStatus::class);
```

## API

| Method | Description |
| --- | --- |
| `options(array \| Arrayable \| string \| Closure)` | The `value => label` option map (or an enum class string). |
| `multiple(bool \| Closure = true)` | Switch to multi-select (checkbox) mode. Default is single-select. |
| `colors(array \| Arrayable \| Closure)` | Per-option color map keyed by value (any Filament color token). |
| `icons(array \| Arrayable \| Closure)` | Per-option icon map keyed by value (`Heroicon` or icon name). |
| `descriptions(array \| Arrayable \| Closure)` | Per-option helper text keyed by value. |
| `disableOptionWhen(Closure)` | Disable specific options; disabled chips can't be selected or removed. |
| `dismissible(bool \| Closure = true)` | Show a × on selected chips to clear them. Enabled by default, but suppressed while the selected check is shown. |
| `checkSelected(bool \| Closure = true)` | Prepend a check mark to selected chips. Auto-on when no `icons()` are set. |
| `selectedColor(string \| Closure \| null)` | Color of the selection check. Defaults to `success`. |
| `checkIcon(string \| BackedEnum \| Closure)` | Icon used to mark selected chips. Defaults to a check mark. |
| `size(Size \| string \| Closure)` | Badge size (`Size` enum or its string value, e.g. `'sm'`). |
| `defaultColor(string \| Closure \| null)` | Color used for options with no explicit color. Defaults to `primary`. |
| `gridDirection(GridDirection \| string \| Closure)` | Lay chips out by column (default) or row. |

## Testing

```bash
composer test
```

To preview the field in a browser, the package ships a Testbench workbench app:

```bash
composer serve
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Dan Poblete](https://github.com/acepoblete)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
