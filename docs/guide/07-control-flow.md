# Control flow

> if/else still works. `match` is the upgrade you actually want.

## if / elseif / else

```php
<?php

declare(strict_types=1);

$role = 'editor';

if ($role === 'admin') {
    echo 'all access';
} elseif ($role === 'editor') {
    echo 'can edit';
} else {
    echo 'read only';
}
```

Ternary and null coalescing:

```php
<?php

$label = $name ?: 'guest';          // loose - careful with '0'
$label = $name ?? 'guest';          // only if null / missing
$label = $name ??= 'guest';         // assign if null
$path  = $config['path'] ?? '/tmp';
```

Prefer `??` over `?:` unless you truly mean "any falsy".

## match (PHP 8+)

```php
<?php

declare(strict_types=1);

$status = 404;

$message = match ($status) {
    200, 201 => 'ok',
    404 => 'not found',
    500 => 'server error',
    default => 'unknown',
};
```

Comments for the code above:

- `match` uses **strict** comparison (`===`)
- It's an **expression** - returns a value (like a switch that grew up)
- No fall-through bugs
- Unhandled value without `default` throws `UnhandledMatchError`

Compared to JS `switch`, this is the one you want for status codes, enums, simple dispatch.

## Nullsafe operator

```php
<?php

declare(strict_types=1);

class Profile
{
    public function __construct(public string $bio) {}
}

class User
{
    public function __construct(public ?Profile $profile) {}
}

$user = new User(null);
$bio = $user?->profile?->bio; // null, no error
```

## Loops

```php
<?php

declare(strict_types=1);

for ($i = 0; $i < 3; $i++) {
    echo $i;
}

$i = 0;
while ($i < 3) {
    $i++;
}

do {
    $i--;
} while ($i > 0);

foreach ([1, 2, 3] as $n) {
    if ($n === 2) {
        continue;
    }
    if ($n === 3) {
        break;
    }
}
```

## Alternative syntax (templates)

You'll see this in older PHP templates / WordPress:

```php
<?php if ($ok): ?>
  <p>Yes</p>
<?php endif; ?>
```

Know it exists. For new learning projects, stick to normal braces or a real template engine later.

## Early return pattern

```php
<?php

declare(strict_types=1);

function httpMessage(int $code): string
{
    if ($code < 100) {
        return 'invalid';
    }

    return match (true) {
        $code < 200 => 'informational',
        $code < 300 => 'success',
        $code < 400 => 'redirect',
        $code < 500 => 'client error',
        default => 'server error',
    };
}
```

`match (true)` is a neat trick for ranged conditions - use sparingly so it stays readable.

That's the language core loop. Next we grow objects.

Best,

-- ł.
