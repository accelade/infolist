@props([
    'entry' => null,
    'value' => null,
    'label' => null,
    'helperText' => null,
    'placeholder' => '-',
    'color' => 'gray',
    'icon' => null,
    'iconPosition' => 'before',
    'tooltip' => null,
])

@php
    if ($entry) {
        // Object-based usage
        $state = $entry->getFormattedState();
        $placeholder = $entry->getPlaceholder();
        $badgeColor = $entry->getBadgeColorForState();
        $icon = $entry->getBadgeIconForState();
        $iconPosition = $entry->getIconPosition();
        $tooltip = $entry->getTooltip();
        $hasWrapper = true;
    } else {
        // Prop-based standalone usage
        $state = $value;
        $badgeColor = $color;
        $hasWrapper = false;
    }

    // Filament-style badge colors with gradients
    $colorClasses = match ($badgeColor) {
        'primary' => 'bg-gradient-to-r from-primary-50 to-primary-100 text-primary-700 ring-primary-500/20 dark:from-primary-500/20 dark:to-primary-500/10 dark:text-primary-400 dark:ring-primary-400/30',
        'secondary', 'gray' => 'bg-gradient-to-r from-gray-50 to-gray-100 text-gray-700 ring-gray-500/20 dark:from-gray-500/20 dark:to-gray-500/10 dark:text-gray-300 dark:ring-gray-400/30',
        'success' => 'bg-gradient-to-r from-emerald-50 to-emerald-100 text-emerald-700 ring-emerald-500/20 dark:from-emerald-500/20 dark:to-emerald-500/10 dark:text-emerald-400 dark:ring-emerald-400/30',
        'danger' => 'bg-gradient-to-r from-rose-50 to-rose-100 text-rose-700 ring-rose-500/20 dark:from-rose-500/20 dark:to-rose-500/10 dark:text-rose-400 dark:ring-rose-400/30',
        'warning' => 'bg-gradient-to-r from-amber-50 to-amber-100 text-amber-700 ring-amber-500/20 dark:from-amber-500/20 dark:to-amber-500/10 dark:text-amber-400 dark:ring-amber-400/30',
        'info' => 'bg-gradient-to-r from-sky-50 to-sky-100 text-sky-700 ring-sky-500/20 dark:from-sky-500/20 dark:to-sky-500/10 dark:text-sky-400 dark:ring-sky-400/30',
        default => 'bg-gradient-to-r from-gray-50 to-gray-100 text-gray-700 ring-gray-500/20 dark:from-gray-500/20 dark:to-gray-500/10 dark:text-gray-300 dark:ring-gray-400/30',
    };
@endphp

@if ($hasWrapper && $entry)
    <x-infolists::entry-wrapper :entry="$entry">
        @if ($state === null || $state === '')
            <span class="text-gray-400 dark:text-gray-500 text-sm">
                {{ $placeholder }}
            </span>
        @else
            <span
                @if ($tooltip) title="{{ $tooltip }}" @endif
                @class([
                    'inline-flex items-center justify-center gap-x-1 rounded-md px-2.5 py-1 text-xs font-semibold ring-1 ring-inset shadow-sm hover:shadow transition-all duration-150',
                    $colorClasses,
                ])
            >
                @if ($icon && $iconPosition === 'before')
                    <x-accelade::icon :name="$icon" class="h-3.5 w-3.5 shrink-0" />
                @endif

                <span>{{ $state }}</span>

                @if ($icon && $iconPosition === 'after')
                    <x-accelade::icon :name="$icon" class="h-3.5 w-3.5 shrink-0" />
                @endif
            </span>
        @endif
    </x-infolists::entry-wrapper>
@else
    {{-- Standalone blade component usage --}}
    <div {{ $attributes->class(['accelade-entry']) }}>
        @if ($label)
            <div class="accelade-entry-label mb-1">
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $label }}</span>
            </div>
        @endif

        <div class="accelade-entry-content">
            @if ($state === null || $state === '')
                <span class="text-gray-400 dark:text-gray-500 text-sm">{{ $placeholder }}</span>
            @else
                <span
                    @if ($tooltip) title="{{ $tooltip }}" @endif
                    @class([
                        'inline-flex items-center justify-center gap-x-1 rounded-md px-2.5 py-1 text-xs font-semibold ring-1 ring-inset shadow-sm hover:shadow transition-all duration-150',
                        $colorClasses,
                    ])
                >
                    @if ($icon && $iconPosition === 'before')
                        <x-accelade::icon :name="$icon" class="h-3.5 w-3.5 shrink-0" />
                    @endif

                    <span>{{ $state }}</span>

                    @if ($icon && $iconPosition === 'after')
                        <x-accelade::icon :name="$icon" class="h-3.5 w-3.5 shrink-0" />
                    @endif
                </span>
            @endif

            @if ($helperText)
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $helperText }}</p>
            @endif
        </div>
    </div>
@endif
