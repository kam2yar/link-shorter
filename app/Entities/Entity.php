<?php

namespace App\Entities;

use Database\Connections\DatabaseConnection;

abstract class Entity
{
    protected string $tableName;

    protected DatabaseConnection $connection;

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

    public function getConnection(): DatabaseConnection
    {
        return $this->connection;
    }

    abstract public function setConnection(): self;
}