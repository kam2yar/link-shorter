<?php

namespace App\Repositories;

use App\Entities\Entity;
use App\Services\QueryBuilder\QueryBuilder;
use PDO;

abstract class BaseRepository
{
    protected Entity $entity;

    public function __construct()
    {
        $this->setEntity();
    }

    abstract public function setEntity();

    public function all(): array
    {
        $query = (new QueryBuilder())
            ->select('*')
            ->from($this->entity->getTableName());

        return $this->entity->getDatabase()->getConnection()->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $query = (new QueryBuilder())
            ->select('*')
            ->from($this->entity->getTableName())
            ->where('id = :id')
            ->limit(1);

        $stmt = $this->entity->getDatabase()->getConnection()->prepare($query);
        $stmt->execute([
            'id' => $id
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return null;
        }

        return $result;
    }

    public function delete(int $id): void
    {
        $query = (new QueryBuilder())
            ->delete($this->entity->getTableName())
            ->where('id = :id');

        $stmt = $this->entity->getDatabase()->getConnection()->prepare($query);
        $stmt->execute(['id' => $id]);
    }
}