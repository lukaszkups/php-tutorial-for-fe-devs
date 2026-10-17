<?php

declare(strict_types=1);

class User
{
    public function __construct(
        private string $name,
        private string $email,
    ) {}

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function introduce(): string
    {
        return "{$this->name} <{$this->email}>";
    }
}
