<?php

declare(strict_types=1);

namespace Accelade\Infolists\Components;

class RepeatableEntry extends Entry
{
    /**
     * @var array<Entry>
     */
    protected array $schema = [];

    protected bool $isContained = true;

    protected bool $isGrid = false;

    protected bool $isSimple = false;

    protected int|array $columns = 1;

    /**
     * @param  array<Entry>  $schema
     */
    public function schema(array $schema): static
    {
        $this->schema = $schema;

        return $this;
    }

    /**
     * @return array<Entry>
     */
    public function getSchema(): array
    {
        return $this->schema;
    }

    public function contained(bool $condition = true): static
    {
        $this->isContained = $condition;

        return $this;
    }

    public function isContained(): bool
    {
        return $this->isContained && ! $this->isSimple;
    }

    /**
     * Use simple layout with minimal spacing.
     */
    public function simple(bool $condition = true): static
    {
        $this->isSimple = $condition;

        return $this;
    }

    public function isSimple(): bool
    {
        return $this->isSimple;
    }

    public function grid(int|array $columns = 2): static
    {
        $this->isGrid = true;
        $this->columns = $columns;

        return $this;
    }

    public function isGrid(): bool
    {
        return $this->isGrid;
    }

    public function columns(int|array $columns): static
    {
        $this->columns = $columns;

        return $this;
    }

    public function getColumns(): int|array
    {
        return $this->columns;
    }

    public function gridColumns(int $columns): static
    {
        $this->columns = $columns;

        return $this;
    }

    public function getGridColumns(): int
    {
        if (is_array($this->columns)) {
            return $this->columns['default'] ?? 1;
        }

        return $this->columns;
    }

    public function getItems(): array
    {
        $state = $this->getState();

        if ($state === null) {
            return [];
        }

        if (! is_iterable($state)) {
            return [];
        }

        return collect($state)->all();
    }

    /**
     * Get entries for a specific item.
     *
     * @return array<Entry>
     */
    public function getEntriesForItem(mixed $item, int $index): array
    {
        return array_map(function (Entry $entry) use ($item) {
            $clone = clone $entry;
            $clone->record($item);

            return $clone;
        }, $this->schema);
    }

    protected function getViewName(): string
    {
        return 'infolists::components.repeatable-entry';
    }
}
