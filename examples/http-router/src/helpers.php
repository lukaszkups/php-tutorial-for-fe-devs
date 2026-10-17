<?php

declare(strict_types=1);

/**
 * @param array<string, mixed> $data
 */
function render(string $view, array $data = []): string
{
    $path = dirname(__DIR__) . '/views/' . $view . '.php';

    if (!is_file($path)) {
        throw new RuntimeException("View [{$view}] not found");
    }

    extract($data, EXTR_SKIP);

    ob_start();
    require $path;

    return (string) ob_get_clean();
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
