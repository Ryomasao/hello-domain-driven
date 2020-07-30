<?php

namespace App\Domain\Values;

class UserId
{
    protected string $value;

    public function __construct(string $value)
    {
        if ($value === '') {
            throw new \InvalidArgumentException('value is required');
        }

        $this->value = $value;
    }

    public function value()
    {
        return $this->value;
    }
}
