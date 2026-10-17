# Setup

> Just enough tooling to run scripts, a tiny built-in server, and Composer - no Docker required for learning.

## What you need

- **PHP 8.4+** (8.3 works for almost everything here; I'll call out 8.4-only bits)
- **Composer** (PHP's package manager - think npm/pnpm)
- A terminal
- An editor (VS Code / Cursor / PhpStorm - whatever you already live in)

Check versions:

```bash
php -v
composer -V
```

You want something like `PHP 8.4.x` and Composer 2.x.

## Install notes (high level)

### Linux

Distro packages vary. On Ubuntu/Debian-ish you often need an Ondřej PPA or your distro's 8.4 packages. Alternatively: [php.net downloads](https://www.php.net/downloads) / [phpenv](https://github.com/phpenv/phpenv) / asdf.

Composer: [getcomposer.org](https://getcomposer.org/download/) - the installer script is the usual path.

### macOS

Homebrew is the path of least resistance:

```bash
brew install php composer
```

### Windows

[windows.php.net](https://windows.php.net/download/) or Scoop/Chocolatey. WSL2 with Linux PHP is honestly nicer if you already use it for front-end work.

## Extensions that matter early

When you `php -m`, it's nice to already have:

- `pdo_sqlite` or `pdo_mysql` (we'll use SQLite in examples)
- `mbstring`
- `json` (usually built-in)
- `curl`
- `openssl`

If something is missing later, install the matching package for your OS (`php8.4-sqlite3`, etc.).

## First script

Create `examples/hello/hello.php` (already in this repo):

```php
<?php

declare(strict_types=1);

echo "Hello from PHP " . PHP_VERSION . PHP_EOL;
```

Run it:

```bash
php examples/hello/hello.php
```

Comments for the code above:

- `<?php` opens PHP mode - every PHP file starts with this (or a short echo tag, but we stay classic)
- `declare(strict_types=1);` turns on strict type checking for **this file** - put it at the top of everything you write
- `PHP_EOL` is the platform newline - nicer than hardcoding `\n` when printing to CLI

## Built-in server

PHP ships a tiny development server. From a folder with `index.php`:

```bash
php -S localhost:8080 -t public
```

`-t public` sets the document root. Great for learning HTTP without nginx. Not for production. Obviously.

We'll use this for the [mini router](/guide/19-mini-router) later.

## Editor tips (front-end brain edition)

- Install a PHP language support / Intelephense extension
- Enable format-on-save if you like (PHP CS Fixer / Pint later - not required day one)
- Treat `vendor/` like `node_modules/` - never edit it by hand

## Project layout we'll use

```bash
php-tutorial-2026/
  docs/          # this VitePress site
  examples/      # runnable PHP bits
  package.json   # only for the docs site
```

PHP examples are plain files (or tiny Composer projects). The tutorial site itself is Node/VitePress - ironic, I know 🙂

Once `php examples/hello/hello.php` prints a version string, you're set.

Best,

-- ł.
