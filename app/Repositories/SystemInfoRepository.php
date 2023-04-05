<?php

namespace App\Repositories;

use App\Models\Configuration;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\DemoTableSeeder;
use DB;
use Illuminate\Support\Facades\Artisan;

class SystemInfoRepository
{
    /**
     * perform a reset in the system
     *
     * @param $action
     *
     * @return bool
     */
    public function reset($action)
    {
        if(! defined ( 'STDIN' ))
            define('STDIN', fopen("php://stdin","r"));

        switch($action)
        {
            case 'cache':
            case 'redis':
            case 'configurations':
                Artisan::call('cache:clear');
                return true;
                break;

            case 'update-configurations':
                Artisan::call('system:update-configurations-terminal');
                Artisan::call('cache:clear');
                return true;
                break;

            case 'reset-configurations':
                Configuration::truncate();
                Artisan::call('system:update-configurations-terminal');
                Artisan::call('cache:clear');
                return true;
                break;

            case 'views':
                Artisan::call('view:clear');
                return true;
                break;

            case 'redis-key':
                $key = request('redis-key');
                $key ? redis()->del($key) : null;
                return true;
                break;

            case 'run-seeder':
                (new DatabaseSeeder)->run();
                return true;
                break;

            case 'seed-demo-data':
                (new DemoTableSeeder)->run();
                return true;
                break;

            default:
                break;
        }

        return false;
    }
}
