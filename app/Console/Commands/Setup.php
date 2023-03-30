<?php

namespace App\Console\Commands;

use App\Library\RedisConfigurations\Settings;
use Database\Seeders\PermissionTableSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class Setup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup a fresh installation after running migrations';

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
     * @return int
     */
    public function handle()
    {
        $steps = 3;
        $bar = $this->output->createProgressBar($steps);

        $bar->start();

        // run default seeder
        $this->line('Seeding Default Seeders');
        $this->call('db:seed');

        $bar->advance();

        // run settings
        $this->line('Seeding Configurations');
        $settings = new Settings();
        $data = $settings->data("settings");
        $settings->setDefaultConfigurations($data);

        $bar->advance();

        // clearing cache
        $this->line('Clearing cache');
        $this->call('cache:clear');

        $bar->advance();

        // generate new key
        $this->line('Generating new key');
        $this->call('key:generate');

        $bar->finish();

        $this->info('Done running Setup');

        return 0;
    }
}
