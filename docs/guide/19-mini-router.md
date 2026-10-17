# Mini router project

> I've built a tiny front controller + router so "routing" in Laravel/Symfony won't feel magical. It's intentionally small. Homemade self-baked solution 🙂

## What we're building

```bash
examples/http-router/
  public/index.php      # front controller
  src/Router.php
  src/Response.php
  views/home.php
  views/hello.php
  views/not-found.php
```

Routes:

| Method | Path | Result |
| --- | --- | --- |
| GET | `/` | Home HTML |
| GET | `/hello/{name}` | Greeting |
| GET | `/api/ping` | JSON `{ "ok": true }` |

## Run it

```bash
cd examples/http-router
composer install
php -S localhost:8080 -t public public/index.php
```

The last `public/index.php` argument is a **router script** for PHP's built-in server - it sends every request through the front controller (like nginx `try_files`).

Open `http://localhost:8080/`, `/hello/Lukasz`, `/api/ping`.

## Front controller

```php
<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Router;
use App\Response;

$router = new Router();

$router->get('/', function (): Response {
    return Response::html(render('home', ['title' => 'Home']));
});

$router->get('/hello/{name}', function (array $params): Response {
    $name = $params['name'] ?? 'world';
    return Response::html(render('hello', ['name' => $name]));
});

$router->get('/api/ping', function (): Response {
    return Response::json(['ok' => true, 'time' => time()]);
});

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$uri = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($uri, PHP_URL_PATH) ?: '/';

$response = $router->dispatch($method, $path);
$response->send();
```

Comments for the code above:

- All traffic enters one file - frameworks do the same (`public/index.php`)
- Closures return a `Response` - keeps echo/header in one place
- `{name}` is a path param - little brother of Laravel `{user}` / Symfony `{id}`

## Router idea

Match method + path pattern. Convert `/hello/{name}` to a regex, capture params, call the handler.

```php
<?php

// simplified core
$pattern = preg_replace('#\{([a-zA-Z_]+)\}#', '(?P<$1>[^/]+)', $routePath);
$pattern = '#^' . $pattern . '$#';

if (preg_match($pattern, $path, $matches)) {
    // filter string keys → params
}
```

Full code lives in `examples/http-router/src/Router.php` - read it; it's short on purpose.

## Why this matters before frameworks

When you see:

```php
Route::get('/hello/{name}', [HelloController::class, 'show']);
```

or Symfony attributes:

```php
#[Route('/hello/{name}', methods: ['GET'])]
```

…you'll know it's: register pattern → match request → call callable → emit response. The framework adds caching, middleware, DI, named routes, etc. The skeleton is what you just built.

## Stretch goals (optional)

- Add `POST` + a form page
- Add a middleware-ish wrapper (`function (callable $next)`)
- Return 405 when path matches but method doesn't

Don't overbuild it into a framework. Learn the shape, then go use a real one.

Best,

-- ł.
