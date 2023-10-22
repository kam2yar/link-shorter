<?php

namespace App\DTO;

use App\Entities\Entity;

class ResultCollection
{
    private array $result = [];

    public function add(Entity $entity): void
    {
        $this->result[] = $entity;
    }

    public function get(): array
    {
        return $this->result;
    }
}