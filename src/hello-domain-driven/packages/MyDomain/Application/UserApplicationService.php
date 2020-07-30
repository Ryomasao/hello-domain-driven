<?php

namespace MyDomain\Application;

use MyDomain\Repositories\UserRepository\IUserRepository;
use MyDomain\Services\UserService;
use MyDomain\Entities\User;
use MyDomain\Values\UserName;
use MyDomain\Values\UserId;
use MyDomain\Dto\UserData;

class UserApplicationService
{
    private IUserRepository $userRepository;

    private UserService $userService;

    public function __construct(IUserRepository $userRepository, UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    public function register(string $name, string $email): UserData
    {
        $user = new User(new UserName($name), $email);

        if ($this->userService->exists($user)) {
            // 専用のエラークラスをきったほうがいいのかな
            throw  new \Exception('user already exists');
        }

        return $this->toDto($this->userRepository->save($user));
    }

    public function get(string $userId): ?UserData
    {
        $targetId = new UserId($userId);

        $user = $this->userRepository->findById($targetId);

        if ($user !== null) {
            return $this->toDto($user);
        }

        return null;
    }

    private function toDto(User $from): UserData
    {
        return new UserData($from);
    }
}
