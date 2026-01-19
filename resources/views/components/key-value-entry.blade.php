@props([
    'entry' => null,
    'value' => null,
    'label' => null,
    'helperText' => null,
    'placeholder' => '-',
    'keyLabel' => null,
    'valueLabel' => null,
])

@php
    if ($entry) {
        // Object-based usage
        $state = $entry->getState();
        $placeholder = $entry->getPlaceholder();
        $keyLabel = $entry->getKeyLabel();
        $valueLabel = $entry->getValueLabel();
        $hasWrapper = true;
    } else {
        // Prop-based standalone usage
        $state = $value;
        $hasWrapper = false;
    }
@endphp

@if ($hasWrapper && $entry)
    <x-accelade::entry-wrapper :entry="$entry">
        @if (is_array($state) && count($state) > 0)
            <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    @if ($keyLabel || $valueLabel)
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ $keyLabel ?? 'Key' }}
                                </th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ $valueLabel ?? 'Value' }}
                                </th>
                            </tr>
                        </thead>
                    @endif
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($state as $key => $val)
                            <tr>
                                <td class="px-4 py-2 text-sm font-medium text-gray-900 dark:text-gray-100 whitespace-nowrap">
                                    {{ $key }}
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-600 dark:text-gray-400">
                                    @if (is_array($val))
                                        <pre class="text-xs">{{ json_encode($val, JSON_PRETTY_PRINT) }}</pre>
                                    @elseif (is_bool($val))
                                        {{ $val ? 'true' : 'false' }}
                                    @elseif ($val === null)
                                        <span class="text-gray-400">null</span>
                                    @else
                                        {{ $val }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
            @if (is_array($state) && count($state) > 0)
                <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        @if ($keyLabel || $valueLabel)
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        {{ $keyLabel ?? 'Key' }}
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        {{ $valueLabel ?? 'Value' }}
                                    </th>
                                </tr>
                            </thead>
                        @endif
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($state as $key => $val)
                                <tr>
                                    <td class="px-4 py-2 text-sm font-medium text-gray-900 dark:text-gray-100 whitespace-nowrap">
                                        {{ $key }}
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-600 dark:text-gray-400">
                                        @if (is_array($val))
                                            <pre class="text-xs">{{ json_encode($val, JSON_PRETTY_PRINT) }}</pre>
                                        @elseif (is_bool($val))
                                            {{ $val ? 'true' : 'false' }}
                                        @elseif ($val === null)
                                            <span class="text-gray-400">null</span>
                                        @else
                                            {{ $val }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
