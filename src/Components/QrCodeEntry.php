<?php

declare(strict_types=1);

namespace Accelade\Infolists\Components;

use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Closure;
use Picqer\Barcode\BarcodeGeneratorSVG;

class QrCodeEntry extends Entry
{
    protected string $type = 'qr';

    protected ?string $barcodeFormat = null;

    protected int|Closure $qrSize = 128;

    protected string|Closure $qrColor = '000000';

    protected string|Closure $qrBackgroundColor = 'FFFFFF';

    protected int|Closure $errorCorrection = 1;

    protected int|Closure $margin = 1;

    protected bool $downloadable = false;

    protected int|Closure $barcodeHeight = 50;

    protected int|Closure $barcodeWidth = 2;

    protected bool|Closure $showText = true;

    protected string|Closure $textAlign = 'center';

    protected int|Closure $textSize = 12;

    public function qr(): static
    {
        $this->type = 'qr';

        return $this;
    }

    public function barcode(?string $format = null): static
    {
        $this->type = 'barcode';
        $this->barcodeFormat = $format;

        return $this;
    }

    public function qrSize(int|Closure $size): static
    {
        $this->qrSize = $size;

        return $this;
    }

    public function barcodeHeight(int|Closure $height): static
    {
        $this->barcodeHeight = $height;

        return $this;
    }

    public function barcodeWidth(int|Closure $width): static
    {
        $this->barcodeWidth = $width;

        return $this;
    }

    public function showText(bool|Closure $condition = true): static
    {
        $this->showText = $condition;

        return $this;
    }

    public function hideText(): static
    {
        $this->showText = false;

        return $this;
    }

    public function textAlign(string|Closure $align): static
    {
        $this->textAlign = $align;

        return $this;
    }

    public function textSize(int|Closure $size): static
    {
        $this->textSize = $size;

        return $this;
    }

    public function downloadable(bool $condition = true): static
    {
        $this->downloadable = $condition;

        return $this;
    }

    public function isDownloadable(): bool
    {
        return $this->downloadable;
    }

    public function getBarcodeFormat(): ?string
    {
        return $this->barcodeFormat;
    }

    public function qrColor(string|Closure $color): static
    {
        $this->qrColor = $color;

        return $this;
    }

    public function qrBackgroundColor(string|Closure $color): static
    {
        $this->qrBackgroundColor = $color;

        return $this;
    }

    public function errorCorrection(int|Closure $level): static
    {
        $this->errorCorrection = $level;

        return $this;
    }

    public function margin(int|Closure $margin): static
    {
        $this->margin = $margin;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getQrSize(): int
    {
        return (int) $this->evaluate($this->qrSize);
    }

    public function getBarcodeHeight(): int
    {
        return (int) $this->evaluate($this->barcodeHeight);
    }

    public function getBarcodeWidth(): int
    {
        return (int) $this->evaluate($this->barcodeWidth);
    }

    public function shouldShowText(): bool
    {
        return (bool) $this->evaluate($this->showText);
    }

    public function getTextAlign(): string
    {
        return $this->evaluate($this->textAlign);
    }

    public function getTextSize(): int
    {
        return (int) $this->evaluate($this->textSize);
    }

    public function getQrColor(): string
    {
        return $this->evaluate($this->qrColor);
    }

    public function getQrBackgroundColor(): string
    {
        return $this->evaluate($this->qrBackgroundColor);
    }

    public function getColor(): string
    {
        return $this->getQrColor();
    }

    public function getBackgroundColor(): string
    {
        return $this->getQrBackgroundColor();
    }

    /**
     * Generate QR code SVG using BaconQrCode.
     */
    public function generateQrCodeSvg(): ?string
    {
        $data = $this->getState();

        if (empty($data)) {
            return null;
        }

        $size = $this->getQrSize();
        $margin = $this->getMargin();

        $renderer = new ImageRenderer(
            new RendererStyle($size, $margin, null, null, Fill::uniformColor(
                $this->hexToRgb($this->getBackgroundColor()),
                $this->hexToRgb($this->getColor())
            )),
            new SvgImageBackEnd
        );

        $writer = new Writer($renderer);

        return $writer->writeString((string) $data);
    }

    /**
     * Generate barcode SVG using Picqer.
     */
    public function generateBarcodeSvg(): ?string
    {
        $data = $this->getState();

        if (empty($data)) {
            return null;
        }

        $format = $this->getBarcodeFormat() ?? 'code128';
        $height = $this->getBarcodeHeight();
        $width = $this->getBarcodeWidth();
        $color = '#'.$this->getColor();

        $generator = new BarcodeGeneratorSVG;

        $barcodeType = $this->mapBarcodeFormat($format);

        return $generator->getBarcode((string) $data, $barcodeType, $width, $height, $color);
    }

    /**
     * Map format string to Picqer barcode type constant.
     */
    protected function mapBarcodeFormat(string $format): string
    {
        return match (strtolower($format)) {
            'code39' => BarcodeGeneratorSVG::TYPE_CODE_39,
            'code93' => BarcodeGeneratorSVG::TYPE_CODE_93,
            'code128', 'code128a', 'code128b', 'code128c' => BarcodeGeneratorSVG::TYPE_CODE_128,
            'ean8' => BarcodeGeneratorSVG::TYPE_EAN_8,
            'ean13' => BarcodeGeneratorSVG::TYPE_EAN_13,
            'upca' => BarcodeGeneratorSVG::TYPE_UPC_A,
            'upce' => BarcodeGeneratorSVG::TYPE_UPC_E,
            'itf14' => BarcodeGeneratorSVG::TYPE_ITF_14,
            'interleaved2of5', 'i25' => BarcodeGeneratorSVG::TYPE_INTERLEAVED_2_5,
            'codabar' => BarcodeGeneratorSVG::TYPE_CODABAR,
            'pharmacode' => BarcodeGeneratorSVG::TYPE_PHARMA_CODE,
            default => BarcodeGeneratorSVG::TYPE_CODE_128,
        };
    }

    /**
     * Convert hex color to BaconQrCode RGB color.
     */
    protected function hexToRgb(string $hex): \BaconQrCode\Renderer\Color\Rgb
    {
        $hex = ltrim($hex, '#');

        return new \BaconQrCode\Renderer\Color\Rgb(
            (int) hexdec(substr($hex, 0, 2)),
            (int) hexdec(substr($hex, 2, 2)),
            (int) hexdec(substr($hex, 4, 2))
        );
    }

    public function getErrorCorrection(): int
    {
        return (int) $this->evaluate($this->errorCorrection);
    }

    public function getMargin(): int
    {
        return (int) $this->evaluate($this->margin);
    }

    public function isQr(): bool
    {
        return $this->type === 'qr';
    }

    public function isBarcode(): bool
    {
        return $this->type === 'barcode';
    }

    protected function getViewName(): string
    {
        return 'infolists::components.qr-code-entry';
    }
}
