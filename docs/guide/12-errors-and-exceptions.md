# Errors & exceptions

> PHP used to be notices-and-warnings chaos. Modern PHP: throw exceptions, catch what you can handle, let the rest bubble to a front controller.

## Error vs Exception (short version)

- **`Error`** (and subclasses like `TypeError`) - serious runtime problems; often programmer mistakes
- **`Exception`** - recoverable / expected failure modes you might catch
- Both implement `Throwable`

```php
<?php

declare(strict_types=1);

try {
    mightFail();
} catch (InvalidArgumentException $e) {
    // known, handle
} catch (Throwable $e) {
    // last resort - log and rethrow or show 500
    throw $e;
} finally {
    // always runs
}
```

## Throwing

```php
<?php

declare(strict_types=1);

function divide(float $a, float $b): float
{
    if ($b === 0.0) {
        throw new InvalidArgumentException('Division by zero');
    }

    return $a / $b;
}
```

Create domain exceptions when it helps:

```php
<?php

declare(strict_types=1);

class UserNotFoundException extends RuntimeException {}

function findUser(string $id): User
{
    throw new UserNotFoundException("User {$id} not found");
}
```

## Multi-catch & unused variables

```php
<?php

try {
    // ...
} catch (JsonException | InvalidArgumentException $e) {
    // handle either
}
```

## Exception from previous (chaining)

```php
<?php

try {
    json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
} catch (JsonException $e) {
    throw new RuntimeException('Invalid payload', previous: $e);
}
```

Keeps the original stack for logs. Nice.

## Error reporting in dev

```php
<?php

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1'); // never in production
```

In production: log to file/stderr, display a generic 500 page. Frameworks wire this for you - know the dials exist.

## Assertions (dev aid)

```php
<?php

assert($user instanceof User);
```

Useful locally; don't rely on asserts for production validation (they can be disabled).

## Practical habits

- Validate at the edge → throw specific exceptions
- Catch near a boundary (HTTP kernel, CLI command) to translate into status codes
- Don't swallow exceptions with empty `catch`
- Log with context (`$e->getMessage()`, `$e->getTraceAsString()`, previous)

Frameworks have exception listeners / handlers - same idea, more structure.

You've got language + structure. Next: the web - requests, forms, sessions, SQL, security.

Best,

-- ł.
