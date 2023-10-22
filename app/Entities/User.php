<?php

namespace App\Entities;

use Database\Connections\Mysql;

class User extends Entity
{
    public string $tableName = 'users';

    private int $id;

    private string $email;

    private string $password;

    private string $createdAt;

    public function setTableName(): self
    {
        $this->tableName = 'users';
        return $this;
    }

    public function setConnection(): self
    {
        $this->connection = new Mysql();
        return $this;
    }

    public function mapToObject(array $data): self
    {
        return (new static())
            ->setId($data['id'])
            ->setEmail($data['email'])
            ->setPassword($data['password'])
            ->setCreatedAt($data['created_at']);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}