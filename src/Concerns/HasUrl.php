<?php

declare(strict_types=1);

namespace Accelade\Infolists\Concerns;

use Closure;

trait HasUrl
{
    protected string|Closure|null $url = null;

    protected bool $shouldOpenUrlInNewTab = false;

    public function url(string|Closure|null $url, bool $shouldOpenInNewTab = false): static
    {
        $this->url = $url;
        $this->shouldOpenUrlInNewTab = $shouldOpenInNewTab;

        return $this;
    }

    public function openUrlInNewTab(bool $condition = true): static
    {
        $this->shouldOpenUrlInNewTab = $condition;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->evaluate($this->url);
    }

    public function shouldOpenUrlInNewTab(): bool
    {
        return $this->shouldOpenUrlInNewTab;
    }

    public function hasUrl(): bool
    {
        return $this->getUrl() !== null;
    }
}
