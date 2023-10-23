<?php

namespace App\Services;

use App\Entities\Domain;
use App\Repositories\DomainRepository;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;

class DomainService
{
    protected DomainRepository $domainRepository;

    public function __construct()
    {
        $this->domainRepository = new DomainRepository();
    }

    public function insert(string $name, bool $active = true): Domain
    {
        $entity = new Domain();
        $entity->name = $name;
        $entity->active = $active;
        $entity->createdAt = now();
        $entity->updatedAt = now();

        $this->domainRepository->insert($entity);

        return $entity;
    }

    public function all(): array
    {
        return $this->domainRepository->all();
    }

    public function delete(int $id): bool
    {
        return $this->domainRepository->delete($id);
    }

    public function findOrFail(int $id): array
    {
        $domain = $this->domainRepository->find($id);

        if (!$domain) {
            throw new NotFoundHttpException();
        }

        return $domain;
    }

    public function update(int $id, ?string $name = null, ?bool $active = null): bool
    {
        $data = [];

        if ($name) {
            $data['name'] = $name;
        }

        if ($active) {
            $data['active'] = $active;
        }

        if (empty($data)) {
            response()->json([
                'success' => true
            ]);
        } else {
            $data['updated_at'] = now();
        }

        return $this->domainRepository->update($id, $data);
    }
}