@props([
    'entry' => null,
    'value' => null,
    'label' => null,
    'helperText' => null,
    'placeholder' => '-',
    'icon' => null,
    'color' => 'gray',
    'size' => 'md',
    'tooltip' => null,
    'boolean' => false,
    'trueIcon' => 'heroicon-o-check-circle',
    'falseIcon' => 'heroicon-o-x-circle',
    'trueColor' => 'success',
    'falseColor' => 'danger',
])

@php
    if ($entry) {
        // Object-based usage
        $state = $entry->getState();
        $displayIcon = $entry->getIcon() ?? $state;
        $placeholder = $entry->getPlaceholder();
        $color = $entry->getColor();
        $size = $entry->getIconSize();
        $tooltip = $entry->getTooltip();
        $tooltipConfig = $entry->getTooltipConfig();
        $isBoolean = $entry->isBoolean();
        $trueIcon = $entry->getTrueIcon();
        $falseIcon = $entry->getFalseIcon();
        $trueColor = $entry->getTrueColor();
        $falseColor = $entry->getFalseColor();

        if ($isBoolean) {
            $boolValue = (bool) $state;
            $displayIcon = $boolValue ? $trueIcon : $falseIcon;
            $color = $boolValue ? $trueColor : $falseColor;
        }

        $hasWrapper = true;
    } else {
        // Prop-based standalone usage
        $displayIcon = $icon ?? $value;
        $isBoolean = $boolean;

        if ($isBoolean && $value !== null) {
            $boolValue = (bool) $value;
            $displayIcon = $boolValue ? $trueIcon : $falseIcon;
            $color = $boolValue ? $trueColor : $falseColor;
        }

        $hasWrapper = false;
    }

    $sizeClasses = match ($size) {
        'xs' => 'h-3 w-3',
        'sm' => 'h-4 w-4',
        'md' => 'h-5 w-5',
        'lg' => 'h-6 w-6',
        'xl' => 'h-8 w-8',
        '2xl' => 'h-10 w-10',
        default => 'h-5 w-5',
    };

    $colorClasses = match ($color) {
        'primary' => 'text-primary-500 dark:text-primary-400',
        'secondary', 'gray' => 'text-gray-500 dark:text-gray-400',
        'success' => 'text-emerald-500 dark:text-emerald-400',
        'danger' => 'text-rose-500 dark:text-rose-400',
        'warning' => 'text-amber-500 dark:text-amber-400',
        'info' => 'text-sky-500 dark:text-sky-400',
        default => 'text-gray-500 dark:text-gray-400',
    };
@endphp

@if ($hasWrapper && $entry)
    <x-accelade::entry-wrapper :entry="$entry">
        @if ($displayIcon)
            <div
                @if ($tooltipConfig)
                    a-tooltip="{{ $tooltipConfig }}"
                @endif
                class="inline-flex"
            >
                <x-accelade::icon
                    :name="$displayIcon"
                    @class([
                        $sizeClasses,
                        $entry->getColorClasses($color),
                    ])
                />
            </div>
        @else
            <span class="text-gray-400 dark:text-gray-500">
                {{ $placeholder }}
            </span>
        @endif
    </x-accelade::entry-wrapper>
@else
    {{-- Standalone blade component usage --}}
    <div {{ $attributes->class(['accelade-entry']) }}>
        @if ($label)
            <div class="accelade-entry-label mb-1">
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $label }}</span>
            </div>
        @endif

        <div class="accelade-entry-content">
            @if ($displayIcon)
                <div
                    @if ($tooltip)
                        a-tooltip="{{ $tooltip }}"
                    @endif
                    class="inline-flex"
                >
                    <x-accelade::icon
                        :name="$displayIcon"
                        @class([
                            $sizeClasses,
                            $colorClasses,
                        ])
                    />
                </div>
            @else
                <span class="text-gray-400 dark:text-gray-500">{{ $placeholder }}</span>
            @endif

            @if ($helperText)
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $helperText }}</p>
            @endif
        </div>
    </div>
@endif
