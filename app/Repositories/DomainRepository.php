<?php

namespace App\Repositories;

use App\Entities\Link;

class DomainRepository extends BaseRepository
{
    protected function setEntity(): void
    {
        $this->entity = new Link();
    }
}