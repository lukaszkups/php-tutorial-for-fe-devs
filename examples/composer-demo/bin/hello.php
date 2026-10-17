<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Demo\Greeter;

$greeter = new Greeter();
echo $greeter->hello('Lukasz') . PHP_EOL;
