# PHP in 2026

A VitePress tutorial for front-end developers who want to learn modern PHP (8.4+) before diving into Laravel or Symfony.

Written in the same note-taking style as [lukaszkups.net/notes](https://lukaszkups.net/notes/).

## Run the docs

```bash
npm install
npm run docs:dev
```

Build / preview:

```bash
npm run docs:build
npm run docs:preview
```

## Run the PHP examples

You need PHP 8.4+ (and Composer for a couple of folders).

```bash
php examples/hello/hello.php
php -S localhost:8080 -t examples/http-router/public
```

See each `examples/*/README.md` for details.

## Structure

- `docs/` - VitePress site (the tutorial)
- `examples/` - small runnable PHP scripts referenced from chapters

Best,

-- ł.
