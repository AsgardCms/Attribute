<?php

namespace Modules\Attribute\Tests;

use Modules\Attribute\Providers\AttributeServiceProvider;
use Modules\Core\Providers\CoreServiceProvider;
use Nwidart\Modules\LaravelModulesServiceProvider;
use Orchestra\Testbench\TestCase;

abstract class BaseTestCase extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->resetDatabase();
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelModulesServiceProvider::class,
            CoreServiceProvider::class,
            AttributeServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['path.base'] = __DIR__ . '/..';
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', array(
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ));
        $app['config']->set('translatable.locales', ['en', 'fr']);
        $app['config']->set('modules.paths.modules', __DIR__ . '/../Modules');
    }

    private function resetDatabase()
    {
        // Makes sure the migrations table is created
        $this->artisan('migrate', [
            '--database' => 'sqlite',
        ]);
        // We empty all tables
        $this->artisan('migrate:reset', [
            '--database' => 'sqlite',
        ]);
        // Migrate
        $this->artisan('migrate', [
            '--database' => 'sqlite',
        ]);
    }
}
