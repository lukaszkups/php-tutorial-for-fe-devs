# Testing intro

> Front-end folks already know Jest/Vitest. PHP's defaults are PHPUnit (classic) and Pest (nicer syntax on top of PHPUnit). One feature test on the router is enough to get the idea.

## PHPUnit vs Pest

| | PHPUnit | Pest |
| --- | --- | --- |
| Style | Classes + `$this->assertSame` | `it('...', function () { expect(...) })` |
| Base | Itself | PHPUnit under the hood |
| Laravel | Built-in support | Very popular |
| Symfony | Common | Also fine |

Either is fine. Pest feels closer to Vitest/Jest. PHPUnit shows up everywhere in older codebases.

## What to test first

For our mini router: given a method + path, do we get the right status and body fragment?

```php
<?php

declare(strict_types=1);

use App\Router;
use App\Response;
use PHPUnit\Framework\TestCase;

final class RouterTest extends TestCase
{
    public function test_ping_returns_json(): void
    {
        $router = new Router();
        $router->get('/api/ping', fn (): Response => Response::json(['ok' => true]));

        $response = $router->dispatch('GET', '/api/ping');

        $this->assertSame(200, $response->status());
        $this->assertStringContainsString('application/json', $response->headers()['Content-Type'] ?? '');
        $this->assertStringContainsString('"ok":true', $response->body());
    }
}
```

Pest flavor of the same idea:

```php
<?php

it('pings', function () {
    $router = new Router();
    $router->get('/api/ping', fn () => Response::json(['ok' => true]));

    $response = $router->dispatch('GET', '/api/ping');

    expect($response->status())->toBe(200)
        ->and($response->body())->toContain('"ok":true');
});
```

## Run the example tests

```bash
cd examples/http-router
composer install
composer test
```

That wires PHPUnit via Composer's `require-dev` and a tiny test suite.

## Testing pyramid (PHP web)

1. **Unit** - pure functions, value objects, routers
2. **Feature / Integration** - HTTP kernel in-process (Laravel `get('/...')`, Symfony `BrowserKit`)
3. **Browser** - Playwright/Dusk - same as front-end E2E

You already know layer 3. Frameworks make layer 2 pleasant. Layer 1 works with plain PHPUnit today.

## Habits that transfer

- Arrange / Act / Assert
- Deterministic tests (no real network / clock when avoidable)
- Test behavior at boundaries (router, parser, money math)
- Don't test the framework itself - test **your** wiring

When Laravel docs say `php artisan test` or Symfony says `php bin/phpunit`, it's this same muscle.

Best,

-- ł.
