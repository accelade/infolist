<?php

declare(strict_types=1);

namespace Accelade\Infolists\Components;

use Accelade\Infolists\Concerns\HasConfig;
use Closure;

class IconEntry extends Entry
{
    use HasConfig;

    protected string $size = 'lg';

    protected bool|Closure $isBoolean = false;

    protected string|Closure|null $trueIcon = null;

    protected string|Closure|null $falseIcon = null;

    protected string|Closure|null $trueColor = null;

    protected string|Closure|null $falseColor = null;

    public function boolean(bool|Closure $condition = true): static
    {
        $this->isBoolean = $condition;

        return $this;
    }

    public function trueIcon(string|Closure|null $icon): static
    {
        $this->trueIcon = $icon;

        return $this;
    }

    public function falseIcon(string|Closure|null $icon): static
    {
        $this->falseIcon = $icon;

        return $this;
    }

    public function trueColor(string|Closure|null $color): static
    {
        $this->trueColor = $color;

        return $this;
    }

    public function falseColor(string|Closure|null $color): static
    {
        $this->falseColor = $color;

        return $this;
    }

    public function isBoolean(): bool
    {
        return (bool) $this->evaluate($this->isBoolean);
    }

    public function getIcon(): ?string
    {
        if ($this->isBoolean()) {
            $state = (bool) $this->getState();

            if ($state) {
                return $this->evaluate($this->trueIcon) ?? $this->getConfigValue('infolist.boolean_icons.true', 'heroicon-o-check-circle');
            }

            return $this->evaluate($this->falseIcon) ?? $this->getConfigValue('infolist.boolean_icons.false', 'heroicon-o-x-circle');
        }

        $icon = $this->evaluate($this->icon);

        if ($icon !== null) {
            return $icon;
        }

        // Use state as icon name
        return $this->getState();
    }

    public function getColor(): ?string
    {
        if ($this->isBoolean()) {
            $state = (bool) $this->getState();

            if ($state) {
                return $this->evaluate($this->trueColor) ?? $this->getConfigValue('infolist.boolean_colors.true', 'success');
            }

            return $this->evaluate($this->falseColor) ?? $this->getConfigValue('infolist.boolean_colors.false', 'danger');
        }

        return $this->evaluate($this->color);
    }

    public function getIconSize(): string
    {
        return $this->size;
    }

    public function getTrueIcon(): string
    {
        return $this->evaluate($this->trueIcon) ?? $this->getConfigValue('infolist.boolean_icons.true', 'heroicon-o-check-circle');
    }

    public function getFalseIcon(): string
    {
        return $this->evaluate($this->falseIcon) ?? $this->getConfigValue('infolist.boolean_icons.false', 'heroicon-o-x-circle');
    }

    public function getTrueColor(): string
    {
        return $this->evaluate($this->trueColor) ?? $this->getConfigValue('infolist.boolean_colors.true', 'success');
    }

    public function getFalseColor(): string
    {
        return $this->evaluate($this->falseColor) ?? $this->getConfigValue('infolist.boolean_colors.false', 'danger');
    }

    public function getIconSizeClasses(): string
    {
        return match ($this->size) {
            'xs' => 'w-3 h-3',
            'sm' => 'w-4 h-4',
            'md' => 'w-5 h-5',
            'lg' => 'w-6 h-6',
            'xl' => 'w-8 h-8',
            '2xl' => 'w-10 h-10',
            default => 'w-6 h-6',
        };
    }

    protected function getViewName(): string
    {
        return 'infolists::components.icon-entry';
    }
}
