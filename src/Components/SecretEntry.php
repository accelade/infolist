<?php

declare(strict_types=1);

namespace Accelade\Infolists\Components;

use Closure;

class SecretEntry extends Entry
{
    protected string|Closure $mask = '********';

    protected int|Closure|null $visibleCharacters = null;

    protected string $visiblePosition = 'end';

    protected bool $revealOnHover = false;

    protected bool $revealOnClick = true;

    protected string|Closure|null $revealIcon = 'heroicon-o-eye';

    protected string|Closure|null $hideIcon = 'heroicon-o-eye-slash';

    protected int|Closure|null $autoHideAfter = null;

    public function mask(string|Closure $mask): static
    {
        $this->mask = $mask;

        return $this;
    }

    public function visibleCharacters(int|Closure|null $count, string $position = 'end'): static
    {
        $this->visibleCharacters = $count;
        $this->visiblePosition = $position;

        return $this;
    }

    public function showFirst(int $count): static
    {
        return $this->visibleCharacters($count, 'start');
    }

    public function showLast(int $count): static
    {
        return $this->visibleCharacters($count, 'end');
    }

    public function revealOnHover(bool $condition = true): static
    {
        $this->revealOnHover = $condition;

        return $this;
    }

    public function revealOnClick(bool $condition = true): static
    {
        $this->revealOnClick = $condition;

        return $this;
    }

    public function revealIcon(string|Closure|null $icon): static
    {
        $this->revealIcon = $icon;

        return $this;
    }

    public function hideIcon(string|Closure|null $icon): static
    {
        $this->hideIcon = $icon;

        return $this;
    }

    public function autoHideAfter(int|Closure|null $seconds): static
    {
        $this->autoHideAfter = $seconds;

        return $this;
    }

    public function getMask(): string
    {
        return $this->evaluate($this->mask);
    }

    public function getVisibleCharacters(): ?int
    {
        return $this->evaluate($this->visibleCharacters);
    }

    public function getVisiblePosition(): string
    {
        return $this->visiblePosition;
    }

    public function isRevealOnHover(): bool
    {
        return $this->revealOnHover;
    }

    public function isRevealOnClick(): bool
    {
        return $this->revealOnClick;
    }

    public function getRevealIcon(): ?string
    {
        return $this->evaluate($this->revealIcon);
    }

    public function getHideIcon(): ?string
    {
        return $this->evaluate($this->hideIcon);
    }

    public function getAutoHideAfter(): ?int
    {
        return $this->evaluate($this->autoHideAfter);
    }

    public function getMaskedValue(): string
    {
        $state = $this->getState();

        if ($state === null || $state === '') {
            return $this->getMask();
        }

        $value = (string) $state;
        $visibleChars = $this->getVisibleCharacters();

        if ($visibleChars === null || $visibleChars <= 0) {
            return $this->getMask();
        }

        $mask = $this->getMask();
        $position = $this->getVisiblePosition();

        if ($position === 'start') {
            $visible = substr($value, 0, $visibleChars);

            return $visible.$mask;
        }

        if ($position === 'end') {
            $visible = substr($value, -$visibleChars);

            return $mask.$visible;
        }

        return $mask;
    }

    public function getActualValue(): ?string
    {
        $state = $this->getState();

        return $state !== null ? (string) $state : null;
    }

    protected function getViewName(): string
    {
        return 'infolists::components.secret-entry';
    }
}
