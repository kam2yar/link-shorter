<?php

namespace App\Repositories;

use App\Entities\User;

class UserRepository extends BaseRepository
{
    public function setEntity(): void
    {
        $this->entity = new User();
    }
}