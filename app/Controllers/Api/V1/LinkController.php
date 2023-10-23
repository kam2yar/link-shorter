<?php

namespace App\Controllers\Api\V1;

use App\Controllers\Controller;
use App\Services\LinkService;

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
        $entity = $this->linkService->short(input('original', $this->userId));

        response()->httpCode(201)->json([
            'short_link' => base_url() . $entity->short
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
        $link = $this->findOrFail($short);
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