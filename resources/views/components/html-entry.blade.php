@props([
    'entry' => null,
    'value' => null,
    'label' => null,
    'helperText' => null,
    'placeholder' => '—',
    'markdown' => false,
    'prose' => true,
    'maxHeight' => null,
    'sanitized' => true,
])

@php
    if ($entry) {
        // Object-based usage
        $content = $entry->getFormattedContent();
        $isProse = $entry->isProse();
        $maxHeight = $entry->getMaxHeight();
        $placeholder = $entry->getPlaceholder() ?? '—';
        $hasWrapper = true;
    } else {
        // Prop-based standalone usage
        $isProse = $prose;
        $hasWrapper = false;

        if ($value) {
            if ($markdown) {
                $content = Str::markdown($value);
            } else {
                $content = $sanitized ? strip_tags($value, '<p><br><strong><em><a><ul><ol><li><h1><h2><h3><h4><h5><h6><blockquote><code><pre>') : $value;
            }
        } else {
            $content = null;
        }
    }
@endphp

@if ($hasWrapper && $entry)
    <x-infolists::entry-wrapper :entry="$entry">
        @if ($content)
            <div
                @class([
                    'prose prose-sm dark:prose-invert max-w-none' => $isProse,
                    'text-gray-900 dark:text-white' => ! $isProse,
                    'overflow-y-auto' => $maxHeight,
                ])
                @if ($maxHeight)
                    style="max-height: {{ $maxHeight }};"
                @endif
            >
                {!! $content !!}
            </div>
        @else
            <span class="text-gray-400 dark:text-gray-500 italic">
                {{ $placeholder }}
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
            @if ($content)
                <div
                    @class([
                        'prose prose-sm dark:prose-invert max-w-none' => $isProse,
                        'text-gray-900 dark:text-white' => ! $isProse,
                        'overflow-y-auto' => $maxHeight,
                    ])
                    @if ($maxHeight)
                        style="max-height: {{ $maxHeight }};"
                    @endif
                >
                    {!! $content !!}
                </div>
            @else
                <span class="text-gray-400 dark:text-gray-500 italic">{{ $placeholder }}</span>
            @endif

            @if ($helperText)
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $helperText }}</p>
            @endif
        </div>
    </div>
@endif
