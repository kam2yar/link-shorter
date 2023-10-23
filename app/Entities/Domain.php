<?php

namespace App\Entities;

use App\Services\Database\Mysql;

class Domain extends Entity
{
    public ?int $id = null;

    public string $name;

    public bool $active = true;

    public ?string $createdAt = null;

    public ?string $updatedAt = null;

    protected function setTableName(): self
    {
        $this->tableName = 'domains';
        return $this;
    }

    protected function setDatabase(): self
    {
        $this->database = new Mysql();
        return $this;
    }

    protected function setFields(): self
    {
        $this->fields = [
            'id' => 'id',
            'name' => 'name',
            'active' => 'active',
            'createdAt' => 'created_at',
            'updatedAt' => 'updated_at'
        ];

        return $this;
    }
}