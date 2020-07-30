<?php

namespace App\Repositories\UserRepository;

use App\Domain\Entities\User;
use App\Domain\Values\UserId;

interface IUserRepository
{
    public function save(User $user): void;

    public function find(UserId $userId): ?User;
}
