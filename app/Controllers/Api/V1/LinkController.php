<?php

namespace App\Controllers\Api\V1;

use App\Controllers\Controller;
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
        $this->validator->validate(input()->all(), [
            'original' => 'required|url',
            'domain_id' => 'nullable|numeric'
        ]);

        $short = $this->linkService->short(input('original'), $this->userId, input('domain_id'));

        response()->httpCode(201)->json([
            'short_link' => $short
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

        if ($link['user_id'] and $link['user_id'] != $this->userId) {
            throw new Exception('Access denied');
        }

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
        $this->validator->validate(input()->all(), [
            'short' => 'nullable',
            'original' => 'nullable|url',
            'domain_id' => 'nullable|numeric'
        ]);

        $link = $this->linkService->findOrFail($short);

        if ($link['user_id'] and $link['user_id'] != $this->userId) {
            throw new Exception('Access denied');
        }

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