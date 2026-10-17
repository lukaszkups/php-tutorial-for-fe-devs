# Security essentials

> A short checklist that prevents the classic own-goals. Frameworks help - they don't replace thinking.

## XSS (Cross-Site Scripting)

User data in HTML must be escaped:

```php
<?php

declare(strict_types=1);

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

echo '<p>Hello, ' . e($name) . '</p>';
```

For attributes, same function. For JS contexts / URLs, different rules - prefer not to interpolate untrusted data into `<script>` at all.

Twig / Blade auto-escape by default. Raw PHP does not. Echo carefully.

## SQL injection

Prepared statements. Always. See [PDO & SQL](/guide/17-pdo-and-sql).

```php
<?php

$stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
$stmt->execute(['email' => $email]);
```

## CSRF

Any state-changing request that relies on cookies needs a CSRF token. See [Sessions & cookies](/guide/15-sessions-and-cookies).

SameSite cookies help; tokens still matter for many setups.

## Passwords

```php
<?php

declare(strict_types=1);

$hash = password_hash($password, PASSWORD_DEFAULT);
// store $hash in DB

if (!password_verify($password, $hash)) {
    throw new RuntimeException('Invalid credentials');
}

if (password_needs_rehash($hash, PASSWORD_DEFAULT)) {
    // update stored hash
}
```

Never invent hashing with `md5` / `sha1`. `PASSWORD_DEFAULT` tracks modern algos (bcrypt / argon2 depending on PHP build).

## Secrets & env

```bash
# .env (never commit)
DB_PASSWORD=super-secret
```

```php
<?php

$password = $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD') ?: '';
```

In real apps: `vlucas/phpdotenv` or framework env loaders. Keep secrets out of the repo. `.gitignore` your `.env`.

## Headers worth sending

```php
<?php

header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Referrer-Policy: no-referrer-when-downgrade');
// Content-Security-Policy - learn it when you ship HTML apps
```

## File uploads

Re-read [Filesystem & uploads](/guide/16-filesystem-and-uploads). Random names, MIME sniff, size limits, no executable extensions in public dirs.

## Auth session hygiene

- `session_regenerate_id(true)` on login
- httpOnly + Secure + SameSite on session cookie
- Invalidate session on logout
- Don't put sensitive data in JWT localStorage if you can avoid it (separate debate - for classic PHP, sessions win)

## Mass assignment mindset

Even without an ORM: only pull the fields you expect from `$_POST`:

```php
<?php

$data = [
    'title' => trim((string) ($_POST['title'] ?? '')),
    'body' => trim((string) ($_POST['body'] ?? '')),
];
// never: foreach ($_POST as ...) into DB columns blindly
```

Eloquent's `$fillable` exists because this class of bug is forever.

## Dependency vigilance

```bash
composer audit
```

Same idea as `npm audit`. Keep PHP and extensions updated.

Security isn't a chapter you "finish". It's a habit you carry into Laravel/Symfony - where the tools are nicer, but the threats are identical.

Best,

-- ł.
