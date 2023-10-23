<?php

namespace App\Controllers\Api\V1;

use App\Entities\Link;
use App\Repositories\LinkRepository;

class LinkController
{
    public function short(): void
    {
        $repository = new LinkRepository();

        $entity = new Link();
        $entity->short = rand(0, 999999);
        $entity->long = 'something bozorgtar';
        $entity->userId = null;
        $entity->createdAt = date('Y-m-d H:i:s');

        $repository->insert($entity);

        response()->json([
            'data' => [
                'url' => $entity->short
            ]
        ]);
    }

    public function myLinks(): void
    {
        $repository = new LinkRepository();
        $links = $repository->all();

        response()->json([
            'data' => $links
        ]);
    }
}