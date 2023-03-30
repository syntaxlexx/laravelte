<?php

namespace App\Library\RedisConfigurations;

abstract class RedisTemplate
{
    protected $keys;

    public function __construct()
    {
        $this->setKeys();
    }

    abstract public function setKeys();

    /*
     * Return keys as they are stored in redis
     */
    public function getKeys()
    {
        return $this->keys;
    }

}