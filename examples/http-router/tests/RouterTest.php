<?php

declare(strict_types=1);

namespace Tests;

use App\Response;
use App\Router;
use PHPUnit\Framework\TestCase;

final class RouterTest extends TestCase
{
    public function test_ping_returns_json(): void
    {
        $router = new Router();
        $router->get('/api/ping', fn (): Response => Response::json(['ok' => true]));

        $response = $router->dispatch('GET', '/api/ping');

        $this->assertSame(200, $response->status());
        $this->assertStringContainsString(
            'application/json',
            $response->headers()['Content-Type'] ?? '',
        );
        $this->assertStringContainsString('"ok":true', $response->body());
    }

    public function test_path_params(): void
    {
        $router = new Router();
        $router->get('/hello/{name}', function (array $params): Response {
            return Response::html('Hi ' . ($params['name'] ?? ''));
        });

        $response = $router->dispatch('GET', '/hello/Lukasz');

        $this->assertSame(200, $response->status());
        $this->assertSame('Hi Lukasz', $response->body());
    }

    public function test_not_found(): void
    {
        $router = new Router();
        $response = $router->dispatch('GET', '/missing');

        $this->assertSame(404, $response->status());
    }
}
