<?php

namespace mgfagency\documentation;

load([
  'mgfagency\\documentation\\documentation'    => 'classes/Documentation.php',
], __DIR__);

use Kirby;

\Kirby::plugin('mgfagency/documentation', [
  'api' => [
    'routes' => [
      [
        'pattern' => 'mgf/documentation/pages',
        'action'  => function () {
          Documentation::$contentRoot = dirname(kirby()->roots()->site()) . '/documentation';
          
          return [
            'pages' => Documentation::load(),
          ];
        }
      ],
    ],
  ],
]);
