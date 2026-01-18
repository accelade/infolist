<?php

declare(strict_types=1);

namespace Accelade\Infolists\Components;

class CodeEntry extends Entry
{
    protected string $language = 'plaintext';

    protected ?int $maxHeight = null;

    protected bool $lineNumbers = true;

    public static function make(string $name): static
    {
        $entry = new static($name);

        // CodeEntry is copyable by default
        $entry->isCopyable = true;

        return $entry;
    }

    public function language(string $language): static
    {
        $this->language = $language;

        return $this;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function maxHeight(?int $height): static
    {
        $this->maxHeight = $height;

        return $this;
    }

    public function getMaxHeight(): ?int
    {
        return $this->maxHeight;
    }

    public function lineNumbers(bool $condition = true): static
    {
        $this->lineNumbers = $condition;

        return $this;
    }

    public function hasLineNumbers(): bool
    {
        return $this->lineNumbers;
    }

    public function json(): static
    {
        return $this->language('json');
    }

    public function php(): static
    {
        return $this->language('php');
    }

    public function javascript(): static
    {
        return $this->language('javascript');
    }

    public function typescript(): static
    {
        return $this->language('typescript');
    }

    public function python(): static
    {
        return $this->language('python');
    }

    public function sql(): static
    {
        return $this->language('sql');
    }

    public function yaml(): static
    {
        return $this->language('yaml');
    }

    public function html(): static
    {
        return $this->language('html');
    }

    public function css(): static
    {
        return $this->language('css');
    }

    public function bash(): static
    {
        return $this->language('bash');
    }

    public function blade(): static
    {
        return $this->language('blade');
    }

    protected function getViewName(): string
    {
        return 'infolists::components.code-entry';
    }
}
