<?php

namespace App\Controllers\Api\V1;

use App\Controllers\Controller;
use App\Services\DomainService;
use App\Services\LinkService;
use Exception;

class LinkController extends Controller
{
    protected LinkService $linkService;

    public function __construct()
    {
        parent::__construct();

        $this->linkService = new LinkService();
    }

    public function short(): void
    {
        $baseUrl = base_url();
        $domainId = input('domain_id');
        if ($domainId) {
            $domain = (new DomainService())->findOrFail($domainId);

            if (!$domain['active']) {
                throw new Exception('Domain is not active');
            }

            $baseUrl = 'https://' . $domain['name'] . '/';
        }

        $entity = $this->linkService->short(input('original'), $this->userId, $domainId);

        response()->httpCode(201)->json([
            'short_link' => $baseUrl . $entity->short
        ]);
    }

    public function myLinks(): void
    {
        response()->json([
            'links' => $this->linkService->getMyLinks($this->userId)
        ]);
    }

    public function delete(string $short): void
    {
        $link = $this->linkService->findOrFail($short);
        $result = $this->linkService->delete($link['id']);

        response()->json([
            'success' => $result
        ]);
    }

    public function get(string $short): void
    {
        $link = $this->linkService->findOrFail($short);

        response()->json([
            'original_link' => $link['original']
        ]);
    }

    public function update(string $short): void
    {
        $link = $this->linkService->findOrFail($short);
        $result = $this->linkService->update(
            $link['id'],
            input('short'),
            input('original'),
            input('domain_id')
        );

        response()->json([
            'success' => $result
        ]);
    }
}