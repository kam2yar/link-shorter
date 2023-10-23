<?php

namespace App\Controllers;

use App\Services\Cache\Cache;
use App\Services\Cache\Redis;
use App\Services\FormValidator;

class Controller
{
    protected ?int $userId = null;

    protected Cache $cache;

    protected FormValidator $validator;

    public function __construct()
    {
        $this->userId = $_SESSION['userId'] ?? null;
        $this->cache = new Redis();
        $this->validator = new FormValidator();
    }
}