<?php

namespace App\Repositories;

use App\Entities\User;

class UserRepository extends BaseRepository
{
    protected function setEntity(): void
    {
        $this->entity = new User();
    }
}