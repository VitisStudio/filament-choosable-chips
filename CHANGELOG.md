# Changelog

All notable changes to `filament-choosable-chips` will be documented in this file.

## 1.0.0 - 2026-07-29

Initial release.

- `ChoosableChips` form field for Filament v5, rendering options as Filament badge chips.
- Single-select (radio) by default; `->multiple()` for multi-select (checkbox), with the matching scalar/array state casts.
- Per-option `colors()`, `icons()`, and `descriptions()` keyed by option value, plus `disableOptionWhen()`.
- Dismissable chips via the badge's built-in delete button, toggled client-side with Alpine.
- `checkSelected()` selected check mark with a configurable `selectedColor()` (defaults to `success`) and `checkIcon()`; auto-on when no per-option icons are set, and it replaces the dismiss button while shown.
- `size()`, `defaultColor()`, and `gridDirection()` options.
- Enum support and an `in` validation rule derived from the enabled options.
