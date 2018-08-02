<?php

namespace SebastiaanLuca\RouteModelAutobinding\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use SebastiaanLuca\RouteModelAutobinding\RouteModelAutobindingServiceProvider;

class TestCase extends BaseTestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app) : array
    {
        return [
            RouteModelAutobindingServiceProvider::class,
        ];
    }
}
