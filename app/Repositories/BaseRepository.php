<?php

namespace App\Repositories;

use App\DTO\ResultCollection;
use App\Entities\Entity;

abstract class BaseRepository
{
    protected Entity $entity;

    public function __construct()
    {
        $this->setEntity();
    }

    abstract public function setEntity();

    public function all(): ResultCollection
    {
        return $this->entity->getConnection()->all($this->entity);
    }

    public function save(Entity $entity): Entity
    {
        return $this->entity->getConnection()->save($entity);
    }

    public function find(int $id): ?Entity
    {
        return $this->entity->getConnection()->find($this->entity, $id);
    }

    public function delete(int $id): void
    {
        $this->entity->getConnection()->delete($this->entity, $id);
    }
}