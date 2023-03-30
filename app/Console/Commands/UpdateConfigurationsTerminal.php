<?php

namespace App\Console\Commands;

use App\Library\RedisConfigurations\Settings;
use Illuminate\Console\Command;

class UpdateConfigurationsTerminal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:update-configurations-terminal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update site config - updates [order_options] table and then clears the cache(redis) for Terminals';

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
        $this->info('Updating system configuration...');

        $settings = new Settings();

        $data = $settings->data("settings");

        $settings->setDefaultConfigurations($data);

        $this->call('cache:clear');

        $this->info('Done updating system configuration...');
    }
}
