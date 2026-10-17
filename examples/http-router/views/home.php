<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= e($title ?? 'Home') ?></title>
  <style>
    body { font-family: system-ui, sans-serif; max-width: 40rem; margin: 3rem auto; line-height: 1.5; }
    a { color: #0b5; }
    code { background: #f4f4f4; padding: 0.1rem 0.35rem; }
  </style>
</head>
<body>
  <h1><?= e($title ?? 'Home') ?></h1>
  <p>Tiny front controller demo from the PHP 2026 tutorial.</p>
  <ul>
    <li><a href="/hello/Lukasz">/hello/Lukasz</a></li>
    <li><a href="/api/ping"><code>/api/ping</code></a></li>
  </ul>
</body>
</html>
