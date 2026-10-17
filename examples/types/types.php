<?php

declare(strict_types=1);

function add(int $a, int $b): int
{
    return $a + $b;
}

function label(?string $name): string
{
    return $name ?? 'anonymous';
}

function describe(int|string $id): string
{
    return match (true) {
        is_int($id) => "int:#{$id}",
        default => "str:{$id}",
    };
}

echo add(2, 3) . PHP_EOL;
echo label(null) . PHP_EOL;
echo describe(42) . PHP_EOL;
echo describe('abc') . PHP_EOL;

// Uncomment to see TypeError with strict_types:
// echo add(1, '2');
