<?php

namespace Zwartpet\CommandUI\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\Pest\WithPest;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Workbench\App\Providers\WorkbenchServiceProvider;
use Zwartpet\CommandUI\CommandUIServiceProvider;

/**
 * @internal
 *
 * @coversNothing
 */
class TestCase extends OrchestraTestCase
{
    use RefreshDatabase;
    use WithPest;
    use WithWorkbench;

    /**
     * add the package provider
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            WorkbenchServiceProvider::class,
            CommandUIServiceProvider::class,
        ];
    }

    protected function defineRoutes($router) {}
}
