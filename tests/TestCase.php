<?php

namespace Laymont\VenezuelanForeignExchanges\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laymont\VenezuelanForeignExchanges\Providers\VenezuelanForeignExchangesServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase;

    protected function getPackageProviders($app): array
    {
        return [
            VenezuelanForeignExchangesServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testbench');
        config()->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }
}