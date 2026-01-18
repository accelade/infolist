@props([
    'entry' => null,
    'value' => null,
    'label' => null,
    'helperText' => null,
    'placeholder' => '-',
    'copyable' => false,
    'copyMessage' => 'Copied!',
    'copyMessageDuration' => 2000,
    'url' => null,
    'openUrlInNewTab' => false,
    'tooltip' => null,
    'badge' => false,
    'badgeColor' => 'gray',
    'icon' => null,
    'iconPosition' => 'before',
    'iconColor' => null,
    'color' => null,
    'size' => 'base',
    'weight' => 'normal',
    'listWithLineBreaks' => false,
    'bulleted' => false,
    'separator' => ', ',
    'markdown' => false,
    'html' => false,
])

@php
    // Support both object-based and prop-based usage
    if ($entry) {
        // Object-based usage
        $state = $entry->getState();
        $formattedState = $entry->getFormattedState();
        $displayValue = $formattedState ?? $state;
        $placeholder = $entry->getPlaceholder();
        $isCopyable = $entry->isCopyable();
        $copyMessage = $entry->getCopyMessage();
        $copyMessageDuration = $entry->getCopyMessageDuration();
        $url = $entry->getUrl();
        $shouldOpenUrlInNewTab = $entry->shouldOpenUrlInNewTab();
        $tooltip = $entry->getTooltip();
        $isBadge = $entry->isBadge();
        $badgeColor = $entry->getBadgeColor();
        $icon = $entry->getIcon();
        $iconPosition = $entry->getIconPosition();
        $iconColor = $entry->getIconColor();
        $color = $entry->getColor();
        $sizeClasses = $entry->getSizeClasses();
        $weightClasses = $entry->getWeightClasses();
        $isListWithLineBreaks = $entry->isListWithLineBreaks();
        $isBulleted = $entry->isBulleted();
        $separator = $entry->getSeparator();
        $isMarkdown = $entry->isMarkdown();
        $isHtml = $entry->isHtml();
        $hasWrapper = true;
    } else {
        // Prop-based standalone usage
        $state = $value;
        $displayValue = $value;
        $isCopyable = $copyable;
        $shouldOpenUrlInNewTab = $openUrlInNewTab;
        $isBadge = $badge;
        $isListWithLineBreaks = $listWithLineBreaks;
        $isBulleted = $bulleted;
        $isMarkdown = $markdown;
        $isHtml = $html;
        $hasWrapper = false;

        $sizeClasses = match($size) {
            'xs' => 'text-xs',
            'sm' => 'text-sm',
            'lg' => 'text-lg',
            'xl' => 'text-xl',
            default => 'text-base',
        };

        $weightClasses = match($weight) {
            'thin' => 'font-thin',
            'light' => 'font-light',
            'medium' => 'font-medium',
            'semibold' => 'font-semibold',
            'bold' => 'font-bold',
            default => 'font-normal',
        };
    }

    $getColorClasses = function($color) {
        return match($color) {
            'primary' => 'text-primary-600 dark:text-primary-400',
            'success' => 'text-success-600 dark:text-success-400',
            'warning' => 'text-warning-600 dark:text-warning-400',
            'danger' => 'text-danger-600 dark:text-danger-400',
            'info' => 'text-info-600 dark:text-info-400',
            default => 'text-gray-900 dark:text-gray-100',
        };
    };

    $getBadgeColorClasses = function($badgeColor) {
        return match($badgeColor) {
            'primary' => 'bg-primary-50 text-primary-700 ring-primary-700/10 dark:bg-primary-400/10 dark:text-primary-400 dark:ring-primary-400/30',
            'success' => 'bg-success-50 text-success-700 ring-success-700/10 dark:bg-success-400/10 dark:text-success-400 dark:ring-success-400/30',
            'warning' => 'bg-warning-50 text-warning-700 ring-warning-700/10 dark:bg-warning-400/10 dark:text-warning-400 dark:ring-warning-400/30',
            'danger' => 'bg-danger-50 text-danger-700 ring-danger-700/10 dark:bg-danger-400/10 dark:text-danger-400 dark:ring-danger-400/30',
            'info' => 'bg-info-50 text-info-700 ring-info-700/10 dark:bg-info-400/10 dark:text-info-400 dark:ring-info-400/30',
            default => 'bg-gray-50 text-gray-700 ring-gray-700/10 dark:bg-gray-400/10 dark:text-gray-400 dark:ring-gray-400/30',
        };
    };
@endphp

@if ($hasWrapper && $entry)
    <x-infolists::entry-wrapper :entry="$entry">
        @if ($displayValue === null || $displayValue === '')
            <span class="text-gray-400 dark:text-gray-500 {{ $sizeClasses }}">
                {{ $placeholder }}
            </span>
        @else
            @php
                $values = is_array($displayValue) ? $displayValue : [$displayValue];
            @endphp

            @if ($isBulleted && is_array($displayValue))
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($values as $value)
                        <li @class([
                            $sizeClasses,
                            $weightClasses,
                            $entry->getColorClasses($color),
                        ])>
                            @include('infolists::components.partials.text-value', [
                                'value' => $value,
                                'entry' => $entry,
                            ])
                        </li>
                    @endforeach
                </ul>
            @elseif ($isListWithLineBreaks && is_array($displayValue))
                <div class="space-y-1">
                    @foreach ($values as $value)
                        <div @class([
                            $sizeClasses,
                            $weightClasses,
                            $entry->getColorClasses($color),
                        ])>
                            @include('infolists::components.partials.text-value', [
                                'value' => $value,
                                'entry' => $entry,
                            ])
                        </div>
                    @endforeach
                </div>
            @else
                @php
                    $displayText = is_array($displayValue)
                        ? implode($separator, $displayValue)
                        : $displayValue;
                @endphp

                <div
                    @if ($isCopyable)
                        data-copyable
                        data-copy-value="{{ is_array($state) ? implode("\n", $state) : $state }}"
                        data-copy-message="{{ $copyMessage }}"
                        data-copy-message-duration="{{ $copyMessageDuration }}"
                    @endif
                    @if ($tooltip)
                        title="{{ $tooltip }}"
                    @endif
                    @class([
                        'inline-flex items-center gap-x-2',
                        'cursor-pointer hover:opacity-75 transition-opacity' => $isCopyable,
                        $sizeClasses => !$isBadge,
                        $weightClasses => !$isBadge,
                        $entry->getColorClasses($color) => !$isBadge,
                        'inline-flex items-center justify-center gap-x-1 rounded-md px-2.5 py-1 text-xs font-semibold ring-1 ring-inset shadow-sm hover:shadow transition-all duration-150' => $isBadge,
                        $entry->getBadgeColorClasses() => $isBadge,
                    ])
                >
                    @if ($icon && $iconPosition === 'before')
                        <x-accelade::icon
                            :name="$icon"
                            @class([
                                'h-4 w-4 shrink-0',
                                $entry->getColorClasses($iconColor),
                            ])
                        />
                    @endif

                    @if ($url)
                        <a
                            href="{{ $url }}"
                            @if ($shouldOpenUrlInNewTab) target="_blank" rel="noopener noreferrer" @endif
                            class="hover:underline"
                        >
                    @endif

                    @if ($isMarkdown)
                        <div class="prose prose-sm dark:prose-invert max-w-none">
                            {!! Str::markdown($displayText) !!}
                        </div>
                    @elseif ($isHtml)
                        {!! $displayText !!}
                    @else
                        <span>{{ $displayText }}</span>
                    @endif

                    @if ($url)
                        </a>
                    @endif

                    @if ($icon && $iconPosition === 'after')
                        <x-accelade::icon
                            :name="$icon"
                            @class([
                                'h-4 w-4 shrink-0',
                                $entry->getColorClasses($iconColor),
                            ])
                        />
                    @endif

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
            @endif
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
            @if ($displayValue === null || $displayValue === '')
                <span class="text-gray-400 dark:text-gray-500 {{ $sizeClasses }}">
                    {{ $placeholder }}
                </span>
            @else
                @php
                    $values = is_array($displayValue) ? $displayValue : [$displayValue];
                    $displayText = is_array($displayValue) ? implode($separator, $displayValue) : $displayValue;
                @endphp

                @if ($isBulleted && is_array($displayValue))
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($values as $val)
                            <li @class([$sizeClasses, $weightClasses, $getColorClasses($color)])>
                                {{ $val }}
                            </li>
                        @endforeach
                    </ul>
                @elseif ($isListWithLineBreaks && is_array($displayValue))
                    <div class="space-y-1">
                        @foreach ($values as $val)
                            <div @class([$sizeClasses, $weightClasses, $getColorClasses($color)])>
                                {{ $val }}
                            </div>
                        @endforeach
                    </div>
                @else
                    <div
                        @if ($isCopyable)
                            data-copyable
                            data-copy-value="{{ is_array($state) ? implode("\n", $state) : $state }}"
                            data-copy-message="{{ $copyMessage }}"
                            data-copy-message-duration="{{ $copyMessageDuration }}"
                        @endif
                        @if ($tooltip)
                            title="{{ $tooltip }}"
                        @endif
                        @class([
                            'inline-flex items-center gap-x-2',
                            'cursor-pointer hover:opacity-75 transition-opacity' => $isCopyable,
                            $sizeClasses => !$isBadge,
                            $weightClasses => !$isBadge,
                            $getColorClasses($color) => !$isBadge,
                            'inline-flex items-center justify-center gap-x-1 rounded-md px-2.5 py-1 text-xs font-semibold ring-1 ring-inset shadow-sm' => $isBadge,
                            $getBadgeColorClasses($badgeColor) => $isBadge,
                        ])
                    >
                        @if ($icon && $iconPosition === 'before')
                            <x-accelade::icon :name="$icon" @class(['h-4 w-4 shrink-0', $getColorClasses($iconColor)]) />
                        @endif

                        @if ($url)
                            <a href="{{ $url }}" @if ($shouldOpenUrlInNewTab) target="_blank" rel="noopener noreferrer" @endif class="hover:underline">
                        @endif

                        @if ($isMarkdown)
                            <div class="prose prose-sm dark:prose-invert max-w-none">{!! Str::markdown($displayText) !!}</div>
                        @elseif ($isHtml)
                            {!! $displayText !!}
                        @else
                            <span>{{ $displayText }}</span>
                        @endif

                        @if ($url)
                            </a>
                        @endif

                        @if ($icon && $iconPosition === 'after')
                            <x-accelade::icon :name="$icon" @class(['h-4 w-4 shrink-0', $getColorClasses($iconColor)]) />
                        @endif

                        @if ($isCopyable)
                            <button type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" data-copy-trigger>
                                <x-accelade::icon name="heroicon-o-clipboard" class="h-4 w-4" />
                            </button>
                        @endif
                    </div>
                @endif
            @endif

            @if ($helperText)
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $helperText }}</p>
            @endif
        </div>
    </div>
@endif
