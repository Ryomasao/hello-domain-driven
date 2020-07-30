<?php

namespace App\Domain\Entities;

use App\Domain\Values\UserName;
use App\Domain\Values\UserId;

class User
{
    protected UserName $name;

    protected UserId $id;

    protected string $email;

    public function __construct(UserName $name, string $email)
    {
        $this->name = $name;

        $randomId = \Carbon\Carbon::now()->toDateTimeString();
        $this->id = new UserId($randomId);

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
}
