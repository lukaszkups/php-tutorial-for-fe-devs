<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Response;
use App\Router;

$router = new Router();

$router->get('/', function (): Response {
    return Response::html(render('home', [
        'title' => 'Mini router',
    ]));
});

$router->get('/hello/{name}', function (array $params): Response {
    return Response::html(render('hello', [
        'name' => $params['name'] ?? 'world',
    ]));
});

$router->get('/api/ping', function (): Response {
    return Response::json([
        'ok' => true,
        'time' => time(),
    ]);
});

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$uri = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($uri, PHP_URL_PATH) ?: '/';

// Built-in server: serve existing files directly
if (PHP_SAPI === 'cli-server') {
    $file = __DIR__ . $path;
    if ($path !== '/' && is_file($file)) {
        return false;
    }
}

$response = $router->dispatch($method, $path);

if ($response->status() === 404) {
    $response = Response::html(render('not-found', ['path' => $path]), 404);
}

$response->send();
