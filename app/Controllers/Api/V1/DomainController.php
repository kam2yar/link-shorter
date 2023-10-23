<?php

namespace App\Controllers\Api\V1;

use App\Controllers\Controller;
use App\Services\DomainService;

class DomainController extends Controller
{
    protected DomainService $domainService;

    public function __construct()
    {
        parent::__construct();

        $this->domainService = new DomainService();
    }

    public function store(): void
    {
        $success = $this->domainService->insert(input('name'), input('active', true));

        response()->httpCode(201)->json([
            'success' => $success
        ]);
    }

    public function all(): void
    {
        response()->json([
            'domains' => $this->domainService->all()
        ]);
    }

    public function update(int $id): void
    {
        $success = $this->domainService->update($id, input('name'), input('active'));

        response()->json([
            'success' => $success
        ]);
    }

    public function delete(int $id): void
    {
        response()->json([
            'success' => $this->domainService->delete($id)
        ]);
    }
}