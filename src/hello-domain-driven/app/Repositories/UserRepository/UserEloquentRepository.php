<?php

namespace App\Repositories\UserRepository;

use App\Domain\Entities\User;
use App\Domain\Values\UserName;
use App\Domain\Values\UserId;
use App\Models\Eloquent\User as EloquentUser;

class UserEloquentRepository implements IUserRepository
{
    public function save(User $user): void
    {
        EloquentUser::updateOrCreate(
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

    public function findById(UserId $userId): ?User
    {
        $target = EloquentUser::find($userId->value());

        if ($target === null) {
            return null;
        }

        return $this->toModel($target);
    }

    public function delete(User $user): void
    {
        EloquentUser::where('user_id', $user->id()->value())->delete();
    }

    private function toModel(UserEloquent $from)
    {
        return new User(new UserName($from->name), $from->email);
    }
}
