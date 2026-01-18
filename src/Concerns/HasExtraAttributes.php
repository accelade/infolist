<?php

declare(strict_types=1);

namespace Accelade\Infolists\Concerns;

use Closure;
use Illuminate\View\ComponentAttributeBag;

trait HasExtraAttributes
{
    /**
     * @var array<array<string, mixed>|Closure>
     */
    protected array $extraAttributes = [];

    /**
     * @param  array<string, mixed>|Closure  $attributes
     */
    public function extraAttributes(array|Closure $attributes, bool $merge = false): static
    {
        if ($merge) {
            $this->extraAttributes[] = $attributes;
        } else {
            $this->extraAttributes = [$attributes];
        }

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function getExtraAttributes(): array
    {
        $attributes = [];

        foreach ($this->extraAttributes as $extraAttributes) {
            $extraAttributes = $this->evaluate($extraAttributes);

            if (is_array($extraAttributes)) {
                $attributes = array_merge($attributes, $extraAttributes);
            }
        }

        return $attributes;
    }

    public function getExtraAttributeBag(): ComponentAttributeBag
    {
        return new ComponentAttributeBag($this->getExtraAttributes());
    }
}
