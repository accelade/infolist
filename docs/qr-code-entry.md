# QR Code Entry

The QrCodeEntry component displays QR codes and barcodes generated from data.

## Blade Component Usage

The infolist package provides blade components for easy integration:

```blade
{{-- Create an infolist with QR code entry --}}
@php
use Accelade\Infolists\Infolist;
use Accelade\Infolists\Components\QrCodeEntry;

$infolist = Infolist::make()
    ->record($data)
    ->schema([
        QrCodeEntry::make('url')
            ->label('Scan QR Code'),
    ]);
@endphp

{{-- Render using the blade component --}}
<x-accelade::infolist :infolist="$infolist" />
```

## Basic Usage

```php
use Accelade\Infolists\Components\QrCodeEntry;

QrCodeEntry::make('url')
    ->label('Scan QR Code'),
```

## QR Code Mode

Display data as a QR code (default):

```php
QrCodeEntry::make('product_url')
    ->qr()
    ->label('Product URL'),
```

## Barcode Mode

Display data as a barcode:

```php
// Default barcode format (code128)
QrCodeEntry::make('sku')
    ->barcode()
    ->label('Product SKU'),

// Specific barcode format
QrCodeEntry::make('isbn')
    ->barcode('ean13')
    ->label('ISBN'),
```

### Available Barcode Formats

- `code128` (default)
- `code39`
- `ean13`
- `ean8`
- `upca`

## Size

Set the QR code/barcode size in pixels:

```php
QrCodeEntry::make('url')
    ->qrSize(256), // 256x256 pixels

QrCodeEntry::make('small_code')
    ->qrSize(64), // 64x64 pixels
```

## Colors

Customize QR code colors:

```php
QrCodeEntry::make('url')
    ->qrColor('FF0000')        // Red foreground
    ->qrBackgroundColor('FFFF00'),  // Yellow background
```

## Barcode Dimensions

Control barcode height and width:

```php
QrCodeEntry::make('sku')
    ->barcode('code128')
    ->barcodeHeight(80)  // Height in pixels
    ->barcodeWidth(3),   // Bar width multiplier
```

## Barcode Text Options

Control the text displayed below the barcode:

```php
QrCodeEntry::make('sku')
    ->barcode('code128')
    ->showText()              // Show text (default)
    ->hideText()              // Hide text
    ->textSize(16)            // Custom text size
    ->textAlign('center'),    // left, center, right
```

## Downloadable

Allow users to download the QR code/barcode as SVG:

```php
QrCodeEntry::make('ticket_code')
    ->qr()
    ->downloadable(),
```

## Using with Grid Layout

Combine with schema components for layouts:

```php
use Accelade\Infolists\Infolist;
use Accelade\Infolists\Components\QrCodeEntry;
use Accelade\Schemas\Components\Grid;

$infolist = Infolist::make()
    ->record($data)
    ->schema([
        Grid::make(4)->schema([
            QrCodeEntry::make('url')->label('64px')->qrSize(64),
            QrCodeEntry::make('url')->label('96px')->qrSize(96),
            QrCodeEntry::make('url')->label('128px')->qrSize(128),
            QrCodeEntry::make('url')->label('200px')->qrSize(200),
        ]),
    ]);
```

## Complete Example

```php
use Accelade\Infolists\Infolist;
use Accelade\Infolists\Components\QrCodeEntry;
use Accelade\Infolists\Components\TextEntry;

Infolist::make()
    ->record($product)
    ->schema([
        TextEntry::make('name')
            ->label('Product Name'),

        QrCodeEntry::make('product_page_url')
            ->label('Scan to View')
            ->qr()
            ->qrSize(200)
            ->downloadable(),

        QrCodeEntry::make('sku')
            ->label('Barcode')
            ->barcode('code128')
            ->barcodeHeight(50)
            ->showText(),
    ]);
```

## Blade Component

Render the infolist using the blade component:

```blade
<x-accelade::infolist :infolist="$infolist" />
```

This renders all entries with proper styling and grid layout support.

## Standalone Blade Component

Use the QR code entry directly in Blade without the Infolist class:

```blade
<x-accelade::qr-code-entry
    label="Website QR"
    value="https://example.com"
/>

<x-accelade::qr-code-entry
    label="Custom QR"
    value="https://laravel.com"
    :qrSize="200"
    qrColor="3B82F6"
    qrBackgroundColor="FFFFFF"
/>

<x-accelade::qr-code-entry
    label="Product SKU"
    value="ABC-12345"
    mode="barcode"
    barcodeFormat="code128"
    :barcodeHeight="60"
/>
```

### Available Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `value` | string | null | The data to encode |
| `label` | string | null | The label text |
| `helperText` | string | null | Helper text below the code |
| `mode` | string | 'qr' | Display mode: 'qr' or 'barcode' |
| `qrSize` | int | 128 | QR code size in pixels |
| `qrColor` | string | '000000' | QR code foreground color (hex) |
| `qrBackgroundColor` | string | 'FFFFFF' | QR code background color (hex) |
| `barcodeFormat` | string | 'code128' | Barcode format: code128, code39, ean13, ean8, upca |
| `barcodeHeight` | int | 50 | Barcode height in pixels |
| `barcodeWidth` | int | 2 | Barcode bar width multiplier |
| `showText` | bool | true | Show text below barcode |
| `downloadable` | bool | false | Allow downloading as SVG |
