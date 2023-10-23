<?php

namespace App\Repositories;

use App\Entities\Entity;
use App\Entities\Link;
use App\Services\QueryBuilder\QueryBuilder;

class LinkRepository extends BaseRepository
{
    public function setEntity(): void
    {
        $this->entity = new Link();
    }

    public function save(Entity $entity): array
    {
        $query = (new QueryBuilder())
            ->insert($entity->getTableName())
            ->columns(...$entity->getFields());

        $stmt = $entity->getDatabase()->getConnection()->prepare($query);
        $stmt->execute([
            'id' => null,
            'short' => $entity->short,
            'long' => $entity->long,
            'user_id' => $entity->userId,
            'created_at' => $entity->createdAt,
        ]);

        return [];
    }

}