<?php

namespace MyDomain\Application\User;

class UserDeleteCommand
{
    public string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}
