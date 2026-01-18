<?php

declare(strict_types=1);

namespace Accelade\Infolists\Components;

use Accelade\Infolists\Concerns\CanBeCopied;
use Accelade\Infolists\Concerns\CanBeHidden;
use Accelade\Infolists\Concerns\HasBadge;
use Accelade\Infolists\Concerns\HasColor;
use Accelade\Infolists\Concerns\HasExtraAttributes;
use Accelade\Infolists\Concerns\HasIcon;
use Accelade\Infolists\Concerns\HasLabel;
use Accelade\Infolists\Concerns\HasState;
use Accelade\Infolists\Concerns\HasTooltip;
use Accelade\Infolists\Concerns\HasUrl;
use Accelade\Schemas\Contracts\HasRecord;
use Accelade\Schemas\Contracts\Renderable;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;

abstract class Entry implements HasRecord, Renderable
{
    use CanBeCopied;
    use CanBeHidden;
    use Conditionable;
    use HasBadge;
    use HasColor;
    use HasExtraAttributes;
    use HasIcon;
    use HasLabel;
    use HasState;
    use HasTooltip;
    use HasUrl;
    use Macroable;
    use Tappable;

    protected string $name;

    protected mixed $record = null;

    protected int|string|null $columnSpan = null;

    protected int|string|null $columnStart = null;

    protected string|Closure|null $placeholder = null;

    protected string|Closure|null $helperText = null;

    protected string|Closure|null $hint = null;

    protected string|Closure|null $hintIcon = null;

    protected string|Closure|null $hintColor = null;

    protected string $size = 'md';

    protected string $weight = 'normal';

    protected bool $isInline = false;

    final public function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function make(string $name): static
    {
        return new static($name);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function record(mixed $record): static
    {
        $this->record = $record;

        return $this;
    }

    public function getRecord(): mixed
    {
        return $this->record;
    }

    public function columnSpan(int|string|null $span): static
    {
        $this->columnSpan = $span;

        return $this;
    }

    public function columnSpanFull(): static
    {
        $this->columnSpan = 'full';

        return $this;
    }

    public function getColumnSpan(): int|string|null
    {
        return $this->columnSpan;
    }

    public function isColumnSpanFull(): bool
    {
        return $this->columnSpan === 'full';
    }

    public function columnStart(int|string|null $start): static
    {
        $this->columnStart = $start;

        return $this;
    }

    public function getColumnStart(): int|string|null
    {
        return $this->columnStart;
    }

    public function placeholder(string|Closure|null $placeholder): static
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function getPlaceholder(): string
    {
        return $this->evaluate($this->placeholder) ?? config('infolist.placeholder', '—');
    }

    public function helperText(string|Closure|null $text): static
    {
        $this->helperText = $text;

        return $this;
    }

    public function getHelperText(): ?string
    {
        return $this->evaluate($this->helperText);
    }

    public function hint(string|Closure|null $hint): static
    {
        $this->hint = $hint;

        return $this;
    }

    public function getHint(): ?string
    {
        return $this->evaluate($this->hint);
    }

    public function hintIcon(string|Closure|null $icon): static
    {
        $this->hintIcon = $icon;

        return $this;
    }

    public function getHintIcon(): ?string
    {
        return $this->evaluate($this->hintIcon);
    }

    public function hintColor(string|Closure|null $color): static
    {
        $this->hintColor = $color;

        return $this;
    }

    public function getHintColor(): ?string
    {
        return $this->evaluate($this->hintColor);
    }

    public function size(string $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function weight(string $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getWeight(): string
    {
        return $this->weight;
    }

    public function inline(bool $condition = true): static
    {
        $this->isInline = $condition;

        return $this;
    }

    public function isInline(): bool
    {
        return $this->isInline;
    }

    /**
     * Evaluate a value that may be a closure.
     */
    protected function evaluate(mixed $value, array $parameters = []): mixed
    {
        if ($value instanceof Closure) {
            return app()->call($value, array_merge([
                'record' => $this->getRecord(),
                'state' => $this->getState(),
                'entry' => $this,
            ], $parameters));
        }

        return $value;
    }

    /**
     * Get the state from the record if not explicitly set.
     */
    public function getStateFromRecord(): mixed
    {
        $record = $this->getRecord();
        $name = $this->getName();

        if ($record === null) {
            return null;
        }

        // Handle dot notation for nested properties
        if (str_contains($name, '.')) {
            return data_get($record, $name);
        }

        // Handle array access
        if (is_array($record)) {
            return $record[$name] ?? null;
        }

        // Handle object access
        if (is_object($record)) {
            return $record->{$name} ?? null;
        }

        return null;
    }

    /**
     * Get the computed state (explicit or from record).
     */
    public function getState(): mixed
    {
        if ($this->state !== null) {
            return $this->evaluate($this->state);
        }

        $state = $this->getStateFromRecord();

        if ($state === null && $this->defaultState !== null) {
            $state = $this->evaluate($this->defaultState);
        }

        return $state;
    }

    /**
     * Get the view name for this entry.
     */
    abstract protected function getViewName(): string;

    /**
     * Get the view data for rendering.
     */
    protected function getViewData(): array
    {
        return [
            'entry' => $this,
        ];
    }

    /**
     * Render the entry to a view.
     */
    public function render(): View
    {
        return view($this->getViewName(), $this->getViewData());
    }

    /**
     * Convert to HTML string.
     */
    public function toHtml(): string
    {
        return $this->render()->render();
    }

    /**
     * Get size classes for Tailwind.
     */
    public function getSizeClasses(): string
    {
        return match ($this->size) {
            'xs' => 'text-xs',
            'sm' => 'text-sm',
            'md' => 'text-base',
            'lg' => 'text-lg',
            'xl' => 'text-xl',
            '2xl' => 'text-2xl',
            default => 'text-base',
        };
    }

    /**
     * Get weight classes for Tailwind.
     */
    public function getWeightClasses(): string
    {
        return match ($this->weight) {
            'thin' => 'font-thin',
            'extralight' => 'font-extralight',
            'light' => 'font-light',
            'normal' => 'font-normal',
            'medium' => 'font-medium',
            'semibold' => 'font-semibold',
            'bold' => 'font-bold',
            'extrabold' => 'font-extrabold',
            'black' => 'font-black',
            default => 'font-normal',
        };
    }
}
