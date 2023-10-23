<?php

namespace App\Entities;

use App\Services\Database\Mysql;

class Link extends Entity
{
    public int $id;

    public string $short;

    public string $long;

    public ?int $userId;

    public ?string $createdAt;

    protected function setTableName(): self
    {
        $this->tableName = 'links';
        return $this;
    }

    protected function setConnection(): self
    {
        $this->connection = new Mysql();
        return $this;
    }

    protected function setFields(): self
    {
        $this->fields = [
            'id' => 'id',
            'long' => 'long',
            'short' => 'short',
            'userId' => 'user_id',
            'createdAt' => 'created_at'
        ];

        return $this;
    }
}