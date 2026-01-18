<?php

declare(strict_types=1);

namespace Accelade\Infolists\Concerns;

use Closure;

trait HasIcon
{
    protected string|Closure|null $icon = null;

    protected string|Closure|null $iconColor = null;

    protected string $iconPosition = 'before';

    protected string|Closure|null $iconSize = null;

    public function icon(string|Closure|null $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function iconColor(string|Closure|null $color): static
    {
        $this->iconColor = $color;

        return $this;
    }

    public function iconPosition(string $position): static
    {
        $this->iconPosition = $position;

        return $this;
    }

    public function iconSize(string|Closure|null $size): static
    {
        $this->iconSize = $size;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->evaluate($this->icon);
    }

    public function getIconColor(): ?string
    {
        return $this->evaluate($this->iconColor);
    }

    public function getIconPosition(): string
    {
        return $this->iconPosition;
    }

    public function getIconSize(): ?string
    {
        return $this->evaluate($this->iconSize);
    }
}
