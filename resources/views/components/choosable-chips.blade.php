@php
    use Filament\Support\Enums\GridDirection;
    use Illuminate\View\ComponentAttributeBag;

    $fieldWrapperView = $getFieldWrapperView();
    $gridDirection = $getGridDirection() ?? GridDirection::Column;
    $id = $getId();
    $isDisabled = $isDisabled();
    $isMultiple = $isMultiple();
    $isDismissible = $isDismissible();
    $isCheckSelected = $isCheckSelected();
    $checkIcon = $getCheckIcon();
    $selectedColor = $getSelectedColor();
    $size = $getSize();
    $statePath = $getStatePath();
    $wireModelAttribute = $applyStateBindingModifiers('wire:model');
    $extraInputAttributeBag = $getExtraInputAttributeBag();
@endphp

<x-dynamic-component
    :component="$fieldWrapperView"
    :field="$field"
    tabindex="-1"
    class="fi-fo-choosable-chips-wrp"
>
    <div
        x-data="{
            state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }},
            isSelected (value) {
                if (Array.isArray(this.state)) {
                    return this.state.map((item) => item?.toString()).includes(value?.toString())
                }

                return this.state?.toString() === value?.toString()
            },
            deselect (value) {
                if (Array.isArray(this.state)) {
                    this.state = this.state.filter((item) => item?.toString() !== value?.toString())

                    return
                }

                this.state = null
            },
        }"
        {{
            $getExtraAttributeBag()
                ->grid($getColumns(), $gridDirection)
                ->class(['fi-fo-choosable-chips flex flex-wrap gap-2'])
        }}
    >
        @foreach ($getOptions() as $value => $label)
            @php
                $inputId = "{$id}-{$value}";
                $shouldOptionBeDisabled = $isDisabled || $isOptionDisabled($value, $label);
                $color = $getChipColor($value);
                $icon = $getIcon($value);
                $tooltip = $getTooltip($value);
                $optionHasDescription = $hasDescription($value);
                $jsValue = \Illuminate\Support\Js::from((string) $value);
            @endphp

            <div class="fi-fo-choosable-chips-chip-ctn">
                <input
                    @disabled($shouldOptionBeDisabled)
                    id="{{ $inputId }}"
                    @if (! $isMultiple)
                        name="{{ $id }}"
                    @endif
                    type="{{ $isMultiple ? 'checkbox' : 'radio' }}"
                    value="{{ $value }}"
                    {{ $wireModelAttribute }}="{{ $statePath }}"
                    {{ $extraInputAttributeBag->class(['fi-sr-only peer']) }}
                />

                <x-filament::badge
                    :color="$color"
                    :icon="$icon"
                    :size="$size"
                    :tooltip="$tooltip"
                    tag="label"
                    :for="$inputId"
                    x-bind:class="{ 'fi-selected ring-2 ring-offset-1 ring-offset-white dark:ring-offset-gray-900': isSelected({{ $jsValue }}) }"
                    @class([
                        'fi-fo-choosable-chips-chip select-none transition',
                        'fi-not-allowed opacity-70 cursor-not-allowed' => $shouldOptionBeDisabled,
                        'cursor-pointer' => ! $shouldOptionBeDisabled,
                    ])
                >
                    @if ($isCheckSelected)
                        <span
                            x-show="isSelected({{ $jsValue }})"
                            x-cloak
                            class="fi-fo-choosable-chips-chip-check -ms-0.5 inline-flex"
                        >
                            {{
                                \Filament\Support\generate_icon_html(
                                    $checkIcon,
                                    attributes: (new ComponentAttributeBag)
                                        ->color(\Filament\Support\View\Components\BadgeComponent::class, $selectedColor),
                                    size: \Filament\Support\Enums\IconSize::Small,
                                )
                            }}
                        </span>
                    @endif

                    {{ $label }}

                    @if ($isDismissible && ! $shouldOptionBeDisabled)
                        <x-slot
                            name="deleteButton"
                            label="{{ __('Remove :label', ['label' => $label]) }}"
                            x-show="isSelected({{ $jsValue }})"
                            x-cloak
                            x-on:click.stop.prevent="deselect({{ $jsValue }})"
                        ></x-slot>
                    @endif
                </x-filament::badge>

                @if ($optionHasDescription)
                    <p class="fi-fo-choosable-chips-chip-description mt-1 text-xs text-gray-500 dark:text-gray-400">
                        {{ $getDescription($value) }}
                    </p>
                @endif
            </div>
        @endforeach
    </div>
</x-dynamic-component>
