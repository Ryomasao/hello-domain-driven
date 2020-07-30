<?php

namespace MyDomain\Entities;

use MyDomain\Values\UserName;
use MyDomain\Values\UserId;

class User
{
    protected UserName $name;

    protected UserId $id;

    protected string $email;

    public function __construct(UserName $name, string $email, UserId $id = null)
    {
        $this->name = $name;

        if ($id === null) {
            $randomId = \Carbon\Carbon::now()->toDateTimeString();
            $this->id = new UserId($randomId);
        } else {
            $this->id = $id;
        }

        if ($email === '') {
            return new \InvalidArgumentException('email is required.');
        }

        $this->email = $email;
    }

    public function name(): UserName
    {
        return $this->name;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function changeName(UserName $name): void
    {
        $this->name = $name;
    }
}
