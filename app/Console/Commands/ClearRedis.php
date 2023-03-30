<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Cache;

class ClearRedis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:clear-redis';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear redis';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Cache::flush();

        $this->info("DONE! Refresh the page");
    }
}
