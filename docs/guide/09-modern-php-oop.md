# Modern PHP OOP

> This is the stuff that makes 2026 PHP feel less like 2009 PHP. Readonly, enums, attributes, promoted props - use them.

## Constructor promotion (again, because it's everywhere)

```php
<?php

declare(strict_types=1);

class Article
{
    public function __construct(
        public private(set) string $title, // PHP 8.4 asymmetric visibility
        public readonly string $slug,
        private array $tags = [],
    ) {}
}
```

OK - asymmetric `private(set)` is PHP **8.4**. If you're on 8.3:

```php
<?php

declare(strict_types=1);

class Article
{
    public function __construct(
        private string $title,
        public readonly string $slug,
        private array $tags = [],
    ) {}

    public function title(): string
    {
        return $this->title;
    }
}
```

Either way: promote properties in the constructor. Stop writing duplicate assignments.

## Readonly classes (PHP 8.2+)

```php
<?php

declare(strict_types=1);

readonly class Point
{
    public function __construct(
        public int $x,
        public int $y,
    ) {}
}
```

All props become readonly. Great for DTOs / value objects.

## Enums

```php
<?php

declare(strict_types=1);

enum Status: string
{
    case Draft = 'draft';
    case Published = 'published';
    case Archived = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Published => 'Live',
            self::Archived => 'Archived',
        };
    }
}

$status = Status::Published;
$status->value;  // 'published'
$status->label();
Status::from('draft');
Status::tryFrom('nope'); // null
```

Backed enums (`: string` / `: int`) map cleanly to DB columns and JSON. Prefer enums over magic strings.

## Attributes (annotations that aren't docblocks)

```php
<?php

declare(strict_types=1);

#[Attribute(Attribute::TARGET_METHOD)]
class Route
{
    public function __construct(
        public string $path,
        public string $method = 'GET',
    ) {}
}

class PostsController
{
    #[Route('/posts', method: 'GET')]
    public function index(): void {}
}
```

Symfony and Laravel use attributes for routing, validation, ORM mapping, etc. Reflection reads them at boot. You don't need to invent a framework - just recognize `#[...]` when you see it.

## Traits

```php
<?php

declare(strict_types=1);

trait Timestampable
{
    private ?DateTimeImmutable $createdAt = null;

    public function touch(): void
    {
        $this->createdAt ??= new DateTimeImmutable();
    }
}

class Post
{
    use Timestampable;
}
```

Traits are copy-paste with a blessing - horizontal reuse. Useful; easy to overuse. Prefer composition when the shared behavior needs its own state/services.

## Interfaces you should know by name

- `Stringable` - `__toString()`
- `IteratorAggregate` / `Traversable` - foreach-able objects
- `JsonSerializable` - `json_encode` hooks
- `Countable` - `count($obj)`

```php
<?php

declare(strict_types=1);

class Collection implements Countable, JsonSerializable
{
    public function __construct(private array $items) {}

    public function count(): int
    {
        return count($this->items);
    }

    public function jsonSerialize(): array
    {
        return $this->items;
    }
}
```

## Anonymous classes

```php
<?php

declare(strict_types=1);

$logger = new class implements Logger {
    public function log(string $message): void
    {
        echo $message;
    }
};
```

Handy in tests. Don't build your architecture out of them.

Modern OOP + types is the language surface Laravel/Symfony docs assume. Next: how files become classes without a hundred `require`s.

Best,

-- ł.
