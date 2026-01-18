<?php

declare(strict_types=1);

namespace Accelade\Infolists\Tests;

use Accelade\Infolists\InfolistsServiceProvider;
use Accelade\Schemas\SchemasServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            SchemasServiceProvider::class,
            InfolistsServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('app.key', 'base64:'.base64_encode(random_bytes(32)));
    }
}
