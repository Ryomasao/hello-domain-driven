<?php

namespace App\Repositories\UserRepository;

use App\Domain\Entities\User;
use App\Domain\Values\UserName;
use App\Domain\Values\UserId;
use App\Models\Eloquent\User as UserEloquent;

class UserEloquentRepository implements IUserRepository
{
    public function save(User $user): void
    {
        UserEloquent::updateOrCreate(
            [
                'user_id' => $user->id()->value(),
            ],
            [
                'user_id' => $user->id()->value(),
                'name' => $user->name()->value(),
                'email' => $user->email(),
            ]
        );
    }

    public function find(UserId $userId): ?User
    {
        $target = UserEloquent::find($userId->value());

        if ($target === null) {
            return null;
        }

        return $this->toModel($target);
    }

    private function toModel(UserEloquent $from)
    {
        return new User(new UserName($from->name), $from->email);
    }
}
