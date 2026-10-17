<?php

declare(strict_types=1);

namespace Demo;

final class Greeter
{
    public function hello(string $name): string
    {
        return "Hello, {$name} (from Composer autoload)";
    }
}
