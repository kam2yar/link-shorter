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

    public function insert(Entity $entity): bool
    {
        $query = (new QueryBuilder())
            ->insert($entity->getTableName())
            ->columns('short', 'long', 'user_id', 'created_at');

        $stmt = $entity->getDatabase()->getConnection()->prepare($query);
        
        return $stmt->execute([
            'short' => $entity->short,
            'long' => $entity->long,
            'user_id' => $entity->userId,
            'created_at' => $entity->createdAt
        ]);
    }

}