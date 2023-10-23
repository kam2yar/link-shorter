<?php

namespace App\Controllers\Api\V1;

use App\Entities\Link;
use App\Repositories\LinkRepository;

class LinkController
{
    public function short()
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

    public function all()
    {
        $repository = new LinkRepository();
        $links = $repository->all();

        response()->json([
            'data' => $links
        ]);
    }
}