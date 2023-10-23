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

    abstract protected function setEntity();

    public function all(?array $fields = null): array
    {
        $fields = $fields ?: $this->entity->getFields();

        $query = (new QueryBuilder())
            ->select(...$fields)
            ->from($this->entity->getTableName());

        return $this->entity->getDatabase()->getConnection()->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(mixed $value, string $field = 'id'): ?array
    {
        $query = (new QueryBuilder())
            ->select(...$this->entity->getFields())
            ->from($this->entity->getTableName())
            ->where($field . ' = :field')
            ->limit(1);

        $stmt = $this->entity->getDatabase()->getConnection()->prepare($query);
        $stmt->execute([
            'field' => $value
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return null;
        }

        return $result;
    }

    public function insert(Entity $entity): bool
    {
        $query = (new QueryBuilder())
            ->insert($entity->getTableName())
            ->columns(...$entity->getFields());

        $stmt = $entity->getDatabase()->getConnection()->prepare($query);

        $params = [];
        foreach ($entity->getFields() as $param => $name) {
            $params[$name] = $entity->{$param};
        }

        return $stmt->execute($params);
    }

    public function update(int $id, array $data): bool
    {
        $query = (new QueryBuilder())
            ->update($this->entity->getTableName())
            ->where('id = :id')
            ->set(...array_keys($data));
        
        $stmt = $this->entity->getDatabase()->getConnection()->prepare($query);
        $params = array_merge(['id' => $id], $data);

        return $stmt->execute($params);
    }

    public function delete(int $id): bool
    {
        $query = (new QueryBuilder())
            ->delete($this->entity->getTableName())
            ->where('id = :id');

        $stmt = $this->entity->getDatabase()->getConnection()->prepare($query);
        return $stmt->execute(['id' => $id]);
    }
}