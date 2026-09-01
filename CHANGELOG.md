# Changelog

All notable changes to `filament-choosable-chips` will be documented in this file.

## v1.0.0 - Initial Release - 2026-09-01

Initial release of **Choosable Chips for Filament** — a Filament v5 form field that renders checkbox/radio options as dismissable, colorable, icon-bearing badge **chips**, with a fluent options API patterned after `Select`/`ToggleButtons`.

### Features

- **Single or multi select** from one field — radio semantics by default, checkbox semantics with `->multiple()`, each with the matching scalar/array state cast.
- **Per-option `colors()`, `icons()`, and `descriptions()`** keyed by option value, plus `disableOptionWhen()`.
- **Dismissable chips** via the badge's built-in delete button.
- **Selected check mark** with `->checkSelected()` and a configurable `selectedColor()`/`checkIcon()` — auto-on when no per-option icons are set, and it replaces the dismiss button while shown.
- `size()`, `defaultColor()`, and `gridDirection()` options.
- **Enum support** and an `in` validation rule derived from the enabled options.

### Requirements

- PHP 8.4+
- Filament v5 (`filament/forms` ^5.0)

### Installation

```bash
composer require vitisstudio/filament-choosable-chips

```
**Full Changelog**: https://github.com/VitisStudio/filament-choosable-chips/commits/v1.0.0

## 1.0.0 - 2026-07-29

Initial release.

- `ChoosableChips` form field for Filament v5, rendering options as Filament badge chips.
- Single-select (radio) by default; `->multiple()` for multi-select (checkbox), with the matching scalar/array state casts.
- Per-option `colors()`, `icons()`, and `descriptions()` keyed by option value, plus `disableOptionWhen()`.
- Dismissable chips via the badge's built-in delete button, toggled client-side with Alpine.
- `checkSelected()` selected check mark with a configurable `selectedColor()` (defaults to `success`) and `checkIcon()`; auto-on when no per-option icons are set, and it replaces the dismiss button while shown.
- `size()`, `defaultColor()`, and `gridDirection()` options.
- Enum support and an `in` validation rule derived from the enabled options.
