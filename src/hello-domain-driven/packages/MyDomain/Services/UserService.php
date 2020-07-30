<?php

namespace MyDomain\Services;

use MyDomain\Entities\User;
use MyDomain\Repositories\UserRepository\IUserRepository;

class UserService
{
    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function exists(User $user): bool
    {
        return !!$this->userRepository->findById($user->id());
    }
}
