# Arrays & strings

> PHP arrays are lists and maps at the same time. Weird at first. Useful forever.

## Lists

```php
<?php

declare(strict_types=1);

$nums = [1, 2, 3];
$nums[] = 4;           // push
array_push($nums, 5);  // also push

$first = $nums[0];
$count = count($nums);
```

Destructuring:

```php
<?php

[$a, $b] = [10, 20];
['name' => $name] = ['name' => 'Lukasz', 'role' => 'dev'];
```

## Associative arrays (maps)

```php
<?php

declare(strict_types=1);

$user = [
    'name' => 'Lukasz',
    'active' => true,
];

$user['name'];
$user['email'] ?? 'missing';  // null coalescing - use this a lot
```

`isset($user['email'])` vs `array_key_exists('email', $user)` - isset is false for `null` values; array_key_exists still sees the key.

## Spread & unpacking

```php
<?php

declare(strict_types=1);

$a = [1, 2];
$b = [...$a, 3, 4];

function sum(int ...$parts): int
{
    return array_sum($parts);
}

sum(...[1, 2, 3]);
```

## Useful array functions

You won't memorize them all. These pay rent early:

```php
<?php

declare(strict_types=1);

$nums = [1, 2, 3, 4];

array_map(fn (int $n): int => $n * 2, $nums);
array_filter($nums, fn (int $n): bool => $n % 2 === 0);
array_reduce($nums, fn (int $acc, int $n): int => $acc + $n, 0);

in_array(2, $nums, true); // strict!
array_key_exists('name', ['name' => 'x']);
array_keys($user);
array_values($user);
array_merge($a, $b);
array_unique($nums);
sort($nums); // sorts in place, returns bool - annoying
$sorted = $nums;
sort($sorted);
```

Comments for the code above:

- Prefer the third arg `true` on `in_array` so `"2"` !== `2`
- `sort` / `asort` mutate - copy first if you care
- `array_map` / `array_filter` feel like JS `.map` / `.filter` - good

## foreach

```php
<?php

declare(strict_types=1);

foreach ($nums as $n) {
    echo $n;
}

foreach ($user as $key => $value) {
    echo "{$key}={$value}\n";
}
```

By-reference mutation (`foreach ($nums as &$n)`) exists - easy to shoot yourself. Prefer `array_map` or building a new array.

## Strings

```php
<?php

declare(strict_types=1);

$name = 'Lukasz';
$hi = "Hello, {$name}";     // interpolates
$raw = 'Hello, {$name}';    // literal braces - no interpolate

strlen($name);              // bytes - careful with UTF-8
mb_strlen($name, 'UTF-8');  // characters - prefer for user text

str_contains($hi, 'Hello');
str_starts_with($hi, 'He');
str_ends_with($hi, 'sz');
str_replace('Hello', 'Hi', $hi);

explode(',', 'a,b,c');
implode('-', ['a', 'b', 'c']);

trim("  x  ");
strtolower('ABC');
sprintf('User #%d: %s', 1, $name);
```

PHP 8 brought `str_contains` / `str_starts_with` / `str_ends_with` - use them instead of `strpos !== false` rituals.

## Heredoc / nowdoc

```php
<?php

declare(strict_types=1);

$html = <<<HTML
<div class="box">{$name}</div>
HTML;

$raw = <<<'SQL'
SELECT * FROM users WHERE name = '{$name}' -- not interpolated
SQL;
```

Heredoc interpolates; nowdoc (quoted label) doesn't. Handy for SQL templates / HTML snippets while learning - later, use real templates / query builders.

## JSON bridge (you'll live here)

```php
<?php

declare(strict_types=1);

$json = json_encode(['ok' => true], JSON_THROW_ON_ERROR);
$data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
// true => associative array (usually what you want from APIs)
```

Always `JSON_THROW_ON_ERROR` so failures aren't silent `null`.

Arrays and strings are like 60% of day-to-day PHP. Get comfy, then move on.

Best,

-- ł.
