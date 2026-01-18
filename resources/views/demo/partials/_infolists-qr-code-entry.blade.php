@php
    use Accelade\Infolists\Infolist;
    use Accelade\Infolists\Components\QrCodeEntry;
    use Accelade\Schemas\Components\Grid;
    use Accelade\Schemas\Components\Section;

    $data = [
        'url' => 'https://example.com/product/123',
        'sku' => 'SKU-12345678',
        'ticket' => 'TICKET-ABC-2024',
        'ean13' => '5901234123457',
        'upca' => '012345678905',
        'code39' => 'HELLO-123',
        'wifi' => 'WIFI:S:MyNetwork;T:WPA;P:password123;;',
        'email' => 'contact@example.com',
    ];

    // Basic QR Code
    $basicQrInfolist = Infolist::make()
        ->record($data)
        ->schema([
            QrCodeEntry::make('url')
                ->label('Product URL')
                ->helperText('Default 128x128 QR code'),
        ]);

    // QR Code Sizes - Using Grid from schemas!
    $qrSizesInfolist = Infolist::make()
        ->record($data)
        ->schema([
            Grid::make(4)->schema([
                QrCodeEntry::make('url')->label('64px')->qrSize(64),
                QrCodeEntry::make('url')->label('96px')->qrSize(96),
                QrCodeEntry::make('url')->label('128px (default)')->qrSize(128),
                QrCodeEntry::make('url')->label('200px')->qrSize(200),
            ]),
        ]);

    // QR Code Colors - Using Grid from schemas!
    $qrColorsInfolist = Infolist::make()
        ->record($data)
        ->schema([
            Grid::make(4)->schema([
                QrCodeEntry::make('url')->label('Default')->qrSize(100),
                QrCodeEntry::make('url')->label('Blue')->qrSize(100)->qrColor('0066CC')->qrBackgroundColor('E6F0FF'),
                QrCodeEntry::make('url')->label('Green')->qrSize(100)->qrColor('059669')->qrBackgroundColor('ECFDF5'),
                QrCodeEntry::make('url')->label('Purple')->qrSize(100)->qrColor('7C3AED')->qrBackgroundColor('F5F3FF'),
            ]),
        ]);

    // QR Code Margins - Using Grid from schemas!
    $qrMarginsInfolist = Infolist::make()
        ->record($data)
        ->schema([
            Grid::make(4)->schema([
                QrCodeEntry::make('url')->label('Margin 0')->qrSize(100)->margin(0),
                QrCodeEntry::make('url')->label('Margin 1 (default)')->qrSize(100)->margin(1),
                QrCodeEntry::make('url')->label('Margin 2')->qrSize(100)->margin(2),
                QrCodeEntry::make('url')->label('Margin 4')->qrSize(100)->margin(4),
            ]),
        ]);

    // Downloadable QR Code
    $downloadableQrInfolist = Infolist::make()
        ->record($data)
        ->schema([
            QrCodeEntry::make('ticket')
                ->label('Ticket Code')
                ->helperText('Click to download as SVG')
                ->qr()
                ->downloadable(),
        ]);

    // Use Cases - Using Grid from schemas!
    $useCasesInfolist = Infolist::make()
        ->record($data)
        ->schema([
            Grid::make(3)->schema([
                QrCodeEntry::make('wifi')->label('WiFi Network')->helperText('Scan to connect')->qrSize(120)->qrColor('3B82F6'),
                QrCodeEntry::make('email')->label('Email Contact')->helperText('Scan to email')->qrSize(120)->qrColor('10B981'),
                QrCodeEntry::make('url')->label('Website URL')->helperText('Scan to visit')->qrSize(120)->qrColor('8B5CF6'),
            ]),
        ]);

    // Basic Barcode
    $basicBarcodeInfolist = Infolist::make()
        ->record($data)
        ->schema([
            QrCodeEntry::make('sku')
                ->label('Product SKU')
                ->helperText('Code128 format with text label')
                ->barcode('code128'),
        ]);

    // Barcode Formats - Using Grid from schemas!
    $barcodeFormatsInfolist = Infolist::make()
        ->record($data)
        ->schema([
            Grid::make(2)->schema([
                QrCodeEntry::make('sku')->label('Code128')->barcode('code128'),
                QrCodeEntry::make('code39')->label('Code39')->barcode('code39'),
                QrCodeEntry::make('ean13')->label('EAN-13')->barcode('ean13'),
                QrCodeEntry::make('upca')->label('UPC-A')->barcode('upca'),
            ]),
        ]);

    // Barcode Dimensions - Using Grid from schemas!
    $barcodeDimensionsInfolist = Infolist::make()
        ->record($data)
        ->schema([
            Grid::make(3)->schema([
                QrCodeEntry::make('sku')->label('Small (h:30, w:1)')->barcode('code128')->barcodeHeight(30)->barcodeWidth(1),
                QrCodeEntry::make('sku')->label('Default (h:50, w:2)')->barcode('code128')->barcodeHeight(50)->barcodeWidth(2),
                QrCodeEntry::make('sku')->label('Large (h:80, w:3)')->barcode('code128')->barcodeHeight(80)->barcodeWidth(3),
            ]),
        ]);

    // Barcode Text Options - Using Grid from schemas!
    $barcodeTextOptionsInfolist = Infolist::make()
        ->record($data)
        ->schema([
            Grid::make(3)->schema([
                QrCodeEntry::make('sku')->label('With Text (default)')->barcode('code128')->showText(),
                QrCodeEntry::make('sku')->label('Without Text')->barcode('code128')->hideText(),
                QrCodeEntry::make('sku')->label('Large Text')->barcode('code128')->textSize(16),
            ]),
        ]);

    // Colored Barcodes - Using Grid from schemas!
    $barcodeColorsInfolist = Infolist::make()
        ->record($data)
        ->schema([
            Grid::make(3)->schema([
                QrCodeEntry::make('sku')->label('Black (default)')->barcode('code128'),
                QrCodeEntry::make('sku')->label('Blue')->barcode('code128')->qrColor('1D4ED8'),
                QrCodeEntry::make('sku')->label('Red')->barcode('code128')->qrColor('DC2626'),
            ]),
        ]);

    // Downloadable Barcode
    $downloadableBarcodeInfolist = Infolist::make()
        ->record($data)
        ->schema([
            QrCodeEntry::make('ean13')
                ->label('EAN-13 Barcode')
                ->helperText('Click to download as SVG')
                ->barcode('ean13')
                ->downloadable(),
        ]);
@endphp

<div class="space-y-8">
    {{-- QR CODE SECTION --}}
    <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">QR Code Examples</h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Generate QR codes with customizable size, colors, and
            margins</p>
    </div>

    {{-- Basic QR Code --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Basic QR Code</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Default QR code with 128x128 size</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$basicQrInfolist" />
        </div>
        <div class="p-6 pt-0">
            <x-accelade::code-block language="php">
QrCodeEntry::make('url')
    ->label('Product URL')
            </x-accelade::code-block>
        </div>
    </div>

    {{-- QR Code Sizes - Using Grid from Schemas! --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">QR Code Sizes</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Using Grid::make(4) from schemas package</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$qrSizesInfolist" />
        </div>
        <div class="p-6 pt-0">
            <x-accelade::code-block language="php">
use Accelade\Schemas\Components\Grid;

Infolist::make()
    ->record($data)
    ->schema([
        Grid::make(4)->schema([
            QrCodeEntry::make('url')->label('64px')->qrSize(64),
            QrCodeEntry::make('url')->label('96px')->qrSize(96),
            QrCodeEntry::make('url')->label('128px')->qrSize(128),
            QrCodeEntry::make('url')->label('200px')->qrSize(200),
        ]),
    ]);
            </x-accelade::code-block>
        </div>
    </div>

    {{-- QR Code Colors - Using Grid from Schemas! --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">QR Code Colors</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Custom foreground and background colors using hex
                values</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$qrColorsInfolist" />
        </div>
        <div class="p-6 pt-0">
            <x-accelade::code-block language="php">
QrCodeEntry::make('url')
    ->qrColor('0066CC')           // Blue foreground
    ->qrBackgroundColor('E6F0FF')  // Light blue background
            </x-accelade::code-block>
        </div>
    </div>

    {{-- QR Code Margins - Using Grid from Schemas! --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">QR Code Margins</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Control the quiet zone around the QR code</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$qrMarginsInfolist" />
        </div>
        <div class="p-6 pt-0">
            <x-accelade::code-block language="php">
QrCodeEntry::make('url')
    ->margin(0)  // No margin
    ->margin(1)  // Default
    ->margin(4)  // Large margin
            </x-accelade::code-block>
        </div>
    </div>

    {{-- Downloadable QR Code --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Downloadable QR Code</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">QR code with download button</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$downloadableQrInfolist" />
        </div>
        <div class="p-6 pt-0">
            <x-accelade::code-block language="php">
QrCodeEntry::make('ticket')
    ->qr()
    ->downloadable()
            </x-accelade::code-block>
        </div>
    </div>

    {{-- Use Cases - Using Grid from Schemas! --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Common Use Cases</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">WiFi networks, email addresses, URLs, and more</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$useCasesInfolist" />
        </div>
        <div class="p-6 pt-0">
            <x-accelade::code-block language="php">
use Accelade\Schemas\Components\Grid;

Infolist::make()
    ->record($data)
    ->schema([
        Grid::make(3)->schema([
            QrCodeEntry::make('wifi')
                ->label('WiFi Network')
                ->helperText('Scan to connect')
                ->qrSize(120)
                ->qrColor('3B82F6'),
            QrCodeEntry::make('email')
                ->label('Email Contact')
                ->helperText('Scan to email')
                ->qrSize(120),
            QrCodeEntry::make('url')
                ->label('Website URL')
                ->helperText('Scan to visit')
                ->qrSize(120),
        ]),
    ]);
            </x-accelade::code-block>
        </div>
    </div>

    {{-- BARCODE SECTION --}}
    <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mt-12">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Barcode Examples</h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Generate barcodes in various formats with customizable
            dimensions and text</p>
    </div>

    {{-- Basic Barcode --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Basic Barcode</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Code128 format with text label below</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$basicBarcodeInfolist" />
        </div>
        <div class="p-6 pt-0">
            <x-accelade::code-block language="php">
QrCodeEntry::make('sku')
    ->label('Product SKU')
    ->barcode('code128')
            </x-accelade::code-block>
        </div>
    </div>

    {{-- Barcode Formats - Using Grid from Schemas! --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Barcode Formats</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Using Grid::make(2) from schemas package</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$barcodeFormatsInfolist" />
        </div>
        <div class="p-6 pt-0">
            <x-accelade::code-block language="php">
use Accelade\Schemas\Components\Grid;

Infolist::make()
    ->record($data)
    ->schema([
        Grid::make(2)->schema([
            QrCodeEntry::make('sku')->label('Code128')->barcode('code128'),
            QrCodeEntry::make('code39')->label('Code39')->barcode('code39'),
            QrCodeEntry::make('ean13')->label('EAN-13')->barcode('ean13'),
            QrCodeEntry::make('upca')->label('UPC-A')->barcode('upca'),
        ]),
    ]);
            </x-accelade::code-block>
        </div>
    </div>

    {{-- Barcode Dimensions - Using Grid from Schemas! --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Barcode Dimensions</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Control height and bar width</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$barcodeDimensionsInfolist" />
        </div>
        <div class="p-6 pt-0">
            <x-accelade::code-block language="php">
QrCodeEntry::make('sku')
    ->barcode('code128')
    ->barcodeHeight(80)  // Height in pixels
    ->barcodeWidth(3)    // Bar width multiplier
            </x-accelade::code-block>
        </div>
    </div>

    {{-- Barcode Text Options - Using Grid from Schemas! --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Barcode Text Options</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Show, hide, or customize the text label</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$barcodeTextOptionsInfolist" />
        </div>
        <div class="p-6 pt-0">
            <x-accelade::code-block language="php">
QrCodeEntry::make('sku')
    ->barcode('code128')
    ->showText()      // Show text (default)
    ->hideText()      // Hide text
    ->textSize(16)    // Custom text size
    ->textAlign('center')  // left, center, right
            </x-accelade::code-block>
        </div>
    </div>

    {{-- Colored Barcodes - Using Grid from Schemas! --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Colored Barcodes</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Custom barcode colors using hex values</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$barcodeColorsInfolist" />
        </div>
        <div class="p-6 pt-0">
            <x-accelade::code-block language="php">
QrCodeEntry::make('sku')
    ->barcode('code128')
    ->qrColor('1D4ED8') // Blue barcode
            </x-accelade::code-block>
        </div>
    </div>

    {{-- Downloadable Barcode --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Downloadable Barcode</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Barcode with download button</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$downloadableBarcodeInfolist" />
        </div>
        <div class="p-6 pt-0">
            <x-accelade::code-block language="php">
QrCodeEntry::make('ean13')
    ->barcode('ean13')
    ->downloadable()
            </x-accelade::code-block>
        </div>
    </div>

    {{-- Standalone QR Code --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Standalone QR Code Component</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Use the blade component directly with props</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <x-infolists::qr-code-entry value="https://example.com" label="Default QR" />
                <x-infolists::qr-code-entry value="https://example.com" label="Small QR" :size="64" />
                <x-infolists::qr-code-entry value="https://example.com" label="Blue QR" color="0066CC"
                    backgroundColor="E6F0FF" />
                <x-infolists::qr-code-entry value="https://example.com" label="Downloadable" :downloadable="true" />
            </div>
        </div>
        <div class="p-6 pt-0">
            <x-accelade::code-block language="blade">
{{-- Basic QR Code --}}
&lt;x-infolists::qr-code-entry value="https://example.com" label="Default QR" /&gt;

{{-- Small QR Code --}}
&lt;x-infolists::qr-code-entry value="https://example.com" label="Small QR" :size="64" /&gt;

{{-- Colored QR Code --}}
&lt;x-infolists::qr-code-entry
    value="https://example.com"
    label="Blue QR"
    color="0066CC"
    backgroundColor="E6F0FF"
/&gt;

{{-- Downloadable QR Code --}}
&lt;x-infolists::qr-code-entry value="https://example.com" label="Downloadable" :downloadable="true" /&gt;
            </x-accelade::code-block>
        </div>
    </div>

    {{-- Standalone Barcode --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Standalone Barcode Component</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Use the blade component with barcode type</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <x-infolists::qr-code-entry value="SKU-12345678" label="Code128" type="barcode"
                    barcodeFormat="code128" />
                <x-infolists::qr-code-entry value="5901234123457" label="EAN-13" type="barcode" barcodeFormat="ean13" />
            </div>
        </div>
        <div class="p-6 pt-0">
            <x-accelade::code-block language="blade">
{{-- Code128 Barcode --}}
&lt;x-infolists::qr-code-entry
    value="SKU-12345678"
    label="Code128"
    type="barcode"
    barcodeFormat="code128"
/&gt;

{{-- EAN-13 Barcode --}}
&lt;x-infolists::qr-code-entry
    value="5901234123457"
    label="EAN-13"
    type="barcode"
    barcodeFormat="ean13"
/&gt;
            </x-accelade::code-block>
        </div>
    </div>
</div>
