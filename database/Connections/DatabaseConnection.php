<?php

namespace Database\Connections;

abstract class DatabaseConnection
{
    public function __construct()
    {
        $this->prepareConnection();
    }

    abstract public function prepareConnection(): void;
}