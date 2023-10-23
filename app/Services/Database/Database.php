<?php

namespace App\Services\Database;

use PDO;

abstract class Database
{
    public function __construct()
    {
        $this->prepareConnection();
    }

    abstract protected function prepareConnection(): void;

    abstract public function getConnection(): PDO;
}