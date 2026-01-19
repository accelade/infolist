@props([
    'entry' => null,
    'value' => null,
    'label' => null,
    'helperText' => null,
    'placeholder' => '-',
    'copyable' => false,
    'copyMessage' => 'Copied!',
    'copyMessageDuration' => 2,
    'tooltip' => null,
])

@php
    if ($entry) {
        // Object-based usage
        $state = $entry->getState();
        $placeholder = $entry->getPlaceholder();
        $isCopyable = $entry->isCopyable();
        $copyMessage = $entry->getCopyMessage();
        $copyMessageDuration = $entry->getCopyMessageDuration();
        $tooltip = $entry->getTooltip();
        $tooltipConfig = $entry->getTooltipConfig();
        $hasWrapper = true;
    } else {
        // Prop-based standalone usage
        $state = $value;
        $isCopyable = $copyable;
        $hasWrapper = false;
    }
@endphp

@if ($hasWrapper && $entry)
    <x-accelade::entry-wrapper :entry="$entry">
        @if ($state)
            <div
                @if ($isCopyable)
                    data-copyable
                    data-copy-value="{{ $state }}"
                    data-copy-message="{{ $copyMessage }}"
                    data-copy-message-duration="{{ $copyMessageDuration }}"
                @endif
                @if ($tooltipConfig)
                    a-tooltip="{{ $tooltipConfig }}"
                @endif
                @class([
                    'inline-flex items-center gap-x-2',
                    'cursor-pointer hover:opacity-75 transition-opacity' => $isCopyable,
                ])
            >
                <span
                    class="h-6 w-6 rounded-md border border-gray-200 dark:border-gray-700 shadow-sm"
                    style="background-color: {{ $state }}"
                ></span>

                <span class="text-sm font-mono text-gray-700 dark:text-gray-300">
                    {{ $state }}
                </span>

                @if ($isCopyable)
                    <button
                        type="button"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                        data-copy-trigger
                    >
                        <x-accelade::icon name="heroicon-o-clipboard" class="h-4 w-4" />
                    </button>
                @endif
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
            @if ($state)
                <div
                    @if ($isCopyable)
                        data-copyable
                        data-copy-value="{{ $state }}"
                        data-copy-message="{{ $copyMessage }}"
                        data-copy-message-duration="{{ $copyMessageDuration }}"
                    @endif
                    @if ($tooltip)
                        a-tooltip="{{ $tooltip }}"
                    @endif
                    @class([
                        'inline-flex items-center gap-x-2',
                        'cursor-pointer hover:opacity-75 transition-opacity' => $isCopyable,
                    ])
                >
                    <span
                        class="h-6 w-6 rounded-md border border-gray-200 dark:border-gray-700 shadow-sm"
                        style="background-color: {{ $state }}"
                    ></span>

                    <span class="text-sm font-mono text-gray-700 dark:text-gray-300">
                        {{ $state }}
                    </span>

                    @if ($isCopyable)
                        <button
                            type="button"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                            data-copy-trigger
                        >
                            <x-accelade::icon name="heroicon-o-clipboard" class="h-4 w-4" />
                        </button>
                    @endif
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
