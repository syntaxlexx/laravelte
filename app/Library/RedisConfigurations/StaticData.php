<?php

namespace App\Library\RedisConfigurations;

use App\Contracts\RedisInterface;

class StaticData extends RedisTemplate implements RedisInterface
{
    /*
     * Set the keys as they are to be returned to redis
     */
    public function setKeys()
    {
        $this->keys = config('system_redis.static_data');
    }

    /*
     * Returns selects data to the repository for redis storage
     */
    public function data($key = null)
    {
        $data = collect(config('system_redis.static_data'));

        return $data->where('key', $key)->first()['data'];
    }
}
