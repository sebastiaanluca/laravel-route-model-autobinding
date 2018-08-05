<?php

declare(strict_types=1);

namespace SebastiaanLuca\RouteModelAutobinding\Tests\Feature;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Routing\Router;
use SebastiaanLuca\RouteModelAutobinding\Autobinder;
use SebastiaanLuca\RouteModelAutobinding\Tests\MocksInstances;
use SebastiaanLuca\RouteModelAutobinding\Tests\TestCase;

class AutobinderCacheTest extends TestCase
{
    use MocksInstances;

    /**
     * @test
     */
    public function it doesnt read from cache when not cached() : void
    {
        $router = $this->mock(
            Router::class,
            [app(Dispatcher::class)]
        );

        $router->shouldReceive('model')->with('somethingInherited', 'App\\Models\\SomethingInherited');
        $router->shouldReceive('model')->with('user', 'App\\Models\\User');
        $router->shouldReceive('model')->with('address', 'MyModule\\Models\\Address');
        $router->shouldReceive('model')->with('thing', 'MyPackage\\Models\\Thing');
        $router->shouldReceive('model')->with('package', 'MyPackage\\Models\\Sub\\Package');

        app(Autobinder::class)->bindAll();
    }

    /**
     * @test
     */
    public function it reads from cache when cached() : void
    {
        $cachePath = base_path('bootstrap/cache');
        $cacheFile = base_path('bootstrap/cache/autobinding.php');

        $router = $this->mock(
            Router::class,
            [app(Dispatcher::class)]
        );

        $router->shouldReceive('model')->with('somethingCached', 'App\\Models\\SomethingCached');
        $router->shouldReceive('model')->with('cachedUser', 'App\\Models\\CachedUser');

        $create = mkdir(
            $cachePath,
            0775,
            true
        );

        $copy = copy(
            base_path('cache.php'),
            $cacheFile
        );

        $this->assertTrue($create);
        $this->assertTrue($copy);

        app(Autobinder::class)->bindAll();

        unlink($cacheFile);
        rmdir($cachePath);
        rmdir(base_path('bootstrap'));
    }
}
