<?php

namespace mgfagency\documentation;

use Kirby;

\Kirby::plugin('mgfagency/documentation', [
  'routes' => function ($kirby) {
    return [
      [
        'pattern' => $kirby->option('mgfagency.documentation.contentfolder', 'documentation'),
        'action' => function () {
          return false;
        }
      ]
    ];
  },
  'api' => include __DIR__ . '/includes/api.php',
  'templates' => [
    'doc' => __DIR__ . '/templates/doc.php',
  ],
]);
