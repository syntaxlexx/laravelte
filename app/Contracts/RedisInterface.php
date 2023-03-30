<?php

namespace App\Contracts;

interface RedisInterface
{

    /**
     * Gets data to be submitted to redis given a redis implementation
     * If a specific keys is intended, pass it on as an argument
     */
    public function data($key = null);

    public function getKeys();
}
