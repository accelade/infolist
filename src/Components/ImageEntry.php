<?php

declare(strict_types=1);

namespace Accelade\Infolists\Components;

use Closure;

class ImageEntry extends Entry
{
    protected int|string|Closure|null $width = null;

    protected int|string|Closure|null $height = null;

    protected bool $isCircular = false;

    protected bool $isSquare = false;

    protected bool $isStacked = false;

    protected int|Closure|null $limit = null;

    protected int|Closure|null $limitedRemainingCount = null;

    protected string|Closure|null $defaultImageUrl = null;

    protected string|Closure|null $disk = null;

    protected string|Closure|null $visibility = null;

    protected bool $isCheckFileExistence = true;

    protected string $ring = 'none';

    protected int|Closure|null $overlap = null;

    protected string|Closure $loading = 'lazy';

    protected bool $usePicture = false;

    protected array|Closure $sources = [];

    protected string|Closure|null $alt = null;

    public function width(int|string|Closure|null $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function height(int|string|Closure|null $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function size(int|string $size): static
    {
        $this->width = $size;
        $this->height = $size;

        return $this;
    }

    public function circular(bool $condition = true): static
    {
        $this->isCircular = $condition;

        return $this;
    }

    public function square(bool $condition = true): static
    {
        $this->isSquare = $condition;

        return $this;
    }

    public function stacked(bool $condition = true): static
    {
        $this->isStacked = $condition;

        return $this;
    }

    public function limit(int|Closure|null $limit): static
    {
        $this->limit = $limit;

        return $this;
    }

    public function limitedRemainingText(int|Closure|null $count = null): static
    {
        $this->limitedRemainingCount = $count;

        return $this;
    }

    public function defaultImageUrl(string|Closure|null $url): static
    {
        $this->defaultImageUrl = $url;

        return $this;
    }

    public function disk(string|Closure|null $disk): static
    {
        $this->disk = $disk;

        return $this;
    }

    public function visibility(string|Closure|null $visibility): static
    {
        $this->visibility = $visibility;

        return $this;
    }

    public function checkFileExistence(bool $condition = true): static
    {
        $this->isCheckFileExistence = $condition;

        return $this;
    }

    public function ring(string $ring): static
    {
        $this->ring = $ring;

        return $this;
    }

    public function overlap(int|Closure|null $overlap): static
    {
        $this->overlap = $overlap;

        return $this;
    }

    /**
     * Set the loading attribute for the image.
     * Options: 'lazy', 'eager', 'auto'
     */
    public function loading(string|Closure $loading): static
    {
        $this->loading = $loading;

        return $this;
    }

    /**
     * Enable eager loading (disable lazy loading).
     */
    public function eager(): static
    {
        $this->loading = 'eager';

        return $this;
    }

    /**
     * Enable lazy loading (default).
     */
    public function lazy(bool $condition = true): static
    {
        $this->loading = $condition ? 'lazy' : 'eager';

        return $this;
    }

    /**
     * Enable the <picture> tag for responsive images.
     */
    public function picture(bool $condition = true): static
    {
        $this->usePicture = $condition;

        return $this;
    }

    /**
     * Add sources for the <picture> tag.
     * Each source should have: ['srcset' => '...', 'media' => '...', 'type' => '...']
     */
    public function sources(array|Closure $sources): static
    {
        $this->sources = $sources;

        return $this;
    }

    /**
     * Set the alt text for the image.
     */
    public function alt(string|Closure|null $alt): static
    {
        $this->alt = $alt;

        return $this;
    }

    public function getWidth(): ?string
    {
        $width = $this->evaluate($this->width);

        if ($width === null) {
            return null;
        }

        // If it's a named size, return null (use CSS classes instead)
        if (in_array($width, ['xs', 'sm', 'md', 'lg', 'xl', '2xl'], true)) {
            return null;
        }

        return (string) $width;
    }

    public function getHeight(): ?string
    {
        $height = $this->evaluate($this->height);

        if ($height === null) {
            return null;
        }

        // If it's a named size, return null (use CSS classes instead)
        if (in_array($height, ['xs', 'sm', 'md', 'lg', 'xl', '2xl'], true)) {
            return null;
        }

        return (string) $height;
    }

    public function isCircular(): bool
    {
        return $this->isCircular;
    }

    public function isSquare(): bool
    {
        return $this->isSquare;
    }

    public function isStacked(): bool
    {
        return $this->isStacked;
    }

    public function getLimit(): ?int
    {
        return $this->evaluate($this->limit);
    }

    public function getStackLimit(): ?int
    {
        return $this->getLimit();
    }

    public function remainingCount(int|Closure|null $count): static
    {
        $this->limitedRemainingCount = $count;

        return $this;
    }

    public function getRemainingCount(): ?int
    {
        return $this->evaluate($this->limitedRemainingCount);
    }

    public function getImageSize(): string
    {
        $width = $this->evaluate($this->width);

        if ($width === null) {
            return 'md';
        }

        // If it's a named size, return it
        if (in_array($width, ['xs', 'sm', 'md', 'lg', 'xl', '2xl'], true)) {
            return $width;
        }

        // Otherwise it's a numeric value, return 'custom'
        return 'custom';
    }

    public function getDefaultImageUrl(): ?string
    {
        return $this->evaluate($this->defaultImageUrl);
    }

    public function getDisk(): ?string
    {
        return $this->evaluate($this->disk);
    }

    public function getRing(): string
    {
        return $this->ring;
    }

    public function getOverlap(): int
    {
        return $this->evaluate($this->overlap) ?? 4;
    }

    public function getLoading(): string
    {
        return $this->evaluate($this->loading);
    }

    public function shouldUsePicture(): bool
    {
        return $this->usePicture;
    }

    public function getSources(): array
    {
        return $this->evaluate($this->sources);
    }

    public function getAlt(): ?string
    {
        return $this->evaluate($this->alt);
    }

    public function getImageUrls(): array
    {
        $state = $this->getState();

        if ($state === null) {
            $default = $this->getDefaultImageUrl();

            return $default ? [$default] : [];
        }

        if (is_string($state)) {
            return [$this->resolveImageUrl($state)];
        }

        if (is_array($state)) {
            return array_map(fn ($url) => $this->resolveImageUrl($url), $state);
        }

        return [];
    }

    protected function resolveImageUrl(string $path): string
    {
        $disk = $this->getDisk();

        if ($disk !== null) {
            return \Storage::disk($disk)->url($path);
        }

        // Check if it's already a URL
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // Assume it's a path relative to public
        return asset($path);
    }

    public function getRingClasses(): string
    {
        return match ($this->ring) {
            'none' => '',
            'white' => 'ring-2 ring-white dark:ring-gray-900',
            'primary' => 'ring-2 ring-primary-500',
            'gray' => 'ring-2 ring-gray-300 dark:ring-gray-600',
            default => "ring-2 ring-{$this->ring}-500",
        };
    }

    public function getShapeClasses(): string
    {
        if ($this->isCircular) {
            return 'rounded-full';
        }

        if ($this->isSquare) {
            return 'rounded-lg';
        }

        return 'rounded';
    }

    protected function getViewName(): string
    {
        return 'infolists::components.image-entry';
    }
}
