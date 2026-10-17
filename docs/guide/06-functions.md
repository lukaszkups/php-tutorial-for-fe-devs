# Functions

> Named args, defaults, variadics, arrows, first-class callables - PHP functions grew up.

## Basics

```php
<?php

declare(strict_types=1);

function greet(string $name, string $greeting = 'Hi'): string
{
    return "{$greeting}, {$name}";
}

greet('Lukasz');
greet('Lukasz', 'Hey');
greet(name: 'Lukasz', greeting: 'Yo'); // named args
greet(greeting: 'Yo', name: 'Lukasz'); // order free when named
```

Named arguments are great for boolean flags and optional bags - same reason you like them in TS/Python.

## Variadics

```php
<?php

declare(strict_types=1);

function joinPaths(string ...$parts): string
{
    return implode('/', array_map(
        fn (string $p): string => trim($p, '/'),
        $parts,
    ));
}

joinPaths('app', 'Http', 'Controllers');
```

## Pass by value (default) vs reference

```php
<?php

declare(strict_types=1);

function bump(int &$n): void
{
    $n++;
}

$x = 1;
bump($x); // $x is 2
```

Prefer returning new values over references. References show up in older APIs - know them, don't invent them.

## Arrow functions

```php
<?php

declare(strict_types=1);

$nums = [1, 2, 3];
$doubled = array_map(fn (int $n): int => $n * 2, $nums);
```

Arrow functions (`fn`) auto-capture outer variables by value. Classic closures need `use`:

```php
<?php

declare(strict_types=1);

$factor = 10;
$scale = function (int $n) use ($factor): int {
    return $n * $factor;
};
```

## First-class callables (PHP 8.1+)

```php
<?php

declare(strict_types=1);

$strlen = strlen(...);
$strlen('abc'); // 3

class Util
{
    public static function shout(string $s): string
    {
        return strtoupper($s);
    }
}

$shout = Util::shout(...);
```

That `...` syntax makes a callable from a function/method - cleaner than strings `'strlen'` or `[Util::class, 'shout']`.

## Type the callable

```php
<?php

declare(strict_types=1);

/**
 * @param callable(int): int $mapper
 */
function transform(array $items, callable $mapper): array
{
    return array_map($mapper, $items);
}
```

PHP's runtime `callable` type is loose. PHPDoc (or static analysis with PHPStan/Psalm) tightens it. Frameworks lean on that heavily.

## Early returns > nested soup

```php
<?php

declare(strict_types=1);

function label(?string $name): string
{
    if ($name === null || $name === '') {
        return 'anonymous';
    }

    return $name;
}
```

Same habit as clean JS. PHP doesn't mind.

## Variable functions (exists - be careful)

```php
<?php

$fn = 'strlen';
$fn('hi'); // 2
```

Handy for dispatch tables. Terrifying if `$fn` comes from user input. Never call user-controlled names.

Functions are the connective tissue - next up, making control flow less noisy with `match` and friends.

Best,

-- ł.
