<?php

namespace App\Controllers\Api\V1;

use App\Controllers\Controller;
use App\Entities\Link;
use App\Repositories\LinkRepository;
use App\Transformers\LinkListTransformer;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;

class LinkController extends Controller
{
    protected LinkRepository $linkRepository;

    public function __construct()
    {
        parent::__construct();

        $this->linkRepository = new LinkRepository();
    }

    public function short(): void
    {
        $entity = new Link();
        $entity->short = uniqid();
        $entity->long = input('long');
        $entity->userId = $this->userId;
        $entity->createdAt = now();

        $this->linkRepository->insert($entity);

        response()->httpCode(201)->json([
            'short_link' => base_url() . $entity->short
        ]);
    }

    public function myLinks(): void
    {
        $links = $this->linkRepository->all(['short', 'long']);

        response()->json([
            'links' => LinkListTransformer::transform($links)
        ]);
    }

    public function get(string $short): void
    {
        $link = $this->linkRepository->find($short, 'short');

        if (!$link) {
            throw new NotFoundHttpException();
        }

        response()->json([
            'long_link' => $link['long']
        ]);
    }

    public function delete(string $short): void
    {
        $link = $this->linkRepository->findByShortLink($short);

        if (!$link) {
            throw new NotFoundHttpException();
        }

        response()->json([
            'success' => $this->linkRepository->delete($link['id'])
        ]);
    }
}