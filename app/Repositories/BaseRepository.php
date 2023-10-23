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

    public function all(Entity $entity): array
    {
        $query = (new QueryBuilder())
            ->select('*')
            ->from($entity->getTableName());

        return $entity->getDatabase()->getConnection()->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(Entity $entity, int $id): ?array
    {
        $query = (new QueryBuilder())
            ->select('*')
            ->from($entity->getTableName())
            ->where('id = :id')
            ->limit(1);

        $stmt = $entity->getDatabase()->getConnection()->prepare($query);
        $stmt->execute([
            'id' => $id
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return null;
        }

        return $result;
    }

    public function delete(Entity $entity, int $id): void
    {
        $query = (new QueryBuilder())
            ->delete($entity->getTableName())
            ->where('id = :id');

        $stmt = $entity->getDatabase()->getConnection()->prepare($query);
        $stmt->execute(['id' => $id]);
    }
}