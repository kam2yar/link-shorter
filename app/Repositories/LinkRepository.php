<?php

namespace App\Repositories;

use App\Entities\Link;

class LinkRepository extends BaseRepository
{
    public function setEntity(): void
    {
        $this->entity = new Link();
    }
}