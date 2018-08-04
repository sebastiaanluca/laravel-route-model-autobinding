<?php

namespace SebastiaanLuca\RouteModelAutobinding\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app) : void
    {
        app()->setBasePath(__DIR__ . '/resources');
    }
}
