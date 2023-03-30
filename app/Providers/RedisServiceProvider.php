<?php

namespace App\Providers;

use App\Library\RedisConfigurations\Extras;
use App\Library\RedisConfigurations\Models;
use App\Library\RedisConfigurations\Settings;
use App\Library\RedisConfigurations\StaticData;
use App\Repositories\RedisRepository;
use Illuminate\Support\ServiceProvider;

class RedisServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    public function boot()
    {
        $redis = resolve(RedisRepository::class);

        $this->setRedisExtras($redis);

        $this->setRedisModels($redis);

        $this->setRedisStaticData($redis);

        $this->registerSettings($redis);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->singleton(RedisRepository::class, function () {
        //     return new RedisRepository();
        // });
    }

    /**
     * For seed classes that need to exist in redis and accessed also as selects within the UI
     */
    public function setRedisExtras($redis)
    {
        $select = new Extras();

        foreach(config('system_redis.extras') as $key)
        {
            if(is_array($key)) {
                $key = $key['table'];
            }

            if(! $redis->exists($key))
                $redis->store($select, $key);
        }
    }

    /**
     * For seed classes that need to exist in redis and need to be fetched as models
     */
    public function setRedisModels($redis)
    {
        $select = new Models();

        foreach(config('system_redis.models') as $key)
        {
            if(class_exists($key))
            {
                // $model = new $key();
                // $key = $model->getTable();

                if(! $redis->exists($key))
                    $redis->store($select, $key);
            }
        }
    }

    /**
     * For seed static data that need to exist in redis
     */
    public function setRedisStaticData($redis)
    {
        $select = new StaticData();

        foreach(config('system_redis.static_data') as $key)
        {
            if(is_array($key)) {
                $key = $key['key'];
            }

            if(! $redis->exists($key))
                $redis->store($select, $key);
        }
    }

    /**
     * Register the general system settings.
     * Exist in modules config/settings
     */
    public function registerSettings($redis)
    {
        $settings = new Settings();

        if(! $redis->exists('settings'))
        {
            $redis->store($settings, 'settings');
        }

        if(!$redis->exists('configurations'))
        {
            $redis->store($settings, 'configurations');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
