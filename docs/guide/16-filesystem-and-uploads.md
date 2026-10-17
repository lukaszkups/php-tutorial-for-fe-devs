# Filesystem & uploads

> Paths, reading/writing files, and the careful art of accepting uploads without deleting your server.

## Paths

```php
<?php

declare(strict_types=1);

$dir = __DIR__;                          // this file's directory
$root = dirname(__DIR__);                // parent
$path = $root . '/storage/notes.txt';

// better joins:
$path = $root . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'notes.txt';
```

Prefer absolute paths from `__DIR__`. Relative paths depend on the current working directory - CLI vs web can differ. Annoying.

## Read / write

```php
<?php

declare(strict_types=1);

$contents = file_get_contents($path);
file_put_contents($path, "hello\n", FILE_APPEND | LOCK_EX);

$lines = file($path, FILE_IGNORE_NEW_LINES);

if (!is_dir($dir) && !mkdir($dir, 0775, true) && !is_dir($dir)) {
    throw new RuntimeException("Cannot create {$dir}");
}
```

`file_put_contents` with `LOCK_EX` is fine for small learning projects. Bigger systems use proper storage abstractions (Flysystem in Laravel, etc.).

## SplFileObject / streams (peek)

```php
<?php

declare(strict_types=1);

$fh = fopen($path, 'rb');
while ($line = fgets($fh)) {
    // ...
}
fclose($fh);
```

Or `new SplFileObject($path)`. Streams also wrap `php://input`, sockets, etc.

## Uploads (`$_FILES`)

HTML:

```html
<form method="post" enctype="multipart/form-data" action="/upload">
  <input type="file" name="avatar" accept="image/*">
  <button type="submit">Upload</button>
</form>
```

PHP:

```php
<?php

declare(strict_types=1);

$file = $_FILES['avatar'] ?? null;

if (!is_array($file) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
    http_response_code(400);
    exit('Upload failed');
}

if ($file['size'] > 2 * 1024 * 1024) {
    exit('Too large');
}

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($file['tmp_name']);
$allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];

if (!isset($allowed[$mime])) {
    exit('Invalid type');
}

$name = bin2hex(random_bytes(16)) . '.' . $allowed[$mime];
$dest = __DIR__ . '/../../storage/uploads/' . $name;

if (!is_uploaded_file($file['tmp_name'])) {
    exit('Suspicious upload');
}

if (!move_uploaded_file($file['tmp_name'], $dest)) {
    exit('Could not save');
}
```

Comments for the code above:

- Always check `error` and `is_uploaded_file`
- Don't trust the client filename or `type` field - sniff MIME, map to extension yourself
- Generate your own storage name
- Store **outside** the public docroot when you can; serve via a controlled route

## Dangerous patterns

- Using `$file['name']` directly in a path
- Allowing `.php` uploads into a web-accessible folder
- Not capping size (`post_max_size` / `upload_max_filesize` in php.ini)

Frameworks give you validation rules (`image|max:2048`). The checklist above is what those rules encode.

Best,

-- ł.
