<?php

namespace App\Library\RedisConfigurations;

use App\Contracts\RedisInterface;
use App\Models\Configuration;
use Illuminate\Support\Facades\Schema;

class Settings extends RedisTemplate implements RedisInterface
{
    protected $data = [];
    protected $configModel;

    /*
     * Set the keys as they are to be returned to redis
     */
    public function setKeys()
    {
        $this->keys = ['settings', 'configurations'];
    }

    /*
     * Returns sidebar data that should be put into redis
     * Data is fetched from modules config/settings.php
     */
    public function data($key = null)
    {
        if($key == "configurations")
        {
            return $this->configurations();
        }

        return $this->settings();
    }

    /*
     * Redis settings exist in two different states
     * These are the overall settings defined
     * In the modules config/settings.php
     */
    public function settings()
    {
        $this->data = config('system_configurations');
        return $this->data;
    }

    /*
    * Redis settings exist in two different states
    * These are the organization settings configured
    * By the user from within the application
    * Always Clear defaults in DB first
    */
    public function configurations()
    {
        $table = (new Configuration())->getTable();

        if(! Schema::hasTable("${$table}")) {
            return collect();
        }

        $data = $this->settings();

        $this->setDefaultConfigurations($data);

        return Configuration::all();
    }

    /**
     * get the configuration model
     */
    public function getModel()
    {
        $class = config("system_redis.defaults.models.configuration");
        if(! class_exists($class))
            throw new \Exception("{$class} does not exist!");

        return new $class();
    }

    /*
     * Set the default configurations/organization settings given general settings data
     */
    public function setDefaultConfigurations($data)
    {
        foreach($data as $name => $config)
        {
            if(! Configuration::where('name', $name)->first())
            {
                $this->getModel()->create([
                    'name'          => $name,
                    'value'         => $config['default'] ?? null,
                    'type'          => $config['type'],
                    'hint'          => $config['hint'] ?? null,
                    'description'   => $config['description'],
                ]);
            }
        }
    }

    /**
     * clear settings and revert to default
     */
    public function resetAllConfigurationSettings()
    {
        $this->getModel()->query()->truncate();

        return $this->configurations();
    }

    /**
     * truncate config table
     */
    public function truncateTable()
    {
        Configuration::truncate();
    }

}
