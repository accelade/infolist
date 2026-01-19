@props([
    'entry' => null,
    'value' => null,
    'label' => null,
    'helperText' => null,
    'min' => 0,
    'max' => 100,
    'color' => 'primary',
    'height' => 'md',
    'showLabel' => true,
    'striped' => false,
    'animated' => false,
])

@php
    if ($entry) {
        // Object-based usage
        $percentage = $entry->getPercentage();
        $colorClasses = $entry->getColorClasses();
        $heightClasses = $entry->getHeightClasses();
        $showLabel = $entry->isShowLabel();
        $formattedLabel = $entry->getFormattedLabel();
        $isStriped = $entry->isStriped();
        $isAnimated = $entry->isAnimated();
        $hasWrapper = true;
    } else {
        // Prop-based standalone usage
        $numericValue = is_numeric($value) ? (float) $value : 0;
        $range = $max - $min;
        $percentage = $range > 0 ? (($numericValue - $min) / $range) * 100 : 0;
        $percentage = max(0, min(100, $percentage));
        $formattedLabel = round($percentage) . '%';
        $isStriped = $striped;
        $isAnimated = $animated;
        $hasWrapper = false;

        $colorClasses = match ($color) {
            'primary' => 'bg-primary-500',
            'secondary', 'gray' => 'bg-gray-500',
            'success' => 'bg-emerald-500',
            'danger' => 'bg-rose-500',
            'warning' => 'bg-amber-500',
            'info' => 'bg-sky-500',
            default => 'bg-primary-500',
        };

        $heightClasses = match ($height) {
            'xs' => 'h-1',
            'sm' => 'h-2',
            'md' => 'h-3',
            'lg' => 'h-4',
            'xl' => 'h-5',
            default => 'h-3',
        };
    }
@endphp

@if ($hasWrapper && $entry)
    <x-accelade::entry-wrapper :entry="$entry">
        <div class="w-full">
            {{-- Progress bar container --}}
            <div class="flex items-center gap-3">
                <div
                    @class([
                        'flex-1 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden',
                        $heightClasses,
                    ])
                    role="progressbar"
                    aria-valuenow="{{ $percentage }}"
                    aria-valuemin="0"
                    aria-valuemax="100"
                >
                    <div
                        @class([
                            'h-full rounded-full transition-all duration-500 ease-out',
                            $colorClasses,
                            'accelade-progress-striped' => $isStriped,
                            'accelade-progress-animated' => $isAnimated,
                        ])
                        style="width: {{ $percentage }}%;"
                    ></div>
                </div>

                {{-- Label --}}
                @if ($showLabel)
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 min-w-[3rem] text-right">
                        {{ $formattedLabel }}
                    </span>
                @endif
            </div>
        </div>
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
            <div class="w-full">
                {{-- Progress bar container --}}
                <div class="flex items-center gap-3">
                    <div
                        @class([
                            'flex-1 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden',
                            $heightClasses,
                        ])
                        role="progressbar"
                        aria-valuenow="{{ $percentage }}"
                        aria-valuemin="0"
                        aria-valuemax="100"
                    >
                        <div
                            @class([
                                'h-full rounded-full transition-all duration-500 ease-out',
                                $colorClasses,
                                'accelade-progress-striped' => $isStriped,
                                'accelade-progress-animated' => $isAnimated,
                            ])
                            style="width: {{ $percentage }}%;"
                        ></div>
                    </div>

                    {{-- Label --}}
                    @if ($showLabel)
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 min-w-[3rem] text-right">
                            {{ $formattedLabel }}
                        </span>
                    @endif
                </div>
            </div>

            @if ($helperText)
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $helperText }}</p>
            @endif
        </div>
    </div>
@endif

@pushOnce('styles')
<style>
    .accelade-progress-striped {
        background-image: linear-gradient(
            45deg,
            rgba(255, 255, 255, 0.15) 25%,
            transparent 25%,
            transparent 50%,
            rgba(255, 255, 255, 0.15) 50%,
            rgba(255, 255, 255, 0.15) 75%,
            transparent 75%,
            transparent
        );
        background-size: 1rem 1rem;
    }

    .accelade-progress-animated {
        animation: accelade-progress-stripes 1s linear infinite;
    }

    @keyframes accelade-progress-stripes {
        0% { background-position: 1rem 0; }
        100% { background-position: 0 0; }
    }
</style>
@endPushOnce
