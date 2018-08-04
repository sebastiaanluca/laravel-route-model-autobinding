<?php

declare(strict_types=1);

namespace SebastiaanLuca\RouteModelAutobinding;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Router;
use ReflectionClass;
use Symfony\Component\Finder\Finder;

class Autobinder
{
    /**
     * @var \Illuminate\Routing\Router
     */
    private $router;

    /**
     * @param \Illuminate\Routing\Router $routes
     */
    public function __construct(Router $routes)
    {
        $this->router = $routes;
    }

    /**
     * Scan all model directories and automatically bind Eloquent models as route segment variables.
     *
     * @return void
     */
    public function bindAll() : void
    {
        $config = $this->getComposerConfig();
        $paths = $this->getModelPaths($config);

        if (empty($paths)) {
            return;
        }

        $models = $this->getModels($paths);

        $this->bindRouteModels($models);
    }

    /**
     * @return array
     */
    protected function getComposerConfig() : array
    {
        $composer = file_get_contents(base_path('composer.json'));

        return json_decode($composer, true, JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param array $config
     *
     * @return array
     */
    protected function getModelPaths(array $config) : array
    {
        $paths = array_get($config, 'autoload.psr-4');

        $paths = collect($paths)
            ->unique()
            ->mapWithKeys(function (string $path, string $namespace) {
                return [$namespace . 'Models\\' => base_path($path) . 'Models/'];
            })
            ->filter(function (string $path) {
                return is_dir($path);
            });

        return $paths->toArray();
    }

    /**
     * @param array $paths
     *
     * @return array
     */
    protected function getModels(array $paths) : array
    {
        $models = [];

        foreach ($paths as $namespace => $path) {
            foreach ((new Finder)->in($path)->files() as $file) {
                $model = $namespace . str_replace(
                        ['/', '.php'],
                        ['\\', ''],
                        str_after($file->getPathname(), 'Models' . DIRECTORY_SEPARATOR)
                    );

                $reflection = new ReflectionClass($model);

                if ($reflection->isAbstract() || ! is_subclass_of($model, Model::class)) {
                    continue;
                }

                $models[] = $model;
            }
        }

        return $models;
    }

    /**
     * @param array $models
     */
    protected function bindRouteModels(array $models) : void
    {
        foreach ($models as $model) {
            $this->router->model(
                $this->getModelAlias($model),
                $model
            );
        }
    }

    /**
     * @param string $model
     *
     * @return string
     */
    protected function getModelAlias(string $model) : string
    {
        $basename = class_basename($model);

        switch (config('route-model-autobinding.case')) {
            case 'snake':
                return snake_case($basename);

            case 'studly':
                return studly_case($basename);

            case 'camel':
            default:
                return camel_case($basename);
        }
    }
}
