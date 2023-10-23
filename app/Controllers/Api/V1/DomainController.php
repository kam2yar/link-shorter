<?php

namespace App\Controllers\Api\V1;

use App\Controllers\Controller;
use App\Entities\Domain;
use App\Repositories\DomainRepository;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;

class DomainController extends Controller
{
    protected DomainRepository $domainRepository;

    public function __construct()
    {
        parent::__construct();

        $this->domainRepository = new DomainRepository();
    }

    public function store(): void
    {
        $entity = new Domain();
        $entity->name = input('name');
        $entity->active = input('active') ?: true;
        $entity->createdAt = now();
        $entity->updatedAt = now();

        $this->domainRepository->insert($entity);

        response()->httpCode(201)->json([
            'success' => true
        ]);
    }

    public function all(): void
    {
        $domains = $this->domainRepository->all();

        response()->json([
            'domains' => $domains
        ]);
    }

    public function update(int $id): void
    {
        $domain = $this->domainRepository->find($id);

        if (!$domain) {
            throw new NotFoundHttpException();
        }

        $data = [];

        if ($name = input('name')) {
            $data['name'] = $name;
        }

        if ($active = input('active')) {
            $data['active'] = $active;
        }

        if (empty($data)) {
            response()->json([
                'success' => true
            ]);
        } else {
            $data['updated_at'] = now();
        }

        $success = $this->domainRepository->update($id, $data);

        response()->json([
            'success' => $success
        ]);
    }

    public function delete(int $id): void
    {
        $domain = $this->domainRepository->find($id);

        if (!$domain) {
            throw new NotFoundHttpException();
        }

        response()->json([
            'success' => $this->domainRepository->delete($id)
        ]);
    }
}