---
layout: home

hero:
  name: PHP for FE devs
  text: For front-end developers
  tagline: Notes-style walkthrough of modern PHP - so Laravel or Symfony won't feel like magic later.
  actions:
    - theme: brand
      text: Start reading
      link: /guide/01-why-php-in-2026
    - theme: alt
      text: Cheatsheet
      link: /guide/cheatsheet

features:
  - title: You already know programming
    details: This assumes JS/TS comfort. I'll map PHP ideas to what you already use - modules, types, HTTP, async vs request lifecycle.
  - title: PHP 8.4+
    details: Strict types, enums, attributes, readonly, match, nullsafe - the language you'll actually meet in 2026 codebases.
  - title: Framework runway, not tutorials
    details: No Laravel/Symfony chapters yet. We cover Composer, routing, PDO, security, and the mental models those frameworks sit on.
---

## Who this is for

I've written this as if I'm leaving notes for myself - a front-end person who knows variables, functions, async, modules, and HTTP… but hasn't lived in PHP land.

If you've shipped React/Vue/Svelte (or plain JS) and you want to understand what happens on the server when a form hits `/api/login`, you're in the right place.

## How to follow along

1. Install PHP 8.4+ and Composer ([Setup](/guide/02-setup))
2. Read chapters in order - later ones assume earlier mental models
3. Run stuff from `examples/` when a chapter points at it
4. Keep the [cheatsheet](/guide/cheatsheet) open once you're past the language core

```bash
npm install
npm run docs:dev
```

And for PHP bits:

```bash
php examples/hello/hello.php
```

## What's intentionally missing

- Laravel / Symfony tutorials (that's the next adventure)
- WordPress
- Deep Docker / K8s / devops rabbit holes

We're here for the language + the web primitives frameworks abstract away.

Wish you all the best - hope you're gonna enjoy the ride.

Best,

-- ł.
