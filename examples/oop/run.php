<?php

declare(strict_types=1);

require __DIR__ . '/User.php';

$user = new User('Lukasz', 'hi@example.com');
echo $user->introduce() . PHP_EOL;
