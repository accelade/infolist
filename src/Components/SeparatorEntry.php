<?php

declare(strict_types=1);

namespace Accelade\Infolists\Components;

use Closure;

class SeparatorEntry extends Entry
{
    protected string|Closure $orientation = 'horizontal';

    protected string|Closure $separatorColor = 'gray';

    protected string|Closure $separatorStyle = 'solid';

    protected string|Closure $thickness = 'thin';

    protected string|Closure|null $text = null;

    protected string $textPosition = 'center';

    public function horizontal(): static
    {
        $this->orientation = 'horizontal';

        return $this;
    }

    public function vertical(): static
    {
        $this->orientation = 'vertical';

        return $this;
    }

    public function orientation(string|Closure $orientation): static
    {
        $this->orientation = $orientation;

        return $this;
    }

    public function separatorColor(string|Closure $color): static
    {
        $this->separatorColor = $color;

        return $this;
    }

    public function style(string|Closure $style): static
    {
        $this->separatorStyle = $style;

        return $this;
    }

    public function solid(): static
    {
        $this->separatorStyle = 'solid';

        return $this;
    }

    public function dashed(): static
    {
        $this->separatorStyle = 'dashed';

        return $this;
    }

    public function dotted(): static
    {
        $this->separatorStyle = 'dotted';

        return $this;
    }

    public function thickness(string|Closure $thickness): static
    {
        $this->thickness = $thickness;

        return $this;
    }

    public function thin(): static
    {
        $this->thickness = 'thin';

        return $this;
    }

    public function medium(): static
    {
        $this->thickness = 'medium';

        return $this;
    }

    public function thick(): static
    {
        $this->thickness = 'thick';

        return $this;
    }

    public function text(string|Closure|null $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function textLeft(): static
    {
        $this->textPosition = 'left';

        return $this;
    }

    public function textCenter(): static
    {
        $this->textPosition = 'center';

        return $this;
    }

    public function textRight(): static
    {
        $this->textPosition = 'right';

        return $this;
    }

    public function getOrientation(): string
    {
        return $this->evaluate($this->orientation);
    }

    public function getSeparatorColor(): string
    {
        return $this->evaluate($this->separatorColor);
    }

    public function getSeparatorStyle(): string
    {
        return $this->evaluate($this->separatorStyle);
    }

    public function getThickness(): string
    {
        return $this->evaluate($this->thickness);
    }

    public function getText(): ?string
    {
        return $this->evaluate($this->text);
    }

    public function getTextPosition(): string
    {
        return $this->textPosition;
    }

    public function isHorizontal(): bool
    {
        return $this->getOrientation() === 'horizontal';
    }

    public function isVertical(): bool
    {
        return $this->getOrientation() === 'vertical';
    }

    public function getSeparatorColorClasses(): string
    {
        $color = $this->getSeparatorColor();

        return match ($color) {
            'primary' => 'border-primary-300 dark:border-primary-600',
            'secondary', 'gray' => 'border-gray-200 dark:border-gray-700',
            'success' => 'border-emerald-300 dark:border-emerald-600',
            'danger' => 'border-rose-300 dark:border-rose-600',
            'warning' => 'border-amber-300 dark:border-amber-600',
            'info' => 'border-sky-300 dark:border-sky-600',
            default => "border-{$color}-300 dark:border-{$color}-600",
        };
    }

    public function getThicknessClasses(): string
    {
        $thickness = $this->getThickness();
        $isVertical = $this->isVertical();

        return match ($thickness) {
            'thin' => $isVertical ? 'border-l' : 'border-t',
            'medium' => $isVertical ? 'border-l-2' : 'border-t-2',
            'thick' => $isVertical ? 'border-l-4' : 'border-t-4',
            default => $isVertical ? 'border-l' : 'border-t',
        };
    }

    public function getStyleClasses(): string
    {
        return match ($this->getSeparatorStyle()) {
            'solid' => 'border-solid',
            'dashed' => 'border-dashed',
            'dotted' => 'border-dotted',
            default => 'border-solid',
        };
    }

    protected function getViewName(): string
    {
        return 'infolists::components.separator-entry';
    }
}
