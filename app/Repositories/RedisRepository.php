<?php

namespace App\Repositories;

use App\Contracts\RedisInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class RedisRepository
{
    public $prefix;

    /**
     * Initialize redis
     */
    public function __construct()
    {
        $this->prefix = config('cache.prefix');
    }

    /**
     * Get a single item from the redis server
     * Does not create an item if not found
     */
    public function get($key)
    {
        $key = $this->prefix . $key;

        return Cache::get($key) ? unserialize(Cache::get($key)) : null;
    }

    /**
     * Store data as key => value pair into redis
     */
    public function store(RedisInterface $contract, $key)
    {
        $data = $contract->data($key);
        $key = $this->prefix . $key;

        // check if $data has $data inside
        if(is_array($data) and isset($data['data'])) {
            $key = $this->prefix . $data['key'];
            $data = $data['data'];
        }

        // filter deleted_at data
        $data = collect($data)->filter(function($item) {
            if(! isset($item->deleted_at) || (isset($item->deleted_at) and !$item->deleted_at))
                return $item;
        });


        if(! $this->exists($key))
        {
            Cache::put($key, serialize($data));
        }

        return $this;
    }

    /**
     * Get an item or list of items by key(s) from the redis server
     * Creates the item if it does not exist in the redis server
     */
    public function fetch(RedisInterface $contract, $keys = [])
    {
        $keys = count($keys) > 0 ? $keys : $contract->getKeys();

        $data = [];

        foreach($keys as $key)
        {
            $key = $this->prefix . $key;

            $this->exists($key) ?: $this->store($contract, $key);

            $data[$key] = unserialize(Cache::get($key));
        }

        return count($data) == 1 ? Arr::first($data) : $data;
    }

    /**
     * Reset the redis data and pull in new ones
     */
    public function reset(RedisInterface $contract, $key)
    {
        Cache::forget($key);

        $key = $this->prefix . $key;

        return $this->store($contract, $key);
    }

    /**
     * Checks if the key exists in the redis server
     */
    public function exists($key)
    {
        $key = $this->prefix . $key;

        return Cache::has($key);
    }

    /**
     * store data in redis
     * @param $key
     * @param $data
     *
     * @return mixed
     */
    public function set($key, $data)
    {
        $key = $this->prefix . $key;

        //confirm is serialized
        if (! is_serialized($data)) {
            $data = serialize($data);
        }

        // check if is set. Delete if true
        if ($this->exists($key)) {
            $this->del($key);
        }

        return Cache::put($key, $data);
    }

    /**
     * delete a key stored in redis
     */
    public function del($key)
    {
        $key = $this->prefix . $key;

        return Cache::forget($key);
    }

    /**
     * an alias for del()
     * @param $key
     *
     * @return mixed
     */
    public function delete($key)
    {
        return $this->del($key);
    }
}
