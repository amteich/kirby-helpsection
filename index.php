<?php

namespace mgfagency\documentation;

use Kirby;

\Kirby::plugin('mgfagency/documentation', [
  'api' => include __DIR__ . '/includes/api.php',
  'templates' => [
    'doc' => __DIR__ . '/templates/doc.php',
  ],
]);
