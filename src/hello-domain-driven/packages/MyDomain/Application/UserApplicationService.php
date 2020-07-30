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
            // Q 専用のエラークラスをきったほうがいいのかな
            throw  new \Exception('user already exists');
        }

        return $this->toDto($this->userRepository->save($user));
    }

    // Note
    // 引数が多い場合、UpdateCommandクラスを作るって方法がある。
    // update(UpdateCommand $command)
    //
    public function update(string $userId, string $name = '', string $email = ''): UserData
    {
        $targetId = new UserId($userId);

        $user = $this->userRepository->findById($targetId);

        if ($user === null) {
            // Q
            throw  new \Exception('user does not exists');
        }

        if ($name !== '') {
            $user->changeName(new UserName($name));
            // TODO nameによるexists
            //if ($this->userService->exists($user)) {
            //    throw  new \Exception('user already exists');
            //}
        }

        if ($email !== '') {
            $user->changeEmail($email);
        }

        // TODO $nameも$emailも空の場合の扱い

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
