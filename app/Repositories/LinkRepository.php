<?php

namespace App\Repositories;

use App\Entities\Link;
use App\Services\QueryBuilder\QueryBuilder;
use PDO;

class LinkRepository extends BaseRepository
{
    public function getMyLinks(int $userId, ?array $fields = null, int $limit = 1000): array
    {
        $fields = $fields ?: $this->entity->getFields();

        $query = (new QueryBuilder())
            ->select(...$fields)
            ->from($this->entity->getTableName())
            ->where('user_id = :user_id')
            ->limit($limit);

        $stmt = $this->entity->getDatabase()->getConnection()->prepare($query);
        $stmt->execute([
            'user_id' => $userId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function setEntity(): void
    {
        $this->entity = new Link();
    }
}