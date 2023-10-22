<?php

namespace App\Entities;

use Database\Connections\DataBaseConnection;

abstract class Entity
{
    protected string $tableName;

    protected DataBaseConnection $connection;

    public function __construct()
    {
        $this->setTableName();
        $this->setConnection();
    }

    abstract public function mapToObject(array $data): self;

    public function getTableName(): string
    {
        return $this->tableName;
    }

    abstract public function setTableName(): self;

    public function getConnection(): DataBaseConnection
    {
        return $this->connection;
    }

    abstract public function setConnection(): self;
}