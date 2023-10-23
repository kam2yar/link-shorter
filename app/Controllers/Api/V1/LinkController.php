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
        $entity->original = input('original');
        $entity->userId = $this->userId;
        $entity->domainId = null;
        $entity->createdAt = now();
        $entity->updatedAt = now();

        $this->linkRepository->insert($entity);

        response()->httpCode(201)->json([
            'short_link' => base_url() . $entity->short
        ]);
    }

    public function myLinks(): void
    {
        $links = $this->linkRepository->all(['short', 'original']);

        response()->json([
            'links' => LinkListTransformer::transform($links)
        ]);
    }

    public function delete(string $short): void
    {
        $link = $this->linkRepository->find($short, 'short');

        if (!$link) {
            throw new NotFoundHttpException();
        }

        response()->json([
            'success' => $this->linkRepository->delete($link['id'])
        ]);
    }

    public function get(string $short): void
    {
        $link = $this->linkRepository->find($short, 'short');

        if (!$link) {
            throw new NotFoundHttpException();
        }

        response()->json([
            'original_link' => $link['original']
        ]);
    }

    public function update(string $short): void
    {
        $link = $this->linkRepository->find($short, 'short');

        if (!$link) {
            throw new NotFoundHttpException();
        }

        $data = [];

        if ($short = input('short')) {
            $data['short'] = $short;
        }

        if ($original = input('original')) {
            $data['original'] = $original;
        }

        if (empty($data)) {
            response()->json([
                'success' => true
            ]);
        } else {
            $data['updated_at'] = now();
        }

        $success = $this->linkRepository->update($link['id'], $data);

        response()->json([
            'success' => $success
        ]);
    }
}