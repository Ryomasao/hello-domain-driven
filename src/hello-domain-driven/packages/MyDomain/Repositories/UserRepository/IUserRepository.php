<?php

namespace MyDomain\Repositories\UserRepository;

use MyDomain\Entities\User;
use MyDomain\Values\UserId;

interface IUserRepository
{
    public function save(User $user): User;

    public function findById(UserId $userId): ?User;

    public function delete(User $user): void;
}
