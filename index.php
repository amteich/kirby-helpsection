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
        'docindex' => __DIR__ . '/templates/docindex.php',
    ],
    'blueprints' => [
        'pages/docindex' => __DIR__ . '/blueprints/docindex.yml'
    ],
    'translations' => require __DIR__ . '/includes/translations.php',
]);
