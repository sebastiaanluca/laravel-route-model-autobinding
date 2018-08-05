<?php

declare(strict_types=1);

namespace SebastiaanLuca\RouteModelAutobinding\Tests\Feature;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Routing\Router;
use Mockery\MockInterface;
use SebastiaanLuca\RouteModelAutobinding\Autobinder;
use SebastiaanLuca\RouteModelAutobinding\CaseTypes;
use SebastiaanLuca\RouteModelAutobinding\Tests\MocksInstances;
use SebastiaanLuca\RouteModelAutobinding\Tests\TestCase;

class AutobinderCaseTest extends TestCase
{
    use MocksInstances;

    /**
     * @test
     */
    public function it binds all models using the default case() : void
    {
        $router = $this->getRouter();

        config()->set('route-model-autobinding.case', null);

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
    public function it binds all models using camel case() : void
    {
        $router = $this->getRouter();

        config()->set('route-model-autobinding.case', CaseTypes::CAMEL_CASE);

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
    public function it binds all models using snake case() : void
    {
        $router = $this->getRouter();

        config()->set('route-model-autobinding.case', CaseTypes::SNAKE_CASE);

        $router->shouldReceive('model')->with('user', 'App\\User');
        $router->shouldReceive('model')->with('something_inherited', 'App\\Models\\SomethingInherited');
        $router->shouldReceive('model')->with('address', 'MyModule\\Models\\Address');
        $router->shouldReceive('model')->with('thing', 'MyPackage\\Models\\Thing');
        $router->shouldReceive('model')->with('package', 'MyPackage\\Models\\Sub\\Package');

        app(Autobinder::class)->bindAll();
    }

    /**
     * @test
     */
    public function it binds all models using studly case() : void
    {
        $router = $this->getRouter();

        config()->set('route-model-autobinding.case', CaseTypes::STUDLY_CASE);

        $router->shouldReceive('model')->with('User', 'App\\User');
        $router->shouldReceive('model')->with('SomethingInherited', 'App\\Models\\SomethingInherited');
        $router->shouldReceive('model')->with('Address', 'MyModule\\Models\\Address');
        $router->shouldReceive('model')->with('Thing', 'MyPackage\\Models\\Thing');
        $router->shouldReceive('model')->with('Package', 'MyPackage\\Models\\Sub\\Package');

        app(Autobinder::class)->bindAll();
    }

    /**
     * @return \Mockery\MockInterface
     */
    private function getRouter() : MockInterface
    {
        return $this->mock(
            Router::class,
            [app(Dispatcher::class)]
        );
    }
}
