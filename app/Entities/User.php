<?php

namespace App\Entities;

use App\Services\Database\Mysql;

class User extends Entity
{
    public string $tableName = 'users';

    public int $id;

    public string $email;

    public string $password;

    public ?string $createdAt = null;

    protected function setDatabase(): self
    {
        $this->database = new Mysql();
        return $this;
    }

    protected function setTableName(): self
    {
        $this->tableName = 'users';
        return $this;
    }

    protected function setFields(): self
    {
        $this->fields = [
            'id' => 'id',
            'email' => 'email',
            'password' => 'password',
            'createdAt' => 'created_at'
        ];

        return $this;
    }
}