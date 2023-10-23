<?php

namespace App\Services;

use App\Entities\Link;
use App\Repositories\LinkRepository;
use App\Transformers\LinkListTransformer;
use Exception;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;

class LinkService
{
    protected LinkRepository $linkRepository;

    public function __construct()
    {
        $this->linkRepository = new LinkRepository();
    }

    public function short(string $original, ?int $userId = null, ?int $domainId = null): string
    {
        $baseUrl = base_url();
        if ($domainId) {
            $domain = (new DomainService())->findOrFail($domainId);

            if (!$domain['active']) {
                throw new Exception('Domain is not active');
            }

            $baseUrl = 'https://' . $domain['name'] . '/';
        }

        $entity = new Link();
        $entity->short = uniqid();
        $entity->original = $original;
        $entity->userId = $userId;
        $entity->domainId = $domainId;
        $entity->createdAt = now();
        $entity->updatedAt = now();

        $this->linkRepository->insert($entity);

        return $baseUrl . $entity->short;
    }

    public function findOrFail(string $short): array
    {
        $link = $this->linkRepository->find($short, 'short');

        if (!$link) {
            throw new NotFoundHttpException();
        }

        return $link;
    }

    public function getMyLinks(int $userId): array
    {
        $links = $this->linkRepository->getMyLinks($userId, ['short', 'original']);

        return LinkListTransformer::transform($links);
    }

    public function delete(int $id): bool
    {
        return $this->linkRepository->delete($id);
    }

    public function update(int $id, ?string $short = null, ?string $original = null, ?int $domainId = null): bool
    {
        $data = [];

        if ($short) {
            $data['short'] = $short;
        }

        if ($original) {
            $data['original'] = $original;
        }

        if ($domainId) {
            $data['domainId'] = $domainId;
        }

        if (empty($data)) {
            response()->json([
                'success' => true
            ]);
        } else {
            $data['updated_at'] = now();
        }

        $this->linkRepository->beginTransaction();

        try {
            $this->linkRepository->update($id, $data);
            $this->linkRepository->commit();
        } catch (Exception) {
            $this->linkRepository->rollback();
            return false;
        }

        return true;
    }
}