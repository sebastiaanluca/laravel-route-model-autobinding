<?php

declare(strict_types=1);

namespace SebastiaanLuca\RouteModelAutobinding\Tests\Feature\Commands;

use SebastiaanLuca\RouteModelAutobinding\RouteModelAutobindingServiceProvider;
use SebastiaanLuca\RouteModelAutobinding\Tests\TestCase;

class AutobinderCacheCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it caches all models() : void
    {
        $cache = base_path('bootstrap/cache/autobinding.php');

        $this->assertFileNotExists($cache);

        $this->artisan('autobinding:cache');

        $this->assertFileExists($cache);

        unlink($cache);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
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
