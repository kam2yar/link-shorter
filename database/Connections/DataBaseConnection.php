<?php

namespace Database\Connections;

abstract class DataBaseConnection
{
    public function __construct()
    {
        $this->prepareConnection();
    }

    abstract public function prepareConnection(): void;
}