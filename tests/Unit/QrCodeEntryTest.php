<?php

declare(strict_types=1);

use Accelade\Infolists\Components\QrCodeEntry;

it('can create a qr code entry', function () {
    $entry = QrCodeEntry::make('code');

    expect($entry->getName())->toBe('code');
});

it('defaults to qr type', function () {
    $entry = QrCodeEntry::make('code');

    expect($entry->isQr())->toBeTrue();
    expect($entry->isBarcode())->toBeFalse();
});

it('can set barcode type', function () {
    $entry = QrCodeEntry::make('code')
        ->barcode();

    expect($entry->isBarcode())->toBeTrue();
    expect($entry->isQr())->toBeFalse();
});

it('can set barcode format', function () {
    $entry = QrCodeEntry::make('code')
        ->barcode('code128');

    expect($entry->getBarcodeFormat())->toBe('code128');
});

it('can switch to qr type', function () {
    $entry = QrCodeEntry::make('code')
        ->barcode()
        ->qr();

    expect($entry->isQr())->toBeTrue();
});

it('has default size of 128', function () {
    $entry = QrCodeEntry::make('code');

    expect($entry->getQrSize())->toBe(128);
});

it('can set custom size', function () {
    $entry = QrCodeEntry::make('code')
        ->qrSize(256);

    expect($entry->getQrSize())->toBe(256);
});

it('has default color of black', function () {
    $entry = QrCodeEntry::make('code');

    expect($entry->getColor())->toBe('000000');
});

it('can set custom color', function () {
    $entry = QrCodeEntry::make('code')
        ->qrColor('FF0000');

    expect($entry->getColor())->toBe('FF0000');
});

it('has default background color of white', function () {
    $entry = QrCodeEntry::make('code');

    expect($entry->getBackgroundColor())->toBe('FFFFFF');
});

it('can set custom background color', function () {
    $entry = QrCodeEntry::make('code')
        ->qrBackgroundColor('EEEEEE');

    expect($entry->getBackgroundColor())->toBe('EEEEEE');
});

it('generates qr code svg', function () {
    $entry = QrCodeEntry::make('code')
        ->record(['code' => 'test-data']);

    $svg = $entry->generateQrCodeSvg();

    expect($svg)->toContain('<svg');
    expect($svg)->toContain('</svg>');
});

it('generates barcode svg', function () {
    $entry = QrCodeEntry::make('code')
        ->barcode('code128')
        ->record(['code' => '12345']);

    $svg = $entry->generateBarcodeSvg();

    expect($svg)->toContain('<svg');
    expect($svg)->toContain('</svg>');
});

it('returns null svg when state is empty', function () {
    $entry = QrCodeEntry::make('code')
        ->record([]);

    expect($entry->generateQrCodeSvg())->toBeNull();
});

it('can be downloadable', function () {
    $entry = QrCodeEntry::make('code')
        ->downloadable();

    expect($entry->isDownloadable())->toBeTrue();
});

it('is not downloadable by default', function () {
    $entry = QrCodeEntry::make('code');

    expect($entry->isDownloadable())->toBeFalse();
});

it('can set barcode height', function () {
    $entry = QrCodeEntry::make('code')
        ->barcode('code128')
        ->barcodeHeight(80);

    expect($entry->getBarcodeHeight())->toBe(80);
});

it('can set barcode width', function () {
    $entry = QrCodeEntry::make('code')
        ->barcode('code128')
        ->barcodeWidth(3);

    expect($entry->getBarcodeWidth())->toBe(3);
});

it('can show text', function () {
    $entry = QrCodeEntry::make('code')
        ->barcode('code128')
        ->showText();

    expect($entry->shouldShowText())->toBeTrue();
});

it('can hide text', function () {
    $entry = QrCodeEntry::make('code')
        ->barcode('code128')
        ->hideText();

    expect($entry->shouldShowText())->toBeFalse();
});

it('can set text align', function () {
    $entry = QrCodeEntry::make('code')
        ->barcode('code128')
        ->textAlign('left');

    expect($entry->getTextAlign())->toBe('left');
});

it('can set text size', function () {
    $entry = QrCodeEntry::make('code')
        ->barcode('code128')
        ->textSize(16);

    expect($entry->getTextSize())->toBe(16);
});

it('can set margin', function () {
    $entry = QrCodeEntry::make('code')
        ->margin(2);

    expect($entry->getMargin())->toBe(2);
});
