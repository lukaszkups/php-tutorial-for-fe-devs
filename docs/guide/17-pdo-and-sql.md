# PDO & SQL

> PDO is the standard database API in PHP. Prepared statements aren't optional. SQLite is perfect for learning - no server to babysit.

## Connect

```php
<?php

declare(strict_types=1);

$pdo = new PDO(
    'sqlite:' . __DIR__ . '/../../examples/pdo-crud/data.sqlite',
    options: [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ],
);
```

Comments for the code above:

- `ERRMODE_EXCEPTION` - failures throw; good
- `FETCH_ASSOC` - rows as associative arrays (comfortable if you think in JSON objects)
- MySQL DSN looks like `mysql:host=127.0.0.1;dbname=app;charset=utf8mb4`

## Schema (SQLite)

```php
<?php

$pdo->exec(<<<'SQL'
CREATE TABLE IF NOT EXISTS notes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    body TEXT NOT NULL,
    created_at TEXT NOT NULL
)
SQL);
```

## Insert (prepared)

```php
<?php

declare(strict_types=1);

$stmt = $pdo->prepare(
    'INSERT INTO notes (title, body, created_at) VALUES (:title, :body, :created_at)'
);

$stmt->execute([
    'title' => $title,
    'body' => $body,
    'created_at' => (new DateTimeImmutable('now'))->format(DateTimeInterface::ATOM),
]);

$id = (int) $pdo->lastInsertId();
```

**Never** concatenate user input into SQL:

```php
<?php

// NOPE
$pdo->query("SELECT * FROM notes WHERE title = '{$title}'");
```

That's SQL injection with extra steps.

## Select

```php
<?php

declare(strict_types=1);

$stmt = $pdo->prepare('SELECT id, title, body, created_at FROM notes WHERE id = :id');
$stmt->execute(['id' => $id]);
$note = $stmt->fetch();

if ($note === false) {
    // not found
}

$stmt = $pdo->query('SELECT id, title FROM notes ORDER BY id DESC');
$notes = $stmt->fetchAll();
```

## Update / delete

```php
<?php

$pdo->prepare('UPDATE notes SET title = :title, body = :body WHERE id = :id')
    ->execute(['title' => $title, 'body' => $body, 'id' => $id]);

$pdo->prepare('DELETE FROM notes WHERE id = :id')
    ->execute(['id' => $id]);
```

## Transactions

```php
<?php

declare(strict_types=1);

try {
    $pdo->beginTransaction();
    // multiple statements...
    $pdo->commit();
} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    throw $e;
}
```

Use transactions when multiple writes must succeed together.

## Fetch styles

| Mode | Shape |
| --- | --- |
| `FETCH_ASSOC` | `['id' => 1, 'title' => '...']` |
| `FETCH_OBJ` | `stdClass` with properties |
| `FETCH_CLASS` | hydrate into a class |

ORMs (Eloquent, Doctrine) sit on top of this world. Knowing PDO means you can still drop to SQL when the ORM gets weird - and you understand what "prepared" means in docs.

## Run the example

```bash
php examples/pdo-crud/crud.php
```

Creates a SQLite file, inserts a note, lists notes. See `examples/pdo-crud/`.

Best,

-- ł.
