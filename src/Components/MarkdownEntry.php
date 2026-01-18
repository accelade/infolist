<?php

declare(strict_types=1);

namespace Accelade\Infolists\Components;

use Closure;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\MarkdownConverter;

class MarkdownEntry extends Entry
{
    protected string|Closure|null $maxHeight = null;

    protected bool $isCollapsible = false;

    protected bool $isCollapsed = false;

    protected string|Closure|null $collapsedHeight = null;

    /**
     * Set the maximum height with scrolling.
     */
    public function maxHeight(string|Closure|null $height): static
    {
        $this->maxHeight = $height;

        return $this;
    }

    /**
     * Make the content collapsible.
     */
    public function collapsible(bool $condition = true): static
    {
        $this->isCollapsible = $condition;

        return $this;
    }

    /**
     * Set the initial collapsed state.
     */
    public function collapsed(bool $condition = true): static
    {
        $this->isCollapsed = $condition;
        $this->isCollapsible = true;

        return $this;
    }

    /**
     * Set the height when collapsed.
     */
    public function collapsedHeight(string|Closure|null $height): static
    {
        $this->collapsedHeight = $height;

        return $this;
    }

    public function getMaxHeight(): ?string
    {
        return $this->evaluate($this->maxHeight);
    }

    public function isCollapsible(): bool
    {
        return $this->isCollapsible;
    }

    public function isCollapsed(): bool
    {
        return $this->isCollapsed;
    }

    public function getCollapsedHeight(): ?string
    {
        return $this->evaluate($this->collapsedHeight) ?? '150px';
    }

    /**
     * Parse markdown content to HTML using CommonMark.
     */
    public function getFormattedContent(): ?string
    {
        $state = $this->getState();

        if ($state === null || $state === '') {
            return null;
        }

        return $this->parseMarkdown((string) $state);
    }

    /**
     * Parse markdown to HTML using CommonMark with GitHub-flavored extensions.
     */
    protected function parseMarkdown(string $markdown): string
    {
        $environment = new Environment([
            'html_input' => 'allow',
            'allow_unsafe_links' => false,
        ]);

        $environment->addExtension(new CommonMarkCoreExtension);
        $environment->addExtension(new GithubFlavoredMarkdownExtension);

        $converter = new MarkdownConverter($environment);

        return $converter->convert($markdown)->getContent();
    }

    protected function getViewName(): string
    {
        return 'infolists::components.markdown-entry';
    }
}
