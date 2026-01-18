<?php

declare(strict_types=1);

namespace Accelade\Infolists\Components;

use Closure;
use Illuminate\Support\Str;

class HtmlEntry extends Entry
{
    protected bool $isMarkdown = false;

    protected bool $isProse = true;

    protected bool $isSanitized = true;

    protected array $allowedTags = [];

    protected string|Closure|null $maxHeight = null;

    public function markdown(bool $condition = true): static
    {
        $this->isMarkdown = $condition;

        return $this;
    }

    public function html(bool $condition = true): static
    {
        $this->isMarkdown = ! $condition;

        return $this;
    }

    public function prose(bool $condition = true): static
    {
        $this->isProse = $condition;

        return $this;
    }

    public function sanitized(bool $condition = true): static
    {
        $this->isSanitized = $condition;

        return $this;
    }

    public function unsanitized(): static
    {
        $this->isSanitized = false;

        return $this;
    }

    public function allowedTags(array $tags): static
    {
        $this->allowedTags = $tags;

        return $this;
    }

    public function maxHeight(string|Closure|null $height): static
    {
        $this->maxHeight = $height;

        return $this;
    }

    public function isMarkdownContent(): bool
    {
        return $this->isMarkdown;
    }

    public function isProse(): bool
    {
        return $this->isProse;
    }

    public function isSanitized(): bool
    {
        return $this->isSanitized;
    }

    public function getMaxHeight(): ?string
    {
        return $this->evaluate($this->maxHeight);
    }

    public function getFormattedContent(): ?string
    {
        $state = $this->getState();

        if ($state === null || $state === '') {
            return null;
        }

        // Convert markdown to HTML if needed
        if ($this->isMarkdown) {
            $state = Str::markdown((string) $state);
        }

        // Sanitize HTML if enabled
        if ($this->isSanitized && ! empty($this->allowedTags)) {
            $state = strip_tags((string) $state, $this->allowedTags);
        }

        return (string) $state;
    }

    protected function getViewName(): string
    {
        return 'infolists::components.html-entry';
    }
}
