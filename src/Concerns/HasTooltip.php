<?php

declare(strict_types=1);

namespace Accelade\Infolists\Concerns;

use Closure;

trait HasTooltip
{
    protected string|Closure|null $tooltip = null;

    public function tooltip(string|Closure|null $tooltip): static
    {
        $this->tooltip = $tooltip;

        return $this;
    }

    public function getTooltip(): ?string
    {
        return $this->evaluate($this->tooltip);
    }

    public function hasTooltip(): bool
    {
        return $this->getTooltip() !== null;
    }
}
