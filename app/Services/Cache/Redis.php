<?php

namespace App\Services\Cache;

use Exception;
use Predis\Client;
use Predis\ClientInterface;

class Redis implements Cache
{
    private ClientInterface $redis;

    public function __construct()
    {
        $this->redis = new Client([
            'scheme' => 'tcp',
            'host' => $_ENV['REDIS_HOST'],
            'port' => $_ENV['REDIS_PORT']
        ]);
    }

    public function remember($key, callable $callback = null, $ttl = null)
    {
        if ($this->redis->exists($key)) {
            return $this->get($key);
        }

        if (!is_callable($callback)) {
            throw new Exception("Key value '{$key}' not in cache and not available callback to populate cache");
        }

        $value = call_user_func($callback);

        return $this->set($key, $value, $ttl);
    }

    public function get($key): mixed
    {
        if ($this->redis->exists($key)) {
            return json_decode($this->redis->get($key), true);
        }

        return null;
    }

    public function set($key, $value, $ttl = null): mixed
    {
        if (!is_null($ttl)) {
            $this->redis->set($key, json_encode($value), 'EX', $ttl);
        } else {
            $this->redis->set($key, json_encode($value));
        }

        return $value;
    }

    public function delete($key): array
    {
        $keys = $this->redis->keys($key);

        if (count($keys) > 0) {
            $this->redis->del($keys);
        }

        return $keys;
    }
}