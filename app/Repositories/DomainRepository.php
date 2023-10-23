<?php

namespace App\Repositories;

use App\Entities\Domain;

class DomainRepository extends BaseRepository
{
    protected function setEntity(): void
    {
        $this->entity = new Domain();
    }
}