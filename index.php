<?php

namespace amteich\helpsection;

use Kirby;

\Kirby::plugin('amteich/helpsection', [
    'options' => [
        'icon' => 'question',
    ],
    'routes' => function ($kirby) {
        return [
            [
                'pattern' => $kirby->option('amteich.helpsection.contentfolder', 'helpsection'),
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
