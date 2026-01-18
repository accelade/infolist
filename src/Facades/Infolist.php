<?php

declare(strict_types=1);

namespace Accelade\Infolists\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Accelade\Infolists\Infolist
 */
class Infolist extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'infolists';
    }
}
