<?php

declare(strict_types=1);

namespace Accelade\Infolists;

use Accelade\Infolists\Components\Entry;
use Accelade\Infolists\Concerns\HasConfig;
use Accelade\Schemas\Contracts\HasRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;

class Infolist implements Htmlable
{
    use Conditionable;
    use HasConfig;
    use Macroable;
    use Tappable;

    /**
     * @var array<Htmlable>
     */
    protected array $schema = [];

    protected mixed $record = null;

    protected int|array $columns = 2;

    protected string $layout = 'grid';

    protected ?string $id = null;

    final public function __construct()
    {
        $this->columns = $this->getConfigValue('infolist.default_columns', 2);
        $this->layout = $this->getConfigValue('infolist.default_layout', 'grid');
    }

    public static function make(): static
    {
        return new static;
    }

    /**
     * Set the schema (accepts Entry, Schema components, or any Htmlable).
     *
     * @param  array<Htmlable>  $schema
     */
    public function schema(array $schema): static
    {
        $this->schema = $schema;

        return $this;
    }

    public function record(mixed $record): static
    {
        $this->record = $record;

        return $this;
    }

    public function columns(int|array $columns): static
    {
        $this->columns = $columns;

        return $this;
    }

    public function layout(string $layout): static
    {
        $this->layout = $layout;

        return $this;
    }

    public function id(?string $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return array<Htmlable>
     */
    public function getSchema(): array
    {
        return $this->schema;
    }

    public function getRecord(): mixed
    {
        return $this->record;
    }

    public function getColumns(): int|array
    {
        return $this->columns;
    }

    public function getLayout(): string
    {
        return $this->layout;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Get all entries with record set.
     * Supports Entry, Schema components, and any Htmlable that implements HasRecord.
     *
     * @return array<Htmlable>
     */
    public function getEntries(): array
    {
        return array_map(function ($item) {
            // Pass record to any component that supports it
            if ($item instanceof HasRecord) {
                $item->record($this->record);
            }

            return $item;
        }, $this->schema);
    }

    /**
     * Get columns classes for Tailwind.
     */
    public function getColumnsClasses(): string
    {
        $columns = $this->getColumns();

        if (is_array($columns)) {
            $classes = [];

            foreach ($columns as $breakpoint => $cols) {
                if ($breakpoint === 'default') {
                    $classes[] = "grid-cols-{$cols}";
                } else {
                    $classes[] = "{$breakpoint}:grid-cols-{$cols}";
                }
            }

            return implode(' ', $classes);
        }

        return "grid-cols-{$columns}";
    }

    public function render(): View
    {
        return view('infolists::components.infolist', [
            'infolist' => $this,
        ]);
    }

    public function toHtml(): string
    {
        return $this->render()->render();
    }
}
