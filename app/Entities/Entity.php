<?php

namespace App\Entities;

use App\Services\Database\DatabaseConnection;

abstract class Entity
{
    protected string $tableName;

    protected DatabaseConnection $connection;

    protected array $fields;

    public function __construct()
    {
        $this->setTableName();
        $this->setConnection();
        $this->setFields();
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    abstract protected function setTableName(): self;

    public function getConnection(): DatabaseConnection
    {
        return $this->connection;
    }

    abstract protected function setConnection(): self;

    public function toArray(): array
    {
        $result = [];

        foreach ($this->getFields() as $field) {
            $result[$field] = $this->{$field};
        }

        return $result;
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    abstract protected function setFields(): self;
}