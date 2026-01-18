<?php

declare(strict_types=1);

namespace Accelade\Infolists\Concerns;

use Closure;

trait HasState
{
    protected mixed $state = null;

    protected mixed $defaultState = null;

    protected ?Closure $formatStateUsing = null;

    public function state(mixed $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function default(mixed $state): static
    {
        $this->defaultState = $state;

        return $this;
    }

    public function formatStateUsing(?Closure $callback): static
    {
        $this->formatStateUsing = $callback;

        return $this;
    }

    /**
     * Alias for formatStateUsing() for Filament compatibility.
     */
    public function formatState(?Closure $callback): static
    {
        return $this->formatStateUsing($callback);
    }

    public function getState(): mixed
    {
        $state = $this->evaluate($this->state);

        if ($state === null && $this->defaultState !== null) {
            $state = $this->evaluate($this->defaultState);
        }

        return $state;
    }

    public function getFormattedState(): mixed
    {
        $state = $this->getState();

        if ($this->formatStateUsing !== null) {
            return $this->evaluate($this->formatStateUsing, [
                'state' => $state,
            ]);
        }

        return $state;
    }
}
