<?php

namespace MyDomain\Repositories\UserRepository;

use MyDomain\Entities\User;
use MyDomain\Values\UserName;
use MyDomain\Values\UserId;
use App\Models\Eloquent\User as EloquentUser;

class UserEloquentRepository implements IUserRepository
{
    public function save(User $user): User
    {
        $user = EloquentUser::updateOrCreate(
            [
                'user_id' => $user->id()->value(),
            ],
            [
                'user_id' => $user->id()->value(),
                'name' => $user->name()->value(),
                'email' => $user->email(),
            ]
        );

        return $this->toModel($user);
    }

    public function findById(UserId $userId): ?User
    {
        $target = EloquentUser::find($userId->value());

        if ($target === null) {
            return null;
        }

        return $this->toModel($target);
    }

    public function findByEmail(string $email): ?User
    {
        $target = EloquentUser::where(['email' => $email])->get();

        if ($target === null) {
            return null;
        }

        return $this->toModel($target);
    }

    public function delete(User $user): void
    {
        EloquentUser::where('user_id', $user->id()->value())->delete();
    }

    private function toModel(EloquentUser $from): User
    {
        return new User(
            new UserName($from->name),
            $from->email,
            $from->user_id ? new UserId($from->user_id) : null
        );
    }
}
