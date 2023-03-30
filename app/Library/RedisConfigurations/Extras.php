<?php

namespace App\Library\RedisConfigurations;

use App\Contracts\RedisInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Extras extends RedisTemplate implements RedisInterface
{
    /*
     * Set the keys as they are to be returned to redis
     */
    public function setKeys()
    {
        $this->keys = config('system_redis.extras');
    }

    /*
     * Returns selects data to the repository for redis storage
     */
    public function data($key = null)
    {
        $key = str_replace(config('system_redis.application_prefix'), '', $key);

        if(Schema::hasTable("${key}")) {
            return DB::table("${key}")->get();
        }

        return collect();
    }
}
