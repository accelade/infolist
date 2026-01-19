@props([
    'entry' => null,
    'value' => null,
    'label' => null,
    'helperText' => null,
    'max' => 5,
    'filledIcon' => 'heroicon-s-star',
    'emptyIcon' => 'heroicon-o-star',
    'filledColor' => 'warning',
    'emptyColor' => 'gray',
    'size' => 'md',
    'allowHalf' => false,
    'showNumeric' => true,
])

@php
    if ($entry) {
        // Object-based usage
        $ratingValue = $entry->getRatingValue();
        $max = $entry->getMax();
        $filledIcon = $entry->getFilledIcon();
        $emptyIcon = $entry->getEmptyIcon();
        $filledColorClasses = $entry->getFilledColorClasses();
        $emptyColorClasses = $entry->getEmptyColorClasses();
        $sizeClasses = $entry->getRatingSizeClasses();
        $allowHalf = $entry->getAllowHalf();
        $hasWrapper = true;
    } else {
        // Prop-based standalone usage
        $ratingValue = is_numeric($value) ? (float) $value : 0;
        $hasWrapper = false;

        $filledColorClasses = match ($filledColor) {
            'primary' => 'text-primary-500',
            'secondary', 'gray' => 'text-gray-500',
            'success' => 'text-emerald-500',
            'danger' => 'text-rose-500',
            'warning' => 'text-amber-500',
            'info' => 'text-sky-500',
            default => 'text-amber-500',
        };

        $emptyColorClasses = match ($emptyColor) {
            'primary' => 'text-primary-300',
            'secondary', 'gray' => 'text-gray-300',
            'success' => 'text-emerald-300',
            'danger' => 'text-rose-300',
            'warning' => 'text-amber-300',
            'info' => 'text-sky-300',
            default => 'text-gray-300',
        };

        $sizeClasses = match ($size) {
            'xs' => 'h-3 w-3',
            'sm' => 'h-4 w-4',
            'md' => 'h-5 w-5',
            'lg' => 'h-6 w-6',
            'xl' => 'h-8 w-8',
            default => 'h-5 w-5',
        };
    }

    // Calculate filled, half, and empty counts
    $fullStars = floor($ratingValue);
    $hasHalf = $allowHalf && ($ratingValue - $fullStars) >= 0.5;
    $emptyStars = $max - $fullStars - ($hasHalf ? 1 : 0);
@endphp

@if ($hasWrapper && $entry)
    <x-accelade::entry-wrapper :entry="$entry">
        <div class="flex items-center gap-0.5">
            {{-- Filled stars --}}
            @for ($i = 0; $i < $fullStars; $i++)
                <x-dynamic-component
                    :component="$filledIcon"
                    @class([$sizeClasses, $filledColorClasses])
                />
            @endfor

            {{-- Half star --}}
            @if ($hasHalf)
                <div class="relative {{ $sizeClasses }}">
                    {{-- Empty star as background --}}
                    <x-dynamic-component
                        :component="$emptyIcon"
                        @class(['absolute inset-0', $sizeClasses, $emptyColorClasses])
                    />
                    {{-- Half filled star with clip --}}
                    <div class="absolute inset-0 overflow-hidden" style="width: 50%;">
                        <x-dynamic-component
                            :component="$filledIcon"
                            @class([$sizeClasses, $filledColorClasses])
                        />
                    </div>
                </div>
            @endif

            {{-- Empty stars --}}
            @for ($i = 0; $i < $emptyStars; $i++)
                <x-dynamic-component
                    :component="$emptyIcon"
                    @class([$sizeClasses, $emptyColorClasses])
                />
            @endfor

            {{-- Optional: Display numeric value --}}
            @if ($ratingValue > 0)
                <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">
                    {{ number_format($ratingValue, $allowHalf ? 1 : 0) }}/{{ $max }}
                </span>
            @endif
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
            <div class="flex items-center gap-0.5">
                {{-- Filled stars --}}
                @for ($i = 0; $i < $fullStars; $i++)
                    <x-accelade::icon :name="$filledIcon" @class([$sizeClasses, $filledColorClasses]) />
                @endfor

                {{-- Half star --}}
                @if ($hasHalf)
                    <div class="relative {{ $sizeClasses }}">
                        {{-- Empty star as background --}}
                        <x-accelade::icon :name="$emptyIcon" @class(['absolute inset-0', $sizeClasses, $emptyColorClasses]) />
                        {{-- Half filled star with clip --}}
                        <div class="absolute inset-0 overflow-hidden" style="width: 50%;">
                            <x-accelade::icon :name="$filledIcon" @class([$sizeClasses, $filledColorClasses]) />
                        </div>
                    </div>
                @endif

                {{-- Empty stars --}}
                @for ($i = 0; $i < $emptyStars; $i++)
                    <x-accelade::icon :name="$emptyIcon" @class([$sizeClasses, $emptyColorClasses]) />
                @endfor

                {{-- Optional: Display numeric value --}}
                @if ($showNumeric && $ratingValue > 0)
                    <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">
                        {{ number_format($ratingValue, $allowHalf ? 1 : 0) }}/{{ $max }}
                    </span>
                @endif
            </div>

            @if ($helperText)
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $helperText }}</p>
            @endif
        </div>
    </div>
@endif
