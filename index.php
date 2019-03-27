<?php

namespace mgfagency\helpsection;

use Kirby;

\Kirby::plugin('mgfagency/helpsection', [
    'routes' => function ($kirby) {
        return [
            [
                'pattern' => $kirby->option('mgfagency.helpsection.contentfolder', 'helpsection'),
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
    'blueprints' => [
        'pages/doc' => __DIR__ . '/blueprints/doc.yml'
    ],
    'translations' => require __DIR__ . '/includes/translations.php',
]);
