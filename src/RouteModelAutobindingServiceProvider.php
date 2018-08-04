<?php

declare(strict_types=1);

namespace SebastiaanLuca\RouteModelAutobinding;

use Illuminate\Support\ServiceProvider;
use SebastiaanLuca\RouteModelAutobinding\Commands\CacheRouteModels;
use SebastiaanLuca\RouteModelAutobinding\Commands\ClearCachedRouteModels;

class RouteModelAutobindingServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() : void
    {
        $this->mergeConfigFrom(
            $this->getConfigurationPath(),
            $this->getShortPackageName()
        );

        $this->commands(
            CacheRouteModels::class,
            ClearCachedRouteModels::class
        );
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() : void
    {
        $this->registerPublishableResources();

        app(Autobinder::class)->bindAll();
    }

    /**
     * @return void
     */
    private function registerPublishableResources() : void
    {
        $this->publishes([
            $this->getConfigurationPath() => config_path($this->getShortPackageName() . '.php'),
        ], $this->getPackageName() . ' (configuration)');
    }

    /**
     * @return string
     */
    private function getConfigurationPath() : string
    {
        return __DIR__ . '/../config/' . $this->getShortPackageName() . '.php';
    }

    /**
     * @return string
     */
    private function getShortPackageName() : string
    {
        return 'route-model-autobinding';
    }

    /**
     * @return string
     */
    private function getPackageName() : string
    {
        return 'laravel-route-model-autobinding';
    }
}
