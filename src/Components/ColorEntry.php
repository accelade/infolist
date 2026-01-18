<?php

declare(strict_types=1);

namespace Accelade\Infolists\Components;

class ColorEntry extends Entry
{
    protected bool|\Closure $isCopyable = true;

    public function getColorValue(): ?string
    {
        $state = $this->getState();

        if ($state === null) {
            return null;
        }

        return (string) $state;
    }

    protected function getViewName(): string
    {
        return 'infolists::components.color-entry';
    }
}
