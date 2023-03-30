<?php

namespace App\Library\RedisConfigurations;

use App\Contracts\RedisInterface;
use Illuminate\Support\Facades\Schema;

class Models extends RedisTemplate implements RedisInterface
{
    /*
     * Set the keys as they are to be returned to redis
     */
    public function setKeys()
    {
        $this->keys = config('system_redis.models');
    }

    /*
     * Returns selects data to the repository for redis storage
     */
    public function data($key = null)
    {
        if(class_exists($key))
        {
            $model = new $key();
            $tableName = $model->getTable();

            if(Schema::hasTable("${tableName}")) {
                $data = $model->get()->toArray();

                return [
                    'key' => $tableName,
                    'data' => $data,
                ];
            }

            return [];
        }

        return collect();
    }

}
