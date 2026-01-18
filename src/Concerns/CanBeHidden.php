<?php

declare(strict_types=1);

namespace Accelade\Infolists\Concerns;

use Closure;

trait CanBeHidden
{
    protected bool|Closure $isHidden = false;

    protected bool|Closure $isVisible = true;

    public function hidden(bool|Closure $condition = true): static
    {
        $this->isHidden = $condition;

        return $this;
    }

    public function visible(bool|Closure $condition = true): static
    {
        $this->isVisible = $condition;

        return $this;
    }

    public function isHidden(): bool
    {
        if ((bool) $this->evaluate($this->isHidden)) {
            return true;
        }

        return ! (bool) $this->evaluate($this->isVisible);
    }

    public function isVisible(): bool
    {
        return ! $this->isHidden();
    }
}
