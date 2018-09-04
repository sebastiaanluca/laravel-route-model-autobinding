<?php

declare(strict_types=1);

namespace SebastiaanLuca\RouteModelAutobinding\Tests\Feature;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Routing\Router;
use SebastiaanLuca\RouteModelAutobinding\Autobinder;
use SebastiaanLuca\RouteModelAutobinding\Tests\MocksInstances;
use SebastiaanLuca\RouteModelAutobinding\Tests\TestCase;

class AutobinderTest extends TestCase
{
    use MocksInstances;

    /**
     * @test
     */
    public function it binds all models() : void
    {
        $router = $this->mock(
            Router::class,
            [app(Dispatcher::class)]
        );

        $router->shouldReceive('model')->with('user', 'App\\User');
        $router->shouldReceive('model')->with('somethingInherited', 'App\\Models\\SomethingInherited');
        $router->shouldReceive('model')->with('address', 'MyModule\\Models\\Address');
        $router->shouldReceive('model')->with('thing', 'MyPackage\\Models\\Thing');
        $router->shouldReceive('model')->with('package', 'MyPackage\\Models\\Sub\\Package');

        app(Autobinder::class)->bindAll();
    }

    /**
     * @test
     */
    public function it returns all models() : void
    {
        $models = app(Autobinder::class)->getModels();

        $expected = [
            'App\\User',
            'App\\Models\\SomethingInherited',
            'MyModule\\Models\\Address',
            'MyPackage\\Models\\Sub\\Package',
            'MyPackage\\Models\\Thing',
        ];

        $this->assertSameValues($expected, $models);
    }

    /**
     * @test
     */
    public function it returns the cache path() : void
    {
        $path = app(Autobinder::class)->getCachePath();

        $this->assertSame(
            base_path('bootstrap/cache/autobinding.php'),
            $path
        );
    }
}
