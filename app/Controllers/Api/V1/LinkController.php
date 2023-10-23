<?php

namespace App\Controllers\Api\V1;

use App\Entities\Link;
use App\Repositories\LinkRepository;
use App\Transformers\LinkListTransformer;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;

class LinkController
{
    protected LinkRepository $repository;

    public function __construct()
    {
        $this->repository = new LinkRepository();
    }

    public function short(): void
    {
        $entity = new Link();
        $entity->short = rand(0, 999999);
        $entity->long = input('long');
        $entity->userId = null;
        $entity->createdAt = date('Y-m-d H:i:s');

        $this->repository->insert($entity);

        response()->json([
            'short_link' => base_url() . $entity->short
        ]);
    }

    public function myLinks(): void
    {
        $links = $this->repository->all(['short', 'long']);

        response()->json([
            'links' => LinkListTransformer::transform($links)
        ]);
    }

    public function get(string $short): void
    {
        $long = $this->repository->findByShortLink($short);

        if (!$long) {
            throw new NotFoundHttpException();
        }

        response()->json([
            'long_link' => $long
        ]);
    }
}