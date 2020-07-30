<?php

namespace App\Domain\Values;

class UserName
{
    protected string $value;

    public function __construct(string $value)
    {
        if ($value === '') {
            throw new \InvalidArgumentException('value is required');
        }

        if (strlen($value) < 3) {
            throw new \InvalidArgumentException('value length is more than 3 characters');
        }

        $this->value = $value;
    }

    public function value()
    {
        return $this->value;
    }
}
