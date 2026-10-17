# Cheatsheet

> One-pager energy. Keep this tab open.

## File header

```php
<?php

declare(strict_types=1);
```

## Types

```php
function f(int $a, ?string $b = null): string|int {}
public readonly string $slug;
enum Status: string { case Ok = 'ok'; }
```

## Arrays & strings

```php
$list = [1, 2];
$map = ['a' => 1];
$x = $map['b'] ?? 0;
str_contains($s, 'hi');
"Hello {$name}";
json_encode($data, JSON_THROW_ON_ERROR);
json_decode($json, true, 512, JSON_THROW_ON_ERROR);
```

## Control

```php
match ($code) {
    200 => 'ok',
    default => 'other',
};
$user?->profile?->name;
```

## OOP

```php
class User {
    public function __construct(private string $name) {}
}
interface Logger { public function log(string $m): void; }
#[Attribute] class Route { public function __construct(public string $path) {} }
```

## Composer / PSR-4

```json
{ "autoload": { "psr-4": { "App\\": "src/" } } }
```

```bash
composer require vendor/pkg
composer require --dev phpunit/phpunit
composer dump-autoload
composer install
vendor/bin/phpunit
```

```php
require __DIR__ . '/vendor/autoload.php';
use App\Http\Request;
```

## HTTP

```php
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
http_response_code(404);
header('Content-Type: application/json');
echo json_encode($payload, JSON_THROW_ON_ERROR);
```

## Forms / session / CSRF

```php
$email = trim((string) ($_POST['email'] ?? ''));
session_start();
session_regenerate_id(true);
hash_equals($_SESSION['csrf'], $_POST['_token'] ?? '');
echo htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
```

## Passwords

```php
$hash = password_hash($password, PASSWORD_DEFAULT);
password_verify($password, $hash);
```

## PDO

```php
$pdo = new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = :id');
$stmt->execute(['id' => $id]);
$row = $stmt->fetch();
```

## Exceptions

```php
try {
    // ...
} catch (Throwable $e) {
    throw new RuntimeException('boom', previous: $e);
}
```

## Built-in server

```bash
php -S localhost:8080 -t public public/index.php
```

## JS → PHP reminders

| JS | PHP |
| --- | --- |
| `===` | `===` |
| `?.` | `?->` |
| `??` | `??` |
| `import` | `use` + Composer |
| `npm i` | `composer require` |
| `node_modules` | `vendor` |

## Before frameworks - nouns

Router · Front controller · Middleware · DI container · `.env` · Migration · `artisan` / `bin/console` · Eloquent vs Doctrine

---

That's the pocket version. For the why, go back to the chapters.

Best,

-- ł.
