<?php

declare(strict_types=1);

namespace SebastiaanLuca\RouteModelAutobinding;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
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
        if ($this->useCache()) {
            return;
        }

        $models = $this->getModels();

        $this->bindRouteModels($models);
    }

    /**
     * @return array
     */
    public function getModels() : array
    {
        $config = $this->getComposerConfig();
        $paths = $this->getModelPaths($config);

        if (count($paths) === 0) {
            return [];
        }

        return $this->scan($paths);
    }

    /**
     * @return string
     */
    public function getCachePath() : string
    {
        return base_path('bootstrap/cache/autobinding.php');
    }

    /**
     * @return bool
     */
    protected function useCache() : bool
    {
        if (! file_exists($cache = $this->getCachePath())) {
            return false;
        }

        $this->bindRouteModels(include $cache);

        return true;
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
        $paths = Arr::get($config, 'autoload.psr-4');

        $paths = collect($paths)
            ->unique()
            ->mapWithKeys(function (string $path, string $namespace) {
                return [$namespace => base_path(rtrim($path, '/'))];
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
    protected function scan(array $paths) : array
    {
        $models = [];

        foreach ($paths as $namespace => $path) {
            foreach ((new Finder)->in($path)->files() as $file) {
                $name = str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::after($file->getPathname(), $path . DIRECTORY_SEPARATOR)
                );

                $model = $namespace . $name;

                if (! class_exists($model)) {
                    continue;
                }

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
     *
     * @return void
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
            case CaseTypes::SNAKE_CASE:
                return Str::snake($basename);

            case CaseTypes::STUDLY_CASE:
                return Str::studly($basename);

            case CaseTypes::CAMEL_CASE:
            default:
                return Str::camel($basename);
        }
    }
}
