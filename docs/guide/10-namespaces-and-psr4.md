# Namespaces & PSR-4

> Namespaces are folders for class names. PSR-4 is the agreement that maps those names to real files. Composer makes it automatic - like a nicer import map.

## Why namespaces

Without them, every class is global. Two packages both shipping `Router` = pain.

```php
<?php

declare(strict_types=1);

namespace App\Http;

class Request
{
    // full name: App\Http\Request
}
```

## use statements

```php
<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Services\UserService;
use function App\Support\str_slug;
use const App\Config\APP_NAME;

class UserController
{
    public function __construct(private UserService $users) {}

    public function show(Request $request): Response
    {
        // ...
    }
}
```

Alias collisions:

```php
<?php

use App\Models\User as UserModel;
use Vendor\Auth\User as AuthUser;
```

## PSR-4 mapping (the important bit)

In `composer.json`:

```json
{
  "autoload": {
    "psr-4": {
      "App\\": "src/"
    }
  }
}
```

Meaning:

| Class | File |
| --- | --- |
| `App\Http\Request` | `src/Http/Request.php` |
| `App\Services\UserService` | `src/Services/UserService.php` |

Rules of thumb:

- Namespace segment ↔ directory segment
- Class name ↔ file name (case-sensitive on Linux!)
- One public class per file (convention; do it)

After changing autoload config:

```bash
composer dump-autoload
```

## How a request finds your class

```mermaid
flowchart LR
  code["new App\\Http\\Request"] --> autoload["vendor/autoload.php"]
  autoload --> psr4["PSR-4 map App\\ → src/"]
  psr4 --> file["src/Http/Request.php"]
  file --> instance["object in memory"]
```

Every entry script starts with:

```php
<?php

require __DIR__ . '/vendor/autoload.php';
```

Then you `use` / `new` freely. No manual requires for your app classes.

## Global namespace & leading slash

```php
<?php

namespace App;

$dt = new \DateTimeImmutable(); // leading \ = from global namespace
```

Inside a namespace, unqualified `DateTimeImmutable` looks for `App\DateTimeImmutable`. The leading `\` or a `use DateTimeImmutable;` fixes it.

## Folder shape that transfers to Laravel/Symfony

```bash
src/
  Http/
    Controllers/
    Middleware/
  Models/          # or Domain/, Entity/ in Symfony
  Services/
  Support/
public/
  index.php        # front controller - requires autoload
```

Frameworks rearrange names (`app/` in Laravel, `src/` in Symfony) but the PSR-4 idea is identical.

Once namespaces click, Composer is just "npm for this mapping + packages".

Best,

-- ł.
