# JS → PHP map

> As you might have noticed, half of learning a language is just renaming the furniture. Here's the furniture map.

## Variables

```js
const name = 'Lukasz'
let count = 0
```

```php
<?php

declare(strict_types=1);

$name = 'Lukasz';
$count = 0;
```

Comments for the code above:

- PHP variables always start with `$`
- There's no `const`/`let`/`var` for locals - assignment creates/updates
- Real constants exist (`const FOO = 1;` or `define(...)`) but they're different from JS `const`
- Semicolons are required. Yes, really.

## Types (loose by default, strict when you ask)

JS is dynamically typed. PHP is too - **unless** you turn on strict types and annotate parameters/returns.

```php
<?php

declare(strict_types=1);

function add(int $a, int $b): int
{
    return $a + $b;
}

add(1, 2);     // OK
// add(1, '2'); // TypeError with strict_types
```

Without `strict_types`, PHP loves to coerce (`'2'` becomes `2`). Don't live without strict mode. You've met TypeScript for a reason.

## Equality

| JS | PHP | Notes |
| --- | --- | --- |
| `===` | `===` | Same - prefer this |
| `==` | `==` | Loose equality / coercion - avoid |
| `!==` | `!==` | Same idea |

Truthiness differs in details (`'0'` is truthy in PHP… wait until it bites you). Prefer explicit checks.

## Arrays vs objects

In JS you have arrays and plain objects. In PHP, **arrays do both jobs**:

```php
<?php

$list = [1, 2, 3];                    // list (0-indexed)
$map  = ['name' => 'Lukasz', 'ok' => true]; // associative

echo $list[0];
echo $map['name'];
```

Actual objects are class instances (`new Foo()`). JSON objects often become associative arrays when decoded - watch for that.

## Functions & arrow functions

```js
const double = (n) => n * 2
```

```php
<?php

$double = fn (int $n): int => $n * 2;
```

Named functions look more like classic JS:

```php
<?php

function greet(string $name): string
{
    return "Hi, {$name}";
}
```

String interpolation uses `"Hi, {$name}"` - single quotes do **not** interpolate.

## Modules → files + Composer

JS:

```js
import { foo } from './foo.js'
```

PHP historically:

```php
<?php

require_once __DIR__ . '/foo.php';
```

Modern PHP:

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use App\Foo;
```

Composer + PSR-4 replaces your import map. We'll cover that properly in [Namespaces & PSR-4](/guide/10-namespaces-and-psr4) and [Composer](/guide/11-composer).

## Async

There is no `await` in everyday PHP web code. A request runs top to bottom. Fibers / async libraries exist, but Laravel/Symfony apps you meet first are mostly synchronous request handlers. That's fine - lean into the request lifecycle instead of forcing Node patterns.

## Null & optional chaining

```js
user?.profile?.name
```

```php
<?php

$user?->profile?->name;
```

Same idea. Introduced in PHP 8.0. Use it.

## Classes (quick peek)

```ts
class User {
  constructor(public name: string) {}
}
```

```php
<?php

class User
{
    public function __construct(
        public string $name,
    ) {}
}
```

Constructor property promotion - very TS-constructor vibes. More in [Modern PHP OOP](/guide/09-modern-php-oop).

## Cheat table

| Concept | JS/TS | PHP |
| --- | --- | --- |
| Package manager | npm / pnpm | Composer |
| Lockfile | package-lock.json | composer.lock |
| Dependencies folder | node_modules | vendor |
| Entry | index.js | index.php / public/index.php |
| Env | process.env / .env | $_ENV / getenv / vlucas/phpdotenv |
| JSON | JSON.parse | json_decode(..., true) |
| Template literals | `` `Hi ${name}` `` | `"Hi {$name}"` |
| Export | export | namespace + class/function |
| this | this | $this |

If something feels weird, ask: "is this a request-lifecycle thing, or a syntax thing?" Usually it's one of those two.

Best,

-- ł.
