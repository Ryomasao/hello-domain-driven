<?php

namespace App\Domain\Services;

use App\Domain\Entities\User;

class UserService
{
    public function exists(User $user): bool
    {
        return false;
    }
}
