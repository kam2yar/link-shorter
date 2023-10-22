<?php

namespace App\Entities;

use Database\Connections\Mysql;

class Link extends Entity
{
    private int $id;

    private string $long;

    private string $short;

    private int $userId;

    private string $createdAt;

    public function setTableName(): self
    {
        $this->tableName = 'links';
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
            ->setLong($data['long'])
            ->setShort($data['short'])
            ->setUserId($data['user_id'])
            ->setCreatedAt($data['created_at']);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Link
    {
        $this->id = $id;
        return $this;
    }

    public function getLong(): string
    {
        return $this->long;
    }

    public function setLong(string $long): self
    {
        $this->long = $long;
        return $this;
    }

    public function getShort(): string
    {
        return $this->short;
    }

    public function setShort(string $short): self
    {
        $this->short = $short;
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

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }
}