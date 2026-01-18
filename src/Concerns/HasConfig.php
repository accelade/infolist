<?php

declare(strict_types=1);

namespace Accelade\Infolists\Concerns;

trait HasConfig
{
    /**
     * Get a config value with a fallback for when Laravel app isn't available.
     */
    protected function getConfigValue(string $key, mixed $default): mixed
    {
        if (function_exists('app') && app()->bound('config')) {
            return config($key, $default);
        }

        return $default;
    }
}
