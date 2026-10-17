# Composer

> Composer is npm/pnpm for PHP. `composer.json` + `composer.lock` + `vendor/`. You'll touch it every day.

## Mental map

| npm | Composer |
| --- | --- |
| `package.json` | `composer.json` |
| `package-lock.json` | `composer.lock` |
| `node_modules/` | `vendor/` |
| `npm install` | `composer install` |
| `npm install lodash` | `composer require ...` |
| `npm install -D` | `composer require --dev` |
| `npx` | `vendor/bin/...` |

Packagist ([packagist.org](https://packagist.org)) is the default registry - like npmjs.

## Start a project

```bash
mkdir examples/composer-demo && cd examples/composer-demo
composer init
```

Or hand-write a minimal file (this repo has one ready):

```json
{
  "name": "lukaszkups/composer-demo",
  "type": "project",
  "require": {
    "php": ">=8.3"
  },
  "autoload": {
    "psr-4": {
      "Demo\\": "src/"
    }
  }
}
```

Then:

```bash
composer install
# or after editing composer.json:
composer dump-autoload
```

## Adding packages

```bash
composer require monolog/monolog
composer require --dev phpunit/phpunit
```

Versions use Composer semver (`^3.0`, `~2.1`, constraints). Lockfile pins exact versions for the team - commit `composer.lock` for apps.

## Scripts

```json
{
  "scripts": {
    "test": "phpunit",
    "start": "php -S localhost:8080 -t public"
  }
}
```

```bash
composer test
composer start
```

Similar vibe to npm scripts.

## Autoload kinds

```json
{
  "autoload": {
    "psr-4": { "App\\": "src/" },
    "files": ["src/helpers.php"]
  },
  "autoload-dev": {
    "psr-4": { "Tests\\": "tests/" }
  }
}
```

`files` is for global helper functions - Laravel does this. Use sparingly.

## Platform config

```json
{
  "config": {
    "platform": {
      "php": "8.4.0"
    },
    "sort-packages": true
  }
}
```

Useful when your laptop PHP differs from production. Also: `composer check-platform-reqs`.

## What you actually do day to day

1. `composer require vendor/package`
2. `use Vendor\Package\Thing;`
3. Ship code
4. On CI/server: `composer install --no-dev --optimize-autoloader`

Never commit `vendor/` (usually). Always commit `composer.lock` for applications.

See `examples/composer-demo/` - tiny PSR-4 class + autoload.

Best,

-- ł.
