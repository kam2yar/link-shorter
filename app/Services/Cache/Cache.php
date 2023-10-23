<?php

namespace App\Services\Cache;

interface Cache
{
    public function remember($key, callable $callback = null, $ttl = null);

    public function get($key): mixed;

    public function set($key, $value, $ttl = null): mixed;


    public function delete($key): bool;
}