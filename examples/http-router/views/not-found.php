<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>404</title>
  <style>
    body { font-family: system-ui, sans-serif; max-width: 40rem; margin: 3rem auto; line-height: 1.5; }
  </style>
</head>
<body>
  <h1>404</h1>
  <p>No route for <code><?= e((string) ($path ?? '')) ?></code>.</p>
  <p><a href="/">Home</a></p>
</body>
</html>
