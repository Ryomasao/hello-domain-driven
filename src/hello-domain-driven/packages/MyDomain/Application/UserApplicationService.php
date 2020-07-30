<?php

namespace MyDomain\Application;

use MyDomain\Repositories\UserRepository\IUserRepository;
use MyDomain\Services\UserService;
use MyDomain\Entities\User;
use MyDomain\Values\UserName;
use MyDomain\Values\UserId;

class UserApplicationService
{
    private IUserRepository $userRepository;

    private UserService $userService;

    public function __construct(IUserRepository $userRepository, UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    public function register(string $name, string $email): User
    {
        $user = new User(new UserName($name), $email);

        if ($this->userService->exists($user)) {
            // 専用のエラークラスをきったほうがいいのかな
            throw  new \Exception('user already exists');
        }

        return $this->userRepository->save($user);
    }

    public function get(string $userId): ?User
    {
        $targetId = new UserId($userId);
        return $this->userRepository->findById($targetId);
    }
}
