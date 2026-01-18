<?php

declare(strict_types=1);

namespace Accelade\Infolists\Concerns;

use Closure;

trait CanBeCopied
{
    protected bool|Closure $isCopyable = false;

    protected string|Closure|null $copyMessage = null;

    protected int $copyMessageDuration = 2000;

    public function copyable(bool|Closure $condition = true): static
    {
        $this->isCopyable = $condition;

        return $this;
    }

    public function copyMessage(string|Closure|null $message): static
    {
        $this->copyMessage = $message;

        return $this;
    }

    public function copyMessageDuration(int $duration): static
    {
        $this->copyMessageDuration = $duration;

        return $this;
    }

    public function isCopyable(): bool
    {
        return (bool) $this->evaluate($this->isCopyable);
    }

    public function getCopyMessage(): string
    {
        return $this->evaluate($this->copyMessage) ?? 'Copied!';
    }

    public function getCopyMessageDuration(): int
    {
        return $this->copyMessageDuration;
    }
}
