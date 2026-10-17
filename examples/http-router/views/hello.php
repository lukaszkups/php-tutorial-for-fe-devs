<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Hello</title>
  <style>
    body { font-family: system-ui, sans-serif; max-width: 40rem; margin: 3rem auto; line-height: 1.5; }
  </style>
</head>
<body>
  <h1>Hello, <?= e((string) ($name ?? 'world')) ?>!</h1>
  <p><a href="/">Back home</a></p>
</body>
</html>
