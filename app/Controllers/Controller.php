<?php

namespace App\Controllers;

use App\Services\Cache\Cache;

class Controller
{
    protected ?int $userId = null;

    protected Cache $cache;

    public function __construct()
    {
        $this->userId = $_SESSION['userId'] ?? null;
        $this->cache = new Cache();
    }
}