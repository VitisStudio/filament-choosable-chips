<?php

namespace VitisStudio\FilamentChoosableChips\Forms\Components;

use BackedEnum;
use Closure;
use Filament\Forms\Components\Concerns;
use Filament\Forms\Components\Contracts;
use Filament\Forms\Components\Field;
use Filament\Schemas\Components\StateCasts\Contracts\StateCast;
use Filament\Schemas\Components\StateCasts\EnumArrayStateCast;
use Filament\Schemas\Components\StateCasts\EnumStateCast;
use Filament\Schemas\Components\StateCasts\OptionsArrayStateCast;
use Filament\Schemas\Components\StateCasts\OptionStateCast;
use Filament\Support\Enums\Size;
use Filament\Support\Icons\Heroicon;

/**
 * A choosable "chip" field rendering each option as a Filament badge.
 *
 * Single-select (radio semantics) by default; call multiple() for
 * multi-select (checkbox semantics). Per-option color and icon are supplied
 * through the same options-style fluent API used by ToggleButtons/Select.
 */
class ChoosableChips extends Field implements Contracts\CanDisableOptions
{
    use Concerns\CanDisableOptions;
    use Concerns\CanFixIndistinctState;
    use Concerns\HasColors;
    use Concerns\HasDescriptions;
    use Concerns\HasExtraInputAttributes;
    use Concerns\HasGridDirection;
    use Concerns\HasIcons;
    use Concerns\HasOptions;
    use Concerns\HasTooltips;

    /**
     * @var view-string
     */
    protected string $view = 'filament-choosable-chips::components.choosable-chips';

    protected bool|Closure $isMultiple = false;

    protected bool|Closure $isDismissible = true;

    protected Size|string|Closure $size = Size::Medium;

    protected string|Closure|null $defaultColor = 'primary';

    protected bool|Closure|null $isCheckSelected = null;

    protected string|Closure|null $selectedColor = 'success';

    protected string|BackedEnum|Closure $checkIcon = Heroicon::Check;

    /**
     * Enable multi-select (checkbox semantics). When false (default) the field
     * behaves like a radio group and holds a single scalar value.
     */
    public function multiple(bool|Closure $condition = true): static
    {
        $this->isMultiple = $condition;

        return $this;
    }

    public function isMultiple(): bool
    {
        return (bool) $this->evaluate($this->isMultiple);
    }

    /**
     * Whether selected chips show a dismiss (X) button. Defaults to true.
     */
    public function dismissible(bool|Closure $condition = true): static
    {
        $this->isDismissible = $condition;

        return $this;
    }

    public function isDismissible(): bool
    {
        return (bool) $this->evaluate($this->isDismissible);
    }

    /**
     * Size of the rendered badges. Accepts a Size enum or its string value.
     */
    public function size(Size|string|Closure $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getSize(): Size|string
    {
        $size = $this->evaluate($this->size);

        if ($size instanceof Size) {
            return $size;
        }

        return Size::tryFrom($size) ?? $size;
    }

    /**
     * Color applied to an option whose color was not configured via colors().
     */
    public function defaultColor(string|Closure|null $color): static
    {
        $this->defaultColor = $color;

        return $this;
    }

    public function getDefaultColor(): ?string
    {
        return $this->evaluate($this->defaultColor);
    }

    /**
     * Resolve the chip color for an option value, falling back to the
     * configured default color when the option has no explicit color.
     *
     * @return string | array<int | string, string | int> | null
     */
    public function getChipColor(mixed $value): string|array|null
    {
        return $this->getColor($value) ?? $this->getDefaultColor();
    }

    /**
     * Show a check icon on the left of selected chips. When left unset, the
     * check is shown automatically only if no per-option icons are configured
     * (so it never collides with a custom leading icon).
     */
    public function checkSelected(bool|Closure|null $condition = true): static
    {
        $this->isCheckSelected = $condition;

        return $this;
    }

    public function isCheckSelected(): bool
    {
        $condition = $this->evaluate($this->isCheckSelected);

        if ($condition !== null) {
            return (bool) $condition;
        }

        return blank($this->getIcons());
    }

    /**
     * The icon used to mark selected chips. Defaults to a check mark.
     */
    public function checkIcon(string|BackedEnum|Closure $icon): static
    {
        $this->checkIcon = $icon;

        return $this;
    }

    public function getCheckIcon(): string|BackedEnum
    {
        return $this->evaluate($this->checkIcon);
    }

    /**
     * Color of the selection check icon. Defaults to the success color.
     */
    public function selectedColor(string|Closure|null $color): static
    {
        $this->selectedColor = $color;

        return $this;
    }

    public function getSelectedColor(): ?string
    {
        return $this->evaluate($this->selectedColor);
    }

    public function getEnumDefaultStateCast(): ?StateCast
    {
        $enum = $this->getEnum();

        if (blank($enum)) {
            return null;
        }

        return app(
            $this->isMultiple() ? EnumArrayStateCast::class : EnumStateCast::class,
            ['enum' => $enum],
        );
    }

    /**
     * @return array<StateCast>
     */
    public function getDefaultStateCasts(): array
    {
        if ($this->hasCustomStateCasts() || filled($this->getEnum())) {
            return parent::getDefaultStateCasts();
        }

        if ($this->isMultiple()) {
            return [app(OptionsArrayStateCast::class)];
        }

        return [app(OptionStateCast::class, ['isNullable' => true])];
    }

    /**
     * @return ?array<string>
     */
    public function getInValidationRuleValues(): ?array
    {
        $values = parent::getInValidationRuleValues();

        if ($values !== null) {
            return $values;
        }

        return array_keys($this->getEnabledOptions());
    }

    public function hasInValidationOnMultipleValues(): bool
    {
        return $this->isMultiple();
    }
}
