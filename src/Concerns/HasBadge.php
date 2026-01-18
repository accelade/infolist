<?php

declare(strict_types=1);

namespace Accelade\Infolists\Concerns;

use Closure;

trait HasBadge
{
    protected bool|Closure $isBadge = false;

    protected string|Closure|null $badgeColor = null;

    public function badge(bool|Closure $condition = true): static
    {
        $this->isBadge = $condition;

        return $this;
    }

    public function badgeColor(string|Closure|null $color): static
    {
        $this->badgeColor = $color;

        return $this;
    }

    public function isBadge(): bool
    {
        return (bool) $this->evaluate($this->isBadge);
    }

    public function getBadgeColor(): ?string
    {
        if ($this->badgeColor !== null) {
            return $this->evaluate($this->badgeColor);
        }

        // Fall back to the entry's color if badge color not explicitly set
        if (method_exists($this, 'getColor')) {
            return $this->getColor();
        }

        return null;
    }

    public function getBadgeColorClasses(): string
    {
        if (! $this->isBadge()) {
            return '';
        }

        $color = $this->getBadgeColor() ?? 'gray';

        // Filament-style badge colors with subtle gradients and shadows
        return match ($color) {
            'primary' => 'bg-gradient-to-r from-primary-50 to-primary-100 text-primary-700 ring-primary-500/20 dark:from-primary-500/20 dark:to-primary-500/10 dark:text-primary-400 dark:ring-primary-400/30',
            'secondary', 'gray' => 'bg-gradient-to-r from-gray-50 to-gray-100 text-gray-700 ring-gray-500/20 dark:from-gray-500/20 dark:to-gray-500/10 dark:text-gray-300 dark:ring-gray-400/30',
            'success' => 'bg-gradient-to-r from-emerald-50 to-emerald-100 text-emerald-700 ring-emerald-500/20 dark:from-emerald-500/20 dark:to-emerald-500/10 dark:text-emerald-400 dark:ring-emerald-400/30',
            'danger' => 'bg-gradient-to-r from-rose-50 to-rose-100 text-rose-700 ring-rose-500/20 dark:from-rose-500/20 dark:to-rose-500/10 dark:text-rose-400 dark:ring-rose-400/30',
            'warning' => 'bg-gradient-to-r from-amber-50 to-amber-100 text-amber-700 ring-amber-500/20 dark:from-amber-500/20 dark:to-amber-500/10 dark:text-amber-400 dark:ring-amber-400/30',
            'info' => 'bg-gradient-to-r from-sky-50 to-sky-100 text-sky-700 ring-sky-500/20 dark:from-sky-500/20 dark:to-sky-500/10 dark:text-sky-400 dark:ring-sky-400/30',
            default => "bg-gradient-to-r from-{$color}-50 to-{$color}-100 text-{$color}-700 ring-{$color}-500/20 dark:from-{$color}-500/20 dark:to-{$color}-500/10 dark:text-{$color}-400 dark:ring-{$color}-400/30",
        };
    }

    public function getBadgeClasses(): string
    {
        if (! $this->isBadge()) {
            return '';
        }

        $color = $this->getBadgeColor() ?? 'gray';

        return match ($color) {
            'primary' => 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-200',
            'secondary', 'gray' => 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
            'success' => 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            'danger' => 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
            'warning' => 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200',
            'info' => 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
            default => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{$color}-100 text-{$color}-800 dark:bg-{$color}-900 dark:text-{$color}-200",
        };
    }
}
