<?php

declare(strict_types=1);

namespace Accelade\Infolists\Concerns;

use Closure;

trait HasTooltip
{
    protected string|Closure|null $tooltip = null;

    protected string $tooltipPosition = 'top';

    protected ?string $tooltipTheme = null;

    protected int $tooltipDelay = 0;

    public function tooltip(string|Closure|null $tooltip): static
    {
        $this->tooltip = $tooltip;

        return $this;
    }

    public function tooltipPosition(string $position): static
    {
        $this->tooltipPosition = $position;

        return $this;
    }

    public function tooltipTheme(?string $theme): static
    {
        $this->tooltipTheme = $theme;

        return $this;
    }

    public function tooltipDelay(int $delay): static
    {
        $this->tooltipDelay = $delay;

        return $this;
    }

    public function getTooltip(): ?string
    {
        return $this->evaluate($this->tooltip);
    }

    public function getTooltipPosition(): string
    {
        return $this->tooltipPosition;
    }

    public function getTooltipTheme(): ?string
    {
        return $this->tooltipTheme;
    }

    public function getTooltipDelay(): int
    {
        return $this->tooltipDelay;
    }

    public function hasTooltip(): bool
    {
        return $this->getTooltip() !== null;
    }

    /**
     * Get the tooltip configuration as JSON for the a-tooltip directive.
     */
    public function getTooltipConfig(): ?string
    {
        $tooltip = $this->getTooltip();

        if ($tooltip === null) {
            return null;
        }

        $config = ['content' => $tooltip];

        if ($this->tooltipPosition !== 'top') {
            $config['position'] = $this->tooltipPosition;
        }

        if ($this->tooltipTheme !== null) {
            $config['theme'] = $this->tooltipTheme;
        }

        if ($this->tooltipDelay > 0) {
            $config['delay'] = $this->tooltipDelay;
        }

        // If only content, return simple string for cleaner HTML
        if (count($config) === 1) {
            return $tooltip;
        }

        return json_encode($config, JSON_THROW_ON_ERROR);
    }
}
