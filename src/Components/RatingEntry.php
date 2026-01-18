<?php

declare(strict_types=1);

namespace Accelade\Infolists\Components;

use Closure;

class RatingEntry extends Entry
{
    protected int|Closure $max = 5;

    protected string|Closure $ratingFilledIcon = 'heroicon-s-star';

    protected string|Closure $ratingEmptyIcon = 'heroicon-o-star';

    protected string|Closure $filledColor = 'warning';

    protected string|Closure $emptyColor = 'gray';

    protected string|Closure $ratingSize = 'md';

    protected bool $allowHalf = false;

    public function max(int|Closure $max): static
    {
        $this->max = $max;

        return $this;
    }

    public function filledIcon(string|Closure $icon): static
    {
        $this->ratingFilledIcon = $icon;

        return $this;
    }

    public function emptyIcon(string|Closure $icon): static
    {
        $this->ratingEmptyIcon = $icon;

        return $this;
    }

    public function filledColor(string|Closure $color): static
    {
        $this->filledColor = $color;

        return $this;
    }

    public function emptyColor(string|Closure $color): static
    {
        $this->emptyColor = $color;

        return $this;
    }

    public function allowHalf(bool $condition = true): static
    {
        $this->allowHalf = $condition;

        return $this;
    }

    public function stars(int $max = 5): static
    {
        return $this->max($max)->filledIcon('heroicon-s-star')->emptyIcon('heroicon-o-star');
    }

    public function hearts(int $max = 5): static
    {
        return $this->max($max)->filledIcon('heroicon-s-heart')->emptyIcon('heroicon-o-heart')->filledColor('danger');
    }

    public function getMax(): int
    {
        return (int) $this->evaluate($this->max);
    }

    public function getFilledIcon(): string
    {
        return $this->evaluate($this->ratingFilledIcon);
    }

    public function getEmptyIcon(): string
    {
        return $this->evaluate($this->ratingEmptyIcon);
    }

    public function getFilledColor(): string
    {
        return $this->evaluate($this->filledColor);
    }

    public function getEmptyColor(): string
    {
        return $this->evaluate($this->emptyColor);
    }

    public function getAllowHalf(): bool
    {
        return $this->allowHalf;
    }

    public function getRatingValue(): float
    {
        $state = $this->getState();

        if ($state === null) {
            return 0;
        }

        return (float) $state;
    }

    public function getFilledColorClasses(): string
    {
        $color = $this->getFilledColor();

        return match ($color) {
            'primary' => 'text-primary-500 dark:text-primary-400',
            'secondary', 'gray' => 'text-gray-500 dark:text-gray-400',
            'success' => 'text-emerald-500 dark:text-emerald-400',
            'danger' => 'text-rose-500 dark:text-rose-400',
            'warning' => 'text-amber-500 dark:text-amber-400',
            'info' => 'text-sky-500 dark:text-sky-400',
            default => "text-{$color}-500 dark:text-{$color}-400",
        };
    }

    public function getEmptyColorClasses(): string
    {
        $color = $this->getEmptyColor();

        return match ($color) {
            'primary' => 'text-primary-200 dark:text-primary-700',
            'secondary', 'gray' => 'text-gray-200 dark:text-gray-700',
            'success' => 'text-emerald-200 dark:text-emerald-700',
            'danger' => 'text-rose-200 dark:text-rose-700',
            'warning' => 'text-amber-200 dark:text-amber-700',
            'info' => 'text-sky-200 dark:text-sky-700',
            default => "text-{$color}-200 dark:text-{$color}-700",
        };
    }

    public function ratingSize(string|Closure $size): static
    {
        $this->ratingSize = $size;

        return $this;
    }

    public function getRatingSize(): string
    {
        return $this->evaluate($this->ratingSize);
    }

    public function getRatingSizeClasses(): string
    {
        $size = $this->getRatingSize();

        return match ($size) {
            'xs' => 'w-3 h-3',
            'sm' => 'w-4 h-4',
            'md' => 'w-5 h-5',
            'lg' => 'w-6 h-6',
            'xl' => 'w-8 h-8',
            default => 'w-5 h-5',
        };
    }

    protected function getViewName(): string
    {
        return 'infolists::components.rating-entry';
    }
}
