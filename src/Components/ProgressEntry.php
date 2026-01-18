<?php

declare(strict_types=1);

namespace Accelade\Infolists\Components;

use Closure;

class ProgressEntry extends Entry
{
    protected int|float|Closure $min = 0;

    protected int|float|Closure $max = 100;

    protected string|Closure|null $color = null;

    protected bool $showLabel = true;

    protected string|Closure|null $labelFormat = null;

    protected bool $striped = false;

    protected bool $animated = false;

    protected string $barHeight = 'md';

    public function min(int|float|Closure $min): static
    {
        $this->min = $min;

        return $this;
    }

    public function max(int|float|Closure $max): static
    {
        $this->max = $max;

        return $this;
    }

    public function color(string|Closure|null $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function showLabel(bool $condition = true): static
    {
        $this->showLabel = $condition;

        return $this;
    }

    public function hideLabel(): static
    {
        $this->showLabel = false;

        return $this;
    }

    public function labelFormat(string|Closure|null $format): static
    {
        $this->labelFormat = $format;

        return $this;
    }

    public function striped(bool $condition = true): static
    {
        $this->striped = $condition;

        return $this;
    }

    public function animated(bool $condition = true): static
    {
        $this->animated = $condition;
        $this->striped = true;

        return $this;
    }

    public function height(string $height): static
    {
        $this->barHeight = $height;

        return $this;
    }

    public function getMin(): float
    {
        return (float) $this->evaluate($this->min);
    }

    public function getMax(): float
    {
        return (float) $this->evaluate($this->max);
    }

    public function getProgressColor(): ?string
    {
        $color = $this->evaluate($this->color);

        if ($color !== null) {
            return $color;
        }

        // Auto-color based on percentage
        $percentage = $this->getPercentage();

        if ($percentage >= 80) {
            return 'success';
        }

        if ($percentage >= 50) {
            return 'warning';
        }

        if ($percentage >= 25) {
            return 'info';
        }

        return 'danger';
    }

    public function isShowLabel(): bool
    {
        return $this->showLabel;
    }

    public function isStriped(): bool
    {
        return $this->striped;
    }

    public function isAnimated(): bool
    {
        return $this->animated;
    }

    public function getBarHeight(): string
    {
        return $this->barHeight;
    }

    public function getProgressValue(): float
    {
        $state = $this->getState();

        if ($state === null) {
            return 0;
        }

        return (float) $state;
    }

    public function getPercentage(): float
    {
        $value = $this->getProgressValue();
        $min = $this->getMin();
        $max = $this->getMax();

        if ($max - $min === 0.0) {
            return 0;
        }

        $percentage = (($value - $min) / ($max - $min)) * 100;

        return max(0, min(100, $percentage));
    }

    public function getFormattedLabel(): string
    {
        $format = $this->evaluate($this->labelFormat);

        if ($format !== null) {
            return str_replace(
                ['{value}', '{min}', '{max}', '{percentage}'],
                [
                    $this->getProgressValue(),
                    $this->getMin(),
                    $this->getMax(),
                    round($this->getPercentage(), 1),
                ],
                $format
            );
        }

        return round($this->getPercentage(), 1).'%';
    }

    public function getColorClasses(): string
    {
        $color = $this->getProgressColor();

        return match ($color) {
            'primary' => 'bg-primary-500',
            'secondary', 'gray' => 'bg-gray-500',
            'success' => 'bg-emerald-500',
            'danger' => 'bg-rose-500',
            'warning' => 'bg-amber-500',
            'info' => 'bg-sky-500',
            default => "bg-{$color}-500",
        };
    }

    public function getHeightClasses(): string
    {
        return match ($this->barHeight) {
            'xs' => 'h-1',
            'sm' => 'h-2',
            'md' => 'h-3',
            'lg' => 'h-4',
            'xl' => 'h-6',
            default => 'h-3',
        };
    }

    protected function getViewName(): string
    {
        return 'infolists::components.progress-entry';
    }
}
