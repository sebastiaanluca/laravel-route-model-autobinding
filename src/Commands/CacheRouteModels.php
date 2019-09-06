<?php

declare(strict_types=1);

namespace SebastiaanLuca\RouteModelAutobinding\Commands;

use Illuminate\Console\Command;
use SebastiaanLuca\RouteModelAutobinding\Autobinder;

class CacheRouteModels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autobinding:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a cache file for faster route model binding';

    /**
     * @var \SebastiaanLuca\RouteModelAutobinding\Autobinder
     */
    private $binder;

    /**
     * Create a new command instance.
     *
     * @param \SebastiaanLuca\RouteModelAutobinding\Autobinder $binder
     */
    public function __construct(Autobinder $binder)
    {
        parent::__construct();

        $this->binder = $binder;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle() : void
    {
        $models = $this->binder->getModels();

        $cache = $this->binder->getCachePath();

        file_put_contents(
            $cache,
            '<?php return ' . var_export($models, true) . ';'
        );

        $this->info('Route model bindings cached!');
    }
}
