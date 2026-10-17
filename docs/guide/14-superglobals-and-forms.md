# Superglobals & forms

> Forms are still how a lot of the web talks to PHP. `$_GET` / `$_POST` are the raw inbox - validate before you trust anything.

## The cast of characters

| Superglobal | What it is |
| --- | --- |
| `$_GET` | Query string params |
| `$_POST` | `application/x-www-form-urlencoded` or multipart form fields |
| `$_REQUEST` | Mix of GET/POST/COOKIE - **avoid**, unclear source |
| `$_SERVER` | Request meta (method, URI, headers as `HTTP_*`) |
| `$_COOKIE` | Cookies sent by the browser |
| `$_FILES` | Uploaded files |
| `$_SESSION` | Session data (after `session_start()`) |
| `$_ENV` | Environment variables (depending on config) |

## HTML form → PHP

```html
<form method="post" action="/register">
  <input name="email" type="email" required>
  <input name="password" type="password" required>
  <button type="submit">Register</button>
</form>
```

```php
<?php

declare(strict_types=1);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed');
}

$email = trim((string) ($_POST['email'] ?? ''));
$password = (string) ($_POST['password'] ?? '');

$errors = [];

if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Valid email required';
}

if (strlen($password) < 8) {
    $errors['password'] = 'Min 8 characters';
}

if ($errors !== []) {
    http_response_code(422);
    header('Content-Type: application/json');
    echo json_encode(['errors' => $errors], JSON_THROW_ON_ERROR);
    exit;
}

// ... create user ...
```

Comments for the code above:

- Everything from forms arrives as **strings** (or arrays of strings)
- Cast + trim at the edge
- `filter_var` is ok for email; for richer rules you'll meet validators in frameworks
- Return 422 with errors - same idea as a JSON API

## Nested fields

```html
<input name="user[name]">
<input name="user[email]">
```

```php
<?php

$user = $_POST['user'] ?? [];
$name = is_array($user) ? trim((string) ($user['name'] ?? '')) : '';
```

Always `is_array` check before treating it like an array - users can mess with field names.

## GET for filters, POST for actions

```php
<?php

$page = max(1, (int) ($_GET['page'] ?? 1));
$q    = trim((string) ($_GET['q'] ?? ''));
```

Idempotent reads → GET. State changes → POST (and later: CSRF tokens).

## JSON body APIs

```php
<?php

declare(strict_types=1);

$raw = file_get_contents('php://input');
$data = json_decode($raw ?: '[]', true, 512, JSON_THROW_ON_ERROR);

if (!is_array($data)) {
    throw new InvalidArgumentException('Expected JSON object');
}
```

Don't mix this up with `$_POST` - browsers don't fill `$_POST` for `Content-Type: application/json`.

## Escaping output (preview)

When you echo user data into HTML:

```php
<?php

echo htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
```

More in [Security essentials](/guide/18-security-essentials). Never `echo $_POST['name']` into HTML raw.

Best,

-- ł.
