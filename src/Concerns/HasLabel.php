<?php

declare(strict_types=1);

namespace Accelade\Infolists\Concerns;

use Closure;

trait HasLabel
{
    protected string|Closure|null $label = null;

    protected bool $isLabelHidden = false;

    public function label(string|Closure|null $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function hiddenLabel(bool $condition = true): static
    {
        $this->isLabelHidden = $condition;

        return $this;
    }

    public function getLabel(): ?string
    {
        $label = $this->evaluate($this->label);

        if ($label === null) {
            $label = $this->generateLabelFromName();
        }

        return $label;
    }

    public function isLabelHidden(): bool
    {
        return $this->isLabelHidden;
    }

    protected function generateLabelFromName(): string
    {
        return str($this->getName())
            ->beforeLast('.')
            ->afterLast('.')
            ->kebab()
            ->replace(['-', '_'], ' ')
            ->ucfirst()
            ->toString();
    }
}
