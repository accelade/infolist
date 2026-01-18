<?php

declare(strict_types=1);

namespace Accelade\Infolists\Concerns;

use Closure;

trait HasColor
{
    protected string|Closure|null $color = null;

    public function color(string|Closure|null $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->evaluate($this->color);
    }

    /**
     * Get the Tailwind color classes based on the color name.
     */
    public function getColorClasses(): string
    {
        $color = $this->getColor();

        if ($color === null) {
            return '';
        }

        return match ($color) {
            'primary' => 'text-primary-600 dark:text-primary-400',
            'secondary' => 'text-gray-600 dark:text-gray-400',
            'success' => 'text-green-600 dark:text-green-400',
            'danger' => 'text-red-600 dark:text-red-400',
            'warning' => 'text-amber-600 dark:text-amber-400',
            'info' => 'text-blue-600 dark:text-blue-400',
            'gray' => 'text-gray-500 dark:text-gray-400',
            default => "text-{$color}-600 dark:text-{$color}-400",
        };
    }
}
