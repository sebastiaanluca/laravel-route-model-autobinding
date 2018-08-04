<?php

declare(strict_types=1);

namespace SebastiaanLuca\RouteModelAutobinding;

use Illuminate\Support\ServiceProvider;

class RouteModelAutobindingServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() : void
    {
        $this->configure();
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
     * Register the package configuration.
     */
    private function configure() : void
    {
        $this->mergeConfigFrom(
            $this->getConfigurationPath(),
            $this->getShortPackageName()
        );
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
