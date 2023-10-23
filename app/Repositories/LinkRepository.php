<?php

namespace App\Repositories;

use App\Entities\Link;
use App\Services\QueryBuilder\QueryBuilder;
use PDO;

class LinkRepository extends BaseRepository
{
    public function findByShortLink(string $short): ?array
    {
        $query = QueryBuilder::select(...$this->entity->getFields())
            ->from($this->entity->getTableName())
            ->where('short = :short')
            ->limit(1)
            ->orderBy('id DESC');

        $stmt = $this->entity->getDatabase()->getConnection()->prepare($query);
        $stmt->execute([
            'short' => $short
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return null;
        }

        return $result;
    }

    protected function setEntity(): void
    {
        $this->entity = new Link();
    }
}