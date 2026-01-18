<?php

declare(strict_types=1);

namespace Accelade\Infolists\Components;

class BadgeEntry extends Entry
{
    /** @var array<string, string> */
    protected array $colors = [];

    /** @var array<string, string> */
    protected array $icons = [];

    /**
     * @param  array<string, string>  $colors
     */
    public function colors(array $colors): static
    {
        $this->colors = $colors;

        return $this;
    }

    /**
     * @param  array<string, string>  $icons
     */
    public function icons(array $icons): static
    {
        $this->icons = $icons;

        return $this;
    }

    /**
     * @return array<string, string>
     */
    public function getColors(): array
    {
        return $this->colors;
    }

    /**
     * @return array<string, string>
     */
    public function getIcons(): array
    {
        return $this->icons;
    }

    public function bool(string $trueLabel = 'Yes', string $falseLabel = 'No'): static
    {
        $this->formatStateUsing(function ($state) use ($trueLabel, $falseLabel) {
            return $state ? $trueLabel : $falseLabel;
        });

        $this->colors = [
            $trueLabel => 'success',
            $falseLabel => 'danger',
        ];

        return $this;
    }

    public function getBadgeColorForState(): string
    {
        $state = $this->getFormattedState();

        if ($state !== null && isset($this->colors[$state])) {
            return $this->colors[$state];
        }

        return $this->getColor() ?? 'gray';
    }

    public function getBadgeIconForState(): ?string
    {
        $state = $this->getFormattedState();

        if ($state !== null && isset($this->icons[$state])) {
            return $this->icons[$state];
        }

        return $this->getIcon();
    }

    public function getFormattedState(): mixed
    {
        $state = $this->getState();

        if ($this->formatStateUsing !== null) {
            $state = $this->evaluate($this->formatStateUsing, ['state' => $state]);
        }

        return $state;
    }

    protected function getViewName(): string
    {
        return 'infolists::components.badge-entry';
    }
}
