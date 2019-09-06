<?php

declare(strict_types=1);

namespace SebastiaanLuca\RouteModelAutobinding\Commands;

use Illuminate\Console\Command;
use SebastiaanLuca\RouteModelAutobinding\Autobinder;

class ClearCachedRouteModels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autobinding:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove the route model binding cache file';

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
        @unlink($this->binder->getCachePath());

        $this->info('Route model bindings cleared!');
    }
}
