<?php

declare(strict_types=1);

namespace Accelade\Infolists\Components;

use Closure;

class KeyValueEntry extends Entry
{
    protected string|Closure|null $keyLabel = null;

    protected string|Closure|null $valueLabel = null;

    public function keyLabel(string|Closure|null $label): static
    {
        $this->keyLabel = $label;

        return $this;
    }

    public function valueLabel(string|Closure|null $label): static
    {
        $this->valueLabel = $label;

        return $this;
    }

    public function getKeyLabel(): string
    {
        return $this->evaluate($this->keyLabel) ?? 'Key';
    }

    public function getValueLabel(): string
    {
        return $this->evaluate($this->valueLabel) ?? 'Value';
    }

    public function getKeyValuePairs(): array
    {
        $state = $this->getState();

        if ($state === null) {
            return [];
        }

        if (! is_array($state)) {
            return [];
        }

        return $state;
    }

    protected function getViewName(): string
    {
        return 'infolists::components.key-value-entry';
    }
}
