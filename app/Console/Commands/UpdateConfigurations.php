<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redis;
use App\Library\RedisConfigurations\Settings;

class UpdateConfigurations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:update-configurations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update site config - updates and then clears the cache(redis)';

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

        if ($this->confirm('Do you wish to truncate configurations table?', false))
        {
            (new Settings())->truncateTable();
        }

        if ($this->confirm('Do you wish to repopulate configurations?', true))
        {
            $settings = new Settings();

            $data = $settings->data("settings");

            $settings->setDefaultConfigurations($data);

            $this->info('Done! ');
        }

        if ($this->confirm('Do you wish to clear cache to refresh?', true))
        {
            Artisan::call('cache:clear');

            $this->info('cache:clear completed! ');
        }

        if ($this->confirm('Do you wish to clear all redis?', false))
        {
            Redis::flushDB();

            $this->info('All redis DB cleared! ');
        }

        $this->line('Done Updating system configurations!');

    }

}
