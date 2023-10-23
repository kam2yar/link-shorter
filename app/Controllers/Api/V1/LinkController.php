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
        $entity->short = 'something';
        $entity->long = 'something bozorgtar';
        $entity->createdAt = '2022-09-02 12:12:12';
        $created = $repository->save($entity);

        response()->json([
            'data' => $created
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