@props([
    'entry' => null,
    'value' => null,
    'label' => null,
    'helperText' => null,
    'placeholder' => '-',
    'language' => 'php',
    'maxHeight' => null,
    'tooltip' => null,
])

@php
    if ($entry) {
        // Object-based usage
        $state = $entry->getState();
        $placeholder = $entry->getPlaceholder();
        $language = $entry->getLanguage();
        $maxHeight = $entry->getMaxHeight();
        $tooltip = $entry->getTooltip();
        $hasWrapper = true;
    } else {
        // Prop-based standalone usage
        $state = $value;
        $hasWrapper = false;
    }

    // Format the code content
    $codeContent = is_string($state) ? $state : json_encode($state, JSON_PRETTY_PRINT);
@endphp

@if ($hasWrapper && $entry)
    <x-infolists::entry-wrapper :entry="$entry">
        @if ($state === null || $state === '')
            <span class="text-gray-400 dark:text-gray-500 text-sm">
                {{ $placeholder }}
            </span>
        @else
            <div
                @if ($tooltip) title="{{ $tooltip }}" @endif
                @if ($maxHeight) style="max-height: {{ $maxHeight }}px; overflow-y: auto;" @endif
            >
                <x-accelade::code-block :language="$language">{{ $codeContent }}</x-accelade::code-block>
            </div>
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
                <div
                    @if ($tooltip) title="{{ $tooltip }}" @endif
                    @if ($maxHeight) style="max-height: {{ $maxHeight }}px; overflow-y: auto;" @endif
                >
                    <x-accelade::code-block :language="$language">{{ $codeContent }}</x-accelade::code-block>
                </div>
            @endif

            @if ($helperText)
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $helperText }}</p>
            @endif
        </div>
    </div>
@endif
