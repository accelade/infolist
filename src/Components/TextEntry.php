<?php

declare(strict_types=1);

namespace Accelade\Infolists\Components;

use Accelade\Infolists\Concerns\HasConfig;
use Closure;

class TextEntry extends Entry
{
    use HasConfig;

    protected bool $isMoney = false;

    protected bool $isNumeric = false;

    protected bool $isHtml = false;

    protected bool $isMarkdown = false;

    protected bool $isProse = false;

    protected int|Closure|null $limit = null;

    protected int|Closure|null $words = null;

    protected string|Closure|null $prefix = null;

    protected string|Closure|null $suffix = null;

    protected ?string $dateFormat = null;

    protected ?string $timeFormat = null;

    protected ?string $timezone = null;

    protected ?string $currency = null;

    protected ?string $currencyLocale = null;

    protected bool|Closure $isListable = false;

    protected bool $isListWithLineBreaks = false;

    protected string $listSeparator = ', ';

    protected bool $isBulleted = false;

    public function money(?string $currency = null, ?string $locale = null): static
    {
        $this->isMoney = true;
        $this->currency = $currency ?? $this->getConfigValue('infolist.currency.code', 'USD');
        $this->currencyLocale = $locale ?? $this->getConfigValue('infolist.currency.locale', 'en_US');

        return $this;
    }

    public function numeric(int $decimalPlaces = 0, string $decimalSeparator = '.', string $thousandsSeparator = ','): static
    {
        $this->isNumeric = true;

        $this->formatStateUsing(function ($state) use ($decimalPlaces, $decimalSeparator, $thousandsSeparator) {
            if (! is_numeric($state)) {
                return $state;
            }

            return number_format((float) $state, $decimalPlaces, $decimalSeparator, $thousandsSeparator);
        });

        return $this;
    }

    public function html(bool $condition = true): static
    {
        $this->isHtml = $condition;

        return $this;
    }

    public function markdown(bool $condition = true): static
    {
        $this->isMarkdown = $condition;

        return $this;
    }

    public function prose(bool $condition = true): static
    {
        $this->isProse = $condition;

        return $this;
    }

    public function limit(int|Closure|null $limit, string $end = '...'): static
    {
        $this->limit = $limit;

        $this->formatStateUsing(function ($state) use ($limit, $end) {
            if ($state === null) {
                return null;
            }

            $limitValue = $this->evaluate($limit);

            if ($limitValue === null) {
                return $state;
            }

            return str($state)->limit($limitValue, $end)->toString();
        });

        return $this;
    }

    public function words(int|Closure|null $words, string $end = '...'): static
    {
        $this->words = $words;

        $this->formatStateUsing(function ($state) use ($words, $end) {
            if ($state === null) {
                return null;
            }

            $wordsValue = $this->evaluate($words);

            if ($wordsValue === null) {
                return $state;
            }

            return str($state)->words($wordsValue, $end)->toString();
        });

        return $this;
    }

    public function prefix(string|Closure|null $prefix): static
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function suffix(string|Closure|null $suffix): static
    {
        $this->suffix = $suffix;

        return $this;
    }

    public function date(?string $format = null, ?string $timezone = null): static
    {
        $this->dateFormat = $format ?? $this->getConfigValue('infolist.date_format', 'M j, Y');
        $this->timezone = $timezone;

        return $this;
    }

    public function dateTime(?string $format = null, ?string $timezone = null): static
    {
        $this->dateFormat = $format ?? $this->getConfigValue('infolist.datetime_format', 'M j, Y g:i A');
        $this->timezone = $timezone;

        return $this;
    }

    public function time(?string $format = null, ?string $timezone = null): static
    {
        $this->timeFormat = $format ?? $this->getConfigValue('infolist.time_format', 'g:i A');
        $this->timezone = $timezone;

        return $this;
    }

    public function since(?string $timezone = null): static
    {
        $this->timezone = $timezone;

        $this->formatStateUsing(function ($state) {
            if ($state === null) {
                return null;
            }

            $date = $state instanceof \DateTimeInterface
                ? $state
                : \Carbon\Carbon::parse($state, $this->timezone);

            return $date->diffForHumans();
        });

        return $this;
    }

    public function listable(bool|Closure $condition = true): static
    {
        $this->isListable = $condition;

        return $this;
    }

    public function separator(string $separator): static
    {
        $this->listSeparator = $separator;

        return $this;
    }

    public function bulleted(bool $condition = true): static
    {
        $this->isBulleted = $condition;

        return $this;
    }

    public function listWithLineBreaks(bool $condition = true): static
    {
        $this->isListWithLineBreaks = $condition;

        return $this;
    }

    public function getPrefix(): ?string
    {
        return $this->evaluate($this->prefix);
    }

    public function getSuffix(): ?string
    {
        return $this->evaluate($this->suffix);
    }

    public function isHtml(): bool
    {
        return $this->isHtml;
    }

    public function isMarkdown(): bool
    {
        return $this->isMarkdown;
    }

    public function isProse(): bool
    {
        return $this->isProse;
    }

    public function isListable(): bool
    {
        return (bool) $this->evaluate($this->isListable);
    }

    public function isBulleted(): bool
    {
        return $this->isBulleted;
    }

    public function isListWithLineBreaks(): bool
    {
        return $this->isListWithLineBreaks;
    }

    public function getSeparator(): string
    {
        return $this->listSeparator;
    }

    public function getListSeparator(): string
    {
        return $this->listSeparator;
    }

    public function getFormattedState(): mixed
    {
        $state = $this->getState();

        if ($state === null) {
            return null;
        }

        // Handle money formatting
        if ($this->isMoney && is_numeric($state)) {
            $formatter = new \NumberFormatter($this->currencyLocale, \NumberFormatter::CURRENCY);
            $state = $formatter->formatCurrency((float) $state, $this->currency);
        }

        // Handle date formatting
        if ($this->dateFormat !== null && $state !== null) {
            $date = $state instanceof \DateTimeInterface
                ? $state
                : \Carbon\Carbon::parse($state, $this->timezone);

            $state = $date->format($this->dateFormat);
        }

        // Handle time formatting
        if ($this->timeFormat !== null && $state !== null) {
            $date = $state instanceof \DateTimeInterface
                ? $state
                : \Carbon\Carbon::parse($state, $this->timezone);

            $state = $date->format($this->timeFormat);
        }

        // Apply custom formatting
        if ($this->formatStateUsing !== null) {
            $state = $this->evaluate($this->formatStateUsing, ['state' => $state]);
        }

        // Apply prefix/suffix
        $prefix = $this->getPrefix();
        $suffix = $this->getSuffix();

        if ($prefix !== null || $suffix !== null) {
            $state = ($prefix ?? '').$state.($suffix ?? '');
        }

        // Handle markdown
        if ($this->isMarkdown && is_string($state)) {
            $state = str($state)->markdown()->toHtmlString();
        }

        return $state;
    }

    protected function getViewName(): string
    {
        return 'infolists::components.text-entry';
    }
}
