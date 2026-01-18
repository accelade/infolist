@props([
    'entry' => null,
    'value' => null,
    'label' => null,
    'helperText' => null,
    'placeholder' => '-',
    'circular' => false,
    'square' => false,
    'size' => 'md',
    'width' => null,
    'height' => null,
    'stacked' => false,
    'stackLimit' => null,
    'tooltip' => null,
    'url' => null,
    'openUrlInNewTab' => true,
    'loading' => 'lazy',
    'picture' => false,
    'sources' => [],
    'alt' => '',
])

@php
    if ($entry) {
        // Object-based usage
        $state = $entry->getState();
        $placeholder = $entry->getPlaceholder();
        $isCircular = $entry->isCircular();
        $isSquare = $entry->isSquare();
        $size = $entry->getImageSize();
        $width = $entry->getWidth();
        $height = $entry->getHeight();
        $isStacked = $entry->isStacked();
        $stackLimit = $entry->getStackLimit();
        $remainingCount = $entry->getRemainingCount();
        $tooltip = $entry->getTooltip();
        $url = $entry->getUrl();
        $shouldOpenUrlInNewTab = $entry->shouldOpenUrlInNewTab();
        $loadingAttr = $entry->getLoading();
        $usePicture = $entry->shouldUsePicture();
        $pictureSources = $entry->getSources();
        $altText = $entry->getAlt();
        $hasWrapper = true;
    } else {
        // Prop-based standalone usage
        $state = $value;
        $isCircular = $circular;
        $isSquare = $square;
        $isStacked = $stacked;
        $remainingCount = 0;
        $shouldOpenUrlInNewTab = $openUrlInNewTab;
        $loadingAttr = $loading;
        $usePicture = $picture;
        $pictureSources = $sources;
        $altText = $alt;
        $hasWrapper = false;
    }

    $images = is_array($state) ? $state : ($state ? [$state] : []);

    if ($stackLimit && count($images) > $stackLimit) {
        $remainingCount = count($images) - $stackLimit;
        $images = array_slice($images, 0, $stackLimit);
    }

    // Check if using custom pixel values
    $isCustomSize = $size === 'custom';

    // Named size classes
    $sizeClasses = match ($size) {
        'xs' => 'h-6 w-6',
        'sm' => 'h-8 w-8',
        'md' => 'h-10 w-10',
        'lg' => 'h-12 w-12',
        'xl' => 'h-16 w-16',
        '2xl' => 'h-20 w-20',
        'custom' => '', // No classes, use inline styles
        default => 'h-10 w-10',
    };

    // Build inline style for custom sizes
    $styleAttr = '';
    if ($isCustomSize && ($width || $height)) {
        $styles = [];
        if ($width) {
            $styles[] = "width: {$width}px";
        }
        if ($height) {
            $styles[] = "height: {$height}px";
        }
        $styleAttr = implode('; ', $styles);
    }

    $totalImages = count($images) + ($remainingCount > 0 ? 1 : 0);

    // Image classes for reuse
    $imageClasses = [
        $sizeClasses => ! $isCustomSize,
        'rounded-full' => $isCircular,
        'rounded-lg' => ! $isCircular && ! $isSquare,
        'rounded' => $isSquare,
        'object-cover' => true,
        'ring-2' => $isStacked,
        'shrink-0' => true,
    ];
@endphp

@if ($hasWrapper && $entry)
    <x-infolists::entry-wrapper :entry="$entry">
        @if (empty($images))
            <span style="color: var(--docs-text-muted, #64748b);">
                {{ $placeholder }}
            </span>
        @else
            <div @class([
                'flex items-center',
                'isolate flex -space-x-3' => $isStacked,
                'gap-2 flex-wrap' => ! $isStacked,
            ])>
                @foreach ($images as $index => $image)
                    @php
                        $imageUrl = $image;
                        if (! str_starts_with($image, 'http') && ! str_starts_with($image, '/')) {
                            $imageUrl = Storage::url($image);
                        }
                        // For stacked images, first image should be on top (highest z-index)
                        $zIndex = $isStacked ? (count($images) + 1 - $index) * 10 : 0;

                        // Build complete style attribute
                        $imgStyle = $styleAttr;
                        if ($isStacked) {
                            $imgStyle = $imgStyle ? "{$imgStyle}; z-index: {$zIndex}; position: relative; --tw-ring-color: var(--docs-bg, #ffffff)" : "z-index: {$zIndex}; position: relative; --tw-ring-color: var(--docs-bg, #ffffff)";
                        }
                    @endphp

                    @if ($url)
                        <a
                            href="{{ $url }}"
                            @if ($shouldOpenUrlInNewTab) target="_blank" rel="noopener noreferrer" @endif
                            style="z-index: {{ $zIndex }}; position: relative"
                        >
                    @endif

                    @if ($usePicture && ! empty($pictureSources))
                        <picture>
                            @foreach ($pictureSources as $source)
                                <source
                                    @if (isset($source['srcset'])) srcset="{{ $source['srcset'] }}" @endif
                                    @if (isset($source['media'])) media="{{ $source['media'] }}" @endif
                                    @if (isset($source['type'])) type="{{ $source['type'] }}" @endif
                                />
                            @endforeach
                            <img
                                src="{{ $imageUrl }}"
                                alt="{{ $altText }}"
                                loading="{{ $loadingAttr }}"
                                @if ($tooltip) title="{{ $tooltip }}" @endif
                                @if ($imgStyle) style="{{ $imgStyle }}" @endif
                                @class($imageClasses)
                            />
                        </picture>
                    @else
                        <img
                            src="{{ $imageUrl }}"
                            alt="{{ $altText }}"
                            loading="{{ $loadingAttr }}"
                            @if ($tooltip) title="{{ $tooltip }}" @endif
                            @if ($imgStyle) style="{{ $imgStyle }}" @endif
                            @class($imageClasses)
                        />
                    @endif

                    @if ($url)
                        </a>
                    @endif
                @endforeach

                @if ($remainingCount > 0)
                    @php
                        $remainingStyle = $isCustomSize && $styleAttr ? "{$styleAttr}; z-index: 1; position: relative" : "z-index: 1; position: relative";
                        if ($isStacked) {
                            $remainingStyle .= '; --tw-ring-color: var(--docs-bg, #ffffff)';
                        }
                    @endphp
                    <div
                        style="{{ $remainingStyle }}; background: var(--docs-bg-alt, #f8fafc); color: var(--docs-text-muted, #64748b);"
                        @class([
                            $sizeClasses => ! $isCustomSize,
                            'rounded-full' => $isCircular,
                            'rounded-lg' => ! $isCircular && ! $isSquare,
                            'rounded' => $isSquare,
                            'flex items-center justify-center',
                            'text-xs font-medium',
                            'ring-2' => $isStacked,
                            'shrink-0',
                        ])
                    >
                        +{{ $remainingCount }}
                    </div>
                @endif
            </div>
        @endif
    </x-infolists::entry-wrapper>
@else
    {{-- Standalone blade component usage --}}
    <div {{ $attributes->class(['accelade-entry']) }}>
        @if ($label)
            <div class="accelade-entry-label mb-1">
                <span class="text-sm font-medium" style="color: var(--docs-text-muted, #64748b);">{{ $label }}</span>
            </div>
        @endif

        <div class="accelade-entry-content">
            @if (empty($images))
                <span style="color: var(--docs-text-muted, #64748b);">{{ $placeholder }}</span>
            @else
                <div @class([
                    'flex items-center',
                    'isolate flex -space-x-3' => $isStacked,
                    'gap-2 flex-wrap' => ! $isStacked,
                ])>
                    @foreach ($images as $index => $image)
                        @php
                            $imageUrl = $image;
                            if (! str_starts_with($image, 'http') && ! str_starts_with($image, '/')) {
                                $imageUrl = Storage::url($image);
                            }
                            $zIndex = $isStacked ? (count($images) + 1 - $index) * 10 : 0;
                            $imgStyle = $styleAttr;
                            if ($isStacked) {
                                $imgStyle = $imgStyle ? "{$imgStyle}; z-index: {$zIndex}; position: relative; --tw-ring-color: var(--docs-bg, #ffffff)" : "z-index: {$zIndex}; position: relative; --tw-ring-color: var(--docs-bg, #ffffff)";
                            }
                        @endphp

                        @if ($url)
                            <a
                                href="{{ $url }}"
                                @if ($shouldOpenUrlInNewTab) target="_blank" rel="noopener noreferrer" @endif
                                style="z-index: {{ $zIndex }}; position: relative"
                            >
                        @endif

                        @if ($usePicture && ! empty($pictureSources))
                            <picture>
                                @foreach ($pictureSources as $source)
                                    <source
                                        @if (isset($source['srcset'])) srcset="{{ $source['srcset'] }}" @endif
                                        @if (isset($source['media'])) media="{{ $source['media'] }}" @endif
                                        @if (isset($source['type'])) type="{{ $source['type'] }}" @endif
                                    />
                                @endforeach
                                <img
                                    src="{{ $imageUrl }}"
                                    alt="{{ $altText }}"
                                    loading="{{ $loadingAttr }}"
                                    @if ($tooltip) title="{{ $tooltip }}" @endif
                                    @if ($imgStyle) style="{{ $imgStyle }}" @endif
                                    @class($imageClasses)
                                />
                            </picture>
                        @else
                            <img
                                src="{{ $imageUrl }}"
                                alt="{{ $altText }}"
                                loading="{{ $loadingAttr }}"
                                @if ($tooltip) title="{{ $tooltip }}" @endif
                                @if ($imgStyle) style="{{ $imgStyle }}" @endif
                                @class($imageClasses)
                            />
                        @endif

                        @if ($url)
                            </a>
                        @endif
                    @endforeach

                    @if ($remainingCount > 0)
                        @php
                            $remainingStyle = $isCustomSize && $styleAttr ? "{$styleAttr}; z-index: 1; position: relative" : "z-index: 1; position: relative";
                            if ($isStacked) {
                                $remainingStyle .= '; --tw-ring-color: var(--docs-bg, #ffffff)';
                            }
                        @endphp
                        <div
                            style="{{ $remainingStyle }}; background: var(--docs-bg-alt, #f8fafc); color: var(--docs-text-muted, #64748b);"
                            @class([
                                $sizeClasses => ! $isCustomSize,
                                'rounded-full' => $isCircular,
                                'rounded-lg' => ! $isCircular && ! $isSquare,
                                'rounded' => $isSquare,
                                'flex items-center justify-center',
                                'text-xs font-medium',
                                'ring-2' => $isStacked,
                                'shrink-0',
                            ])
                        >
                            +{{ $remainingCount }}
                        </div>
                    @endif
                </div>
            @endif

            @if ($helperText)
                <p class="mt-1 text-xs" style="color: var(--docs-text-muted, #64748b);">{{ $helperText }}</p>
            @endif
        </div>
    </div>
@endif
