<?php

declare(strict_types=1);

$dbPath = __DIR__ . '/data.sqlite';

$pdo = new PDO('sqlite:' . $dbPath, options: [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

$pdo->exec(<<<'SQL'
CREATE TABLE IF NOT EXISTS notes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    body TEXT NOT NULL,
    created_at TEXT NOT NULL
)
SQL);

$title = 'First note';
$body = 'Written from examples/pdo-crud/crud.php';
$createdAt = (new DateTimeImmutable('now'))->format(DateTimeInterface::ATOM);

$insert = $pdo->prepare(
    'INSERT INTO notes (title, body, created_at) VALUES (:title, :body, :created_at)'
);
$insert->execute([
    'title' => $title,
    'body' => $body,
    'created_at' => $createdAt,
]);

$id = (int) $pdo->lastInsertId();
echo "Inserted note #{$id}" . PHP_EOL;

$notes = $pdo->query('SELECT id, title, created_at FROM notes ORDER BY id DESC LIMIT 5')
    ->fetchAll();

foreach ($notes as $note) {
    echo "- #{$note['id']} {$note['title']} ({$note['created_at']})" . PHP_EOL;
}
