@props([
    'entry' => null,
    'items' => null,
    'label' => null,
    'helperText' => null,
    'placeholder' => 'No items',
    'contained' => false,
    'grid' => false,
    'simple' => false,
    'gridColumns' => 1,
])

@php
    if ($entry) {
        // Object-based usage
        $state = $entry->getState();
        $placeholder = $entry->getPlaceholder();
        $schema = $entry->getSchema();
        $isContained = $entry->isContained();
        $isGrid = $entry->isGrid();
        $isSimple = $entry->isSimple();
        $gridColumns = $entry->getGridColumns();
        $items = is_array($state) ? $state : [];
        $hasWrapper = true;
    } else {
        // Prop-based standalone usage
        $items = is_array($items) ? $items : [];
        $isContained = $contained;
        $isGrid = $grid;
        $isSimple = $simple;
        $schema = null;
        $hasWrapper = false;
    }

    $gridClasses = match ($gridColumns) {
        1 => 'grid-cols-1',
        2 => 'grid-cols-1 sm:grid-cols-2',
        3 => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3',
        4 => 'grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4',
        5 => 'grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5',
        6 => 'grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6',
        default => 'grid-cols-1',
    };
@endphp

@if ($hasWrapper && $entry)
<x-accelade::entry-wrapper :entry="$entry">
    @if (count($items) > 0)
        <div
            @class([
                'space-y-3' => ! $isGrid && ! $isSimple,
                'divide-y' => $isSimple,
                'grid gap-4' => $isGrid,
                $gridClasses => $isGrid,
            ])
            @if($isSimple) style="--tw-divide-opacity: 1; --tw-divide-color: var(--docs-border, #e2e8f0);" @endif
        >
            @foreach ($items as $index => $itemData)
                @if ($isSimple)
                    {{-- Simple layout: compact horizontal list --}}
                    <div class="flex items-center gap-3 py-2 first:pt-0 last:pb-0">
                        @foreach ($schema as $childEntry)
                            @php
                                $clonedEntry = clone $childEntry;
                                $clonedEntry->record($itemData);
                                $clonedEntry->hiddenLabel();
                            @endphp

                            @if (! $clonedEntry->isHidden())
                                <div @class([
                                    'shrink-0' => $childEntry instanceof \Accelade\Infolists\Components\ImageEntry,
                                ])>
                                    {!! $clonedEntry->toHtml() !!}
                                </div>
                            @endif
                        @endforeach
                    </div>
                @elseif ($isGrid)
                    {{-- Grid layout: centered card items --}}
                    <div
                        class="rounded-xl p-4 text-center transition-all duration-200 shadow-sm ring-1 hover:shadow-md"
                        style="background: var(--docs-bg, #ffffff); --tw-ring-color: var(--docs-border, #e2e8f0);"
                    >
                        <div class="flex flex-col items-center gap-2">
                            @foreach ($schema as $childEntry)
                                @php
                                    $clonedEntry = clone $childEntry;
                                    $clonedEntry->record($itemData);
                                    $clonedEntry->hiddenLabel();
                                @endphp

                                @if (! $clonedEntry->isHidden())
                                    {!! $clonedEntry->toHtml() !!}
                                @endif
                            @endforeach
                        </div>
                    </div>
                @elseif ($isContained)
                    {{-- Contained layout: styled card --}}
                    <div
                        class="rounded-xl shadow-sm ring-1 p-4"
                        style="background: var(--docs-bg, #ffffff); --tw-ring-color: var(--docs-border, #e2e8f0);"
                    >
                        <div class="flex flex-wrap items-start gap-x-3 gap-y-3">
                            @foreach ($schema as $childEntry)
                                @php
                                    $clonedEntry = clone $childEntry;
                                    $clonedEntry->record($itemData);
                                    $clonedEntry->hiddenLabel();
                                    $isImage = $childEntry instanceof \Accelade\Infolists\Components\ImageEntry;
                                    $isIcon = $childEntry instanceof \Accelade\Infolists\Components\IconEntry;
                                    $isColumnFull = $clonedEntry->isColumnSpanFull();
                                @endphp

                                @if (! $clonedEntry->isHidden())
                                    <div @class([
                                        'shrink-0' => $isImage || $isIcon,
                                        'min-w-0' => ! $isImage && ! $isIcon && ! $isColumnFull,
                                        'w-full' => $isColumnFull,
                                    ])>
                                        {!! $clonedEntry->toHtml() !!}
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @else
                    {{-- Default layout: simple divider between items --}}
                    <div
                        class="pb-3 border-b last:border-0 last:pb-0"
                        style="border-color: var(--docs-border, #e2e8f0);"
                    >
                        <div class="flex items-start gap-4">
                            @foreach ($schema as $childEntry)
                                @php
                                    $clonedEntry = clone $childEntry;
                                    $clonedEntry->record($itemData);
                                    $clonedEntry->hiddenLabel();
                                    $isImage = $childEntry instanceof \Accelade\Infolists\Components\ImageEntry;
                                    $isIcon = $childEntry instanceof \Accelade\Infolists\Components\IconEntry;
                                @endphp

                                @if (! $clonedEntry->isHidden())
                                    <div @class([
                                        'shrink-0' => $isImage || $isIcon,
                                        'flex-1 min-w-0' => ! $isImage && ! $isIcon,
                                    ])>
                                        {!! $clonedEntry->toHtml() !!}
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @else
        <span class="text-gray-400 dark:text-gray-500">
            {{ $placeholder }}
        </span>
    @endif
</x-accelade::entry-wrapper>
@else
    {{-- Standalone blade component usage with slot --}}
    <div {{ $attributes->class(['accelade-entry']) }}>
        @if ($label)
            <div class="accelade-entry-label mb-2">
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $label }}</span>
            </div>
        @endif

        <div class="accelade-entry-content">
            @if (count($items) > 0)
                <div
                    @class([
                        'space-y-3' => ! $isGrid && ! $isSimple,
                        'divide-y' => $isSimple,
                        'grid gap-4' => $isGrid,
                        $gridClasses => $isGrid,
                    ])
                    @if($isSimple) style="--tw-divide-opacity: 1; --tw-divide-color: var(--docs-border, #e2e8f0);" @endif
                >
                    @foreach ($items as $index => $itemData)
                        @if ($isGrid)
                            <div
                                class="rounded-xl p-4 text-center transition-all duration-200 shadow-sm ring-1 hover:shadow-md"
                                style="background: var(--docs-bg, #ffffff); --tw-ring-color: var(--docs-border, #e2e8f0);"
                            >
                                {{ $slot }}
                            </div>
                        @elseif ($isContained)
                            <div
                                class="rounded-xl shadow-sm ring-1 p-4"
                                style="background: var(--docs-bg, #ffffff); --tw-ring-color: var(--docs-border, #e2e8f0);"
                            >
                                {{ $slot }}
                            </div>
                        @elseif ($isSimple)
                            <div class="flex items-center gap-3 py-2 first:pt-0 last:pb-0">
                                {{ $slot }}
                            </div>
                        @else
                            <div
                                class="pb-3 border-b last:border-0 last:pb-0"
                                style="border-color: var(--docs-border, #e2e8f0);"
                            >
                                {{ $slot }}
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <span class="text-gray-400 dark:text-gray-500">{{ $placeholder }}</span>
            @endif

            @if ($helperText)
                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">{{ $helperText }}</p>
            @endif
        </div>
    </div>
@endif
