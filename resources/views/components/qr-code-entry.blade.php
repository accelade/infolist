@props([
    'entry' => null,
    'value' => null,
    'label' => null,
    'helperText' => null,
    'type' => 'qr',
    'barcodeFormat' => 'code128',
    'size' => 128,
    'color' => '000000',
    'backgroundColor' => 'FFFFFF',
    'margin' => 1,
    'barcodeHeight' => 50,
    'barcodeWidth' => 2,
    'showText' => true,
    'textAlign' => 'center',
    'textSize' => 12,
    'downloadable' => false,
    'placeholder' => '-',
])

@php
    use BaconQrCode\Renderer\Image\SvgImageBackEnd;
    use BaconQrCode\Renderer\ImageRenderer;
    use BaconQrCode\Renderer\RendererStyle\Fill;
    use BaconQrCode\Renderer\RendererStyle\RendererStyle;
    use BaconQrCode\Renderer\Color\Rgb;
    use BaconQrCode\Writer;
    use Picqer\Barcode\BarcodeGeneratorSVG;

    // Support both object-based and prop-based usage
    if ($entry) {
        // Object-based usage
        $state = $entry->getState();
        $placeholder = $entry->getPlaceholder();
        $isQr = $entry->isQr();
        $isBarcode = $entry->isBarcode();
        $size = $entry->getQrSize();
        $downloadable = $entry->isDownloadable();
        $showText = $entry->shouldShowText();
        $textAlign = $entry->getTextAlign();
        $textSize = $entry->getTextSize();
        $svg = $isQr ? $entry->generateQrCodeSvg() : $entry->generateBarcodeSvg();
        $hasWrapper = true;
    } else {
        // Prop-based standalone usage
        $state = $value;
        $isQr = $type === 'qr';
        $isBarcode = $type === 'barcode';
        $hasWrapper = false;

        // Generate SVG
        $svg = null;
        if ($state) {
            if ($isQr) {
                // Generate QR code
                $hexToRgb = function(string $hex): Rgb {
                    $hex = ltrim($hex, '#');
                    return new Rgb(
                        (int) hexdec(substr($hex, 0, 2)),
                        (int) hexdec(substr($hex, 2, 2)),
                        (int) hexdec(substr($hex, 4, 2))
                    );
                };

                $renderer = new ImageRenderer(
                    new RendererStyle($size, $margin, null, null, Fill::uniformColor(
                        $hexToRgb($backgroundColor),
                        $hexToRgb($color)
                    )),
                    new SvgImageBackEnd
                );
                $writer = new Writer($renderer);
                $svg = $writer->writeString((string) $state);
            } else {
                // Generate barcode
                $generator = new BarcodeGeneratorSVG;
                $barcodeType = match (strtolower($barcodeFormat)) {
                    'code39' => BarcodeGeneratorSVG::TYPE_CODE_39,
                    'code93' => BarcodeGeneratorSVG::TYPE_CODE_93,
                    'ean8' => BarcodeGeneratorSVG::TYPE_EAN_8,
                    'ean13' => BarcodeGeneratorSVG::TYPE_EAN_13,
                    'upca' => BarcodeGeneratorSVG::TYPE_UPC_A,
                    'upce' => BarcodeGeneratorSVG::TYPE_UPC_E,
                    default => BarcodeGeneratorSVG::TYPE_CODE_128,
                };
                $svg = $generator->getBarcode((string) $state, $barcodeType, $barcodeWidth, $barcodeHeight, '#' . $color);
            }
        }
    }

    $textAlignClass = match($textAlign) {
        'left' => 'text-left',
        'right' => 'text-right',
        default => 'text-center',
    };
@endphp

@if ($hasWrapper && $entry)
    <x-accelade::entry-wrapper :entry="$entry">
        @if ($state && $svg)
            <div class="inline-flex flex-col items-center gap-1">
                @if ($isQr)
                    <div class="rounded overflow-hidden" style="width: {{ $size }}px; height: {{ $size }}px;">
                        {!! $svg !!}
                    </div>
                @else
                    <div>
                        {!! $svg !!}
                    </div>
                    @if ($showText)
                        <span class="font-mono text-gray-700 dark:text-gray-300 {{ $textAlignClass }} w-full" style="font-size: {{ $textSize }}px; letter-spacing: 0.1em;">
                            {{ $state }}
                        </span>
                    @endif
                @endif

                @if ($downloadable)
                    @php $dataUri = 'data:image/svg+xml;base64,' . base64_encode($svg); @endphp
                    <a href="{{ $dataUri }}" download="{{ $isQr ? 'qrcode' : 'barcode' }}-{{ Str::slug($state) }}.svg" class="inline-flex items-center gap-1 text-xs text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 mt-1">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        Download
                    </a>
                @endif
            </div>
        @else
            <span class="text-gray-400 dark:text-gray-500">{{ $placeholder }}</span>
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
            @if ($state && $svg)
                <div class="inline-flex flex-col items-center gap-1">
                    @if ($isQr)
                        <div class="rounded overflow-hidden" style="width: {{ $size }}px; height: {{ $size }}px;">
                            {!! $svg !!}
                        </div>
                    @else
                        <div>
                            {!! $svg !!}
                        </div>
                        @if ($showText)
                            <span class="font-mono text-gray-700 dark:text-gray-300 {{ $textAlignClass }} w-full" style="font-size: {{ $textSize }}px; letter-spacing: 0.1em;">
                                {{ $state }}
                            </span>
                        @endif
                    @endif

                    @if ($downloadable)
                        @php $dataUri = 'data:image/svg+xml;base64,' . base64_encode($svg); @endphp
                        <a href="{{ $dataUri }}" download="{{ $isQr ? 'qrcode' : 'barcode' }}-{{ Str::slug($state) }}.svg" class="inline-flex items-center gap-1 text-xs text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 mt-1">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            Download
                        </a>
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
