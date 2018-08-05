<?php

declare(strict_types=1);

namespace SebastiaanLuca\RouteModelAutobinding\Tests\Feature\Commands;

use SebastiaanLuca\RouteModelAutobinding\RouteModelAutobindingServiceProvider;
use SebastiaanLuca\RouteModelAutobinding\Tests\TestCase;

class AutobinderClearCacheCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it clears the cache() : void
    {
        touch($cache = base_path('bootstrap/cache/autobinding.php'));

        $this->assertFileExists($cache);

        $this->artisan('autobinding:clear');

        $this->assertFileNotExists($cache);
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
