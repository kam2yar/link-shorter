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
        $this->validator->validate(input()->all(), [
            'name' => 'required|unique:domains,name',
            'active' => 'nullable|boolean'
        ]);

        $success = $this->domainService->insert(input('name'), input('active', true));
        $this->forgetCache();

        response()->httpCode(201)->json([
            'success' => $success
        ]);
    }

    public function all(): void
    {
        $domains = $this->cache->remember('domains', function () {
            return $this->domainService->all();
        }, 3600);

        response()->json([
            'domains' => $domains
        ]);
    }

    public function forgetCache(): void
    {
        $this->cache->delete('domains');
    }

    public function delete(int $id): void
    {
        $success = $this->domainService->delete($id);
        $this->forgetCache();

        response()->json([
            'success' => $success
        ]);
    }

    public function update(int $id): void
    {
        $this->validator->validate(input()->all(), [
            'name' => 'required|unique:domains,name',
            'active' => 'nullable|boolean'
        ]);

        $success = $this->domainService->update($id, input('name'), input('active'));
        $this->forgetCache();

        response()->json([
            'success' => $success
        ]);
    }
}