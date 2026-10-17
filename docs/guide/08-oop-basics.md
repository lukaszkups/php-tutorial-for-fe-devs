# OOP basics

> Classes in PHP feel familiar if you've done TS classes. Visibility and `$this` are the main "oh right" moments.

## A simple class

```php
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
}

$user = new User('Lukasz', 'hi@example.com');
echo $user->name();
```

Comments for the code above:

- `private` / `protected` / `public` on constructor args = property promotion (PHP 8+)
- Methods use `$this->prop` - the `$` stays on `this`, not on the property name after `->`
- `new` is required - no implicit construct like some languages

## Visibility

| Keyword | Who can access |
| --- | --- |
| `public` | Everywhere |
| `protected` | Class + subclasses |
| `private` | Only this class |

Same story as TS `private`/`protected` - enforce it; don't make everything public "for convenience".

## Inheritance

```php
<?php

declare(strict_types=1);

class Animal
{
    public function __construct(protected string $name) {}

    public function speak(): string
    {
        return '...';
    }
}

class Dog extends Animal
{
    public function speak(): string
    {
        return 'woof';
    }
}
```

Prefer **composition** when you're not in a clear is-a relationship. Frameworks use inheritance for base Controllers / Models - that's fine; your domain code doesn't have to mirror that.

## Abstract classes & interfaces

```php
<?php

declare(strict_types=1);

interface Logger
{
    public function log(string $message): void;
}

abstract class Formatter
{
    abstract public function format(string $message): string;

    public function wrap(string $message): string
    {
        return '[' . $this->format($message) . ']';
    }
}

class EchoLogger implements Logger
{
    public function log(string $message): void
    {
        echo $message . PHP_EOL;
    }
}
```

Interfaces = contracts. Abstract classes = partial implementations. You'll see both a lot in Symfony (lots of interfaces) and Laravel (mix of both + facades - later).

## static

```php
<?php

declare(strict_types=1);

class Id
{
    private static int $seq = 0;

    public static function next(): int
    {
        return ++self::$seq;
    }
}

Id::next();
```

`self::` vs `static::` (late static binding) - know `self` first; meet `static` when inheritance + static gets weird.

## readonly intro

```php
<?php

declare(strict_types=1);

class Money
{
    public function __construct(
        public readonly int $cents,
        public readonly string $currency,
    ) {}
}
```

Set once in the constructor, immutable after. More immutability patterns in the next chapter.

## Autoloading teaser

Without Composer, you'd `require` every file. With Composer PSR-4, `new App\User` loads `src/User.php` automatically. That's [Namespaces & PSR-4](/guide/10-namespaces-and-psr4).

See `examples/oop/` for a tiny class you can run from the CLI.

Best,

-- ł.
