<?php

namespace App\Entities;

use App\Services\Database\Database;

abstract class Entity
{
    protected string $tableName;

    protected Database $database;

    protected array $fields;

    public function __construct()
    {
        $this->setTableName();
        $this->setDatabase();
        $this->setFields();
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    abstract protected function setTableName(): self;

    public function getDatabase(): Database
    {
        return $this->database;
    }

    abstract protected function setDatabase(): self;

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