import { defineConfig } from 'vitepress'

export default defineConfig({
  title: 'PHP for FE devs',
  description: 'A PHP tutorial for front-end developers - notes-style, practical, framework-ready',
  base: '/lab/php-tutorial-for-fe-devs/',
  cleanUrls: true,
  lastUpdated: true,

  themeConfig: {
    nav: [
      { text: 'Guide', link: '/guide/01-why-php-in-2026' },
      { text: 'Cheatsheet', link: '/guide/cheatsheet' },
    ],

    search: {
      provider: 'local',
    },

    sidebar: [
      {
        text: 'Getting oriented',
        collapsed: false,
        items: [
          { text: 'Why PHP in 2026', link: '/guide/01-why-php-in-2026' },
          { text: 'Setup', link: '/guide/02-setup' },
          { text: 'JS → PHP map', link: '/guide/03-js-to-php-map' },
        ],
      },
      {
        text: 'Language core',
        collapsed: false,
        items: [
          { text: 'Types & strict mode', link: '/guide/04-types-and-strict-mode' },
          { text: 'Arrays & strings', link: '/guide/05-arrays-and-strings' },
          { text: 'Functions', link: '/guide/06-functions' },
          { text: 'Control flow', link: '/guide/07-control-flow' },
        ],
      },
      {
        text: 'Objects & structure',
        collapsed: false,
        items: [
          { text: 'OOP basics', link: '/guide/08-oop-basics' },
          { text: 'Modern PHP OOP', link: '/guide/09-modern-php-oop' },
          { text: 'Namespaces & PSR-4', link: '/guide/10-namespaces-and-psr4' },
          { text: 'Composer', link: '/guide/11-composer' },
          { text: 'Errors & exceptions', link: '/guide/12-errors-and-exceptions' },
        ],
      },
      {
        text: 'Web PHP',
        collapsed: false,
        items: [
          { text: 'HTTP lifecycle', link: '/guide/13-http-lifecycle' },
          { text: 'Superglobals & forms', link: '/guide/14-superglobals-and-forms' },
          { text: 'Sessions & cookies', link: '/guide/15-sessions-and-cookies' },
          { text: 'Filesystem & uploads', link: '/guide/16-filesystem-and-uploads' },
          { text: 'PDO & SQL', link: '/guide/17-pdo-and-sql' },
          { text: 'Security essentials', link: '/guide/18-security-essentials' },
        ],
      },
      {
        text: 'Practice + runway',
        collapsed: false,
        items: [
          { text: 'Mini router project', link: '/guide/19-mini-router' },
          { text: 'Testing intro', link: '/guide/20-testing-intro' },
          { text: 'Before Laravel / Symfony', link: '/guide/21-before-laravel-symfony' },
          { text: 'Cheatsheet', link: '/guide/cheatsheet' },
        ],
      },
    ],

    socialLinks: [
      { icon: 'github', link: 'https://github.com/lukaszkups/php-tutorial-for-fe-devs' },
    ],

    footer: {
      message: 'Notes-style PHP tutorial for front-end folks',
      copyright: 'Copyright © 2026-present Łukasz Kupś. All rights reserved.',
    },
  },
})
