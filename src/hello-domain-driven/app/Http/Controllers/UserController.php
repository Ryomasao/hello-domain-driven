<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Domain\Entities\User;
use App\Domain\Values\UserName;
use App\Domain\Services\UserService;
use App\Models\Eloquent\User as EloquentUser;

class UserController extends Controller
{
    public function store()
    {
        $this->createUser(request()->name, request()->email);
    }

    private function createUser(string $name, string $email)
    {
        $user = new User(new UserName($name), $email);
        $userService = new UserService;
        if ($userService->exists($user)) {
            throw new \Exception('User already exists.');
        }

        EloquentUser::create([
            'user_id' => $user->id()->value(),
            'name' => $user->name()->value(),
            // VOじゃない値かどうかを意識する必要あるのがちょっと微妙
            'email' => $user->email()
        ]);
    }
}
