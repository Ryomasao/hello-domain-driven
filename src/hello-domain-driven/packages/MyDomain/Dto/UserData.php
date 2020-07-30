<?php

namespace MyDomain\Dto;

use MyDomain\Entities\User;

class UserData
{
    public string $id;

    public string $name;

    public string $email;

    public function __construct(User $user)
    {
        $this->id = $user->id()->value();

        $this->name = $user->name()->value();

        $this->email = $user->email();
    }
}
