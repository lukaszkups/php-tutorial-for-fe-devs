# Types & strict mode

> PHP will happily turn `"2"` into `2` if you let it. I've decided not to let it.

## The one line that matters

Put this at the top of every PHP file you write:

```php
<?php

declare(strict_types=1);
```

It applies **per file**. Call a strict file from a non-strict one and coercions can still sneak in at the boundary - so be consistent.

## Scalar types

```php
<?php

declare(strict_types=1);

function demo(
    int $i,
    float $f,
    string $s,
    bool $b,
): void {
    // ...
}
```

`void` means "returns nothing useful". There's also `never` for functions that always throw or exit.

## Nullable & unions

```php
<?php

declare(strict_types=1);

function findName(?string $id): string|null
{
    if ($id === null) {
        return null;
    }

    return 'Lukasz';
}

// same idea:
function findName2(?string $id): ?string
{
    return $id === null ? null : 'Lukasz';
}
```

Unions (`string|int`) and intersections (`Countable&Traversable`) exist. Keep them readable - if a union grows wild, maybe you want a class or enum.

## Mixed, iterable, object, array

| Type | Meaning |
| --- | --- |
| `mixed` | Anything - escape hatch, use sparingly |
| `array` | PHP array (list or map) |
| `object` | Any object |
| `iterable` | array or Traversable |
| `callable` | Something you can call |

## Return types & properties

```php
<?php

declare(strict_types=1);

class Counter
{
    private int $value = 0;

    public function bump(): int
    {
        return ++$this->value;
    }
}
```

Typed properties are normal now. Uninitialized typed properties throw if you read them too early - good.

## Type juggling without strict_types (why we don't)

```php
<?php

// NO declare(strict_types=1) - bad demo only

function add(int $a, int $b): int
{
    return $a + $b;
}

add(1, '2'); // becomes add(1, 2) - silent coercion
```

With strict types, that's a `TypeError`. Prefer the error.

## Casting when you mean it

```php
<?php

declare(strict_types=1);

$id = (int) '42';
$label = (string) 42;
$flag = (bool) 1;
```

Explicit casts are fine when data comes from HTTP/query strings (everything is a string out there). Validate, then cast.

## instanceof & get_debug_type

```php
<?php

declare(strict_types=1);

function describe(mixed $value): string
{
    if ($value instanceof DateTimeImmutable) {
        return 'datetime';
    }

    return get_debug_type($value);
}
```

`get_debug_type()` is nicer than `gettype()` for error messages.

## Practical rule

- Always `strict_types`
- Type parameters, returns, and properties
- Use `?Type` / unions thoughtfully
- Cast at the HTTP/DB edge, not deep in domain code

Run `examples/types/types.php` once you've got PHP installed - it's a tiny playground for this chapter.

Best,

-- ł.
