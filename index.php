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
    'areas' => [
        'helpsection' => function () {
            return [
                // label for the menu and the breadcrumb
                'label' => 'Hilfe',

                // icon for the menu and breadcrumb
                'icon' => 'amteichhelpsection',

                // show / hide from the menu
                'menu' => true,

                // link to the main area view
                'link' => 'helpsection',

                // views
                'views' => [
                    [
                        'pattern' => 'helpsection',
                        'action'  => function () {

                            // view routes return a simple array,
                            // which will be injected into our Vue app;
                            // the array can control the loaded Vue component,
                            // props for the component and settings for the current view
                            // (like breadcrumb, title, active search type etc.)

                            $slug = option('amteich.helpsection.contentfolder', 'helpsection');
                            $pages = [];
                            $page = page($slug);

                            if ($page == null) {
                                return [
                                    'status' => 'failed',
                                    'error' => "Please create a new content-folder <code>$slug</code> to show it here.",
                                ];
                            }

                            foreach (page($slug)->children()->listed() as $page) {
                                $pagedata = [
                                    'title' => (string)$page->title(),
                                    'id' => (string)$page->id(),
                                ];

                                if ($page->hasListedChildren()) {
                                    $children = $page->children()->listed();
                                    $childrendata = [];
                                    foreach ($children as $child) {
                                        $childrendata[] = [
                                            'title' => (string)$child->title(),
                                            'id' => (string)$child->id(),
                                            'slug' => (string)$child->id(),
                                            'hasChildren' => (bool)$child->hasChildren(),
                                            'rendered' => (string)$child->render(),
                                        ];
                                    }
                                    $pagedata['children'] = $childrendata;
                                }

                                $pages[] = $pagedata;
                            }

                            return [
                                // the Vue component can be defined in the
                                // `index.js` of your plugin
                                'component' => 'k-helpsection-view',

                                // the document title for the current view
                                'title' => 'Hilfe',

                                // the breadcrumb can be just an array or a callback
                                // function for more complex breadcrumb logic
                                // 'breadcrumb' => function () {
                                //     // each item in the breadcrumb array
                                //     // has a label and a link attribute
                                //     return [
                                //     [
                                //         'label' => 'Buy some milk',
                                //         'link'  => '/todos/123'
                                //     ]
                                //     ];
                                // },

                                // props will be directly available in the
                                // Vue component. It's a super convenient way
                                // to send backend data to the Panel
                                'props' => [
                                    'pages' => $pages,
                                ],

                                // we can preset the search type with the
                                // search attribute
                                'search' => 'pages'
                            ];
                        }
                    ],
                    [
                        'pattern' => 'helpsection/(:all)',
                        'action'  => function ($slug) {

                            // view routes return a simple array,
                            // which will be injected into our Vue app;
                            // the array can control the loaded Vue component,
                            // props for the component and settings for the current view
                            // (like breadcrumb, title, active search type etc.)

                            return [
                                // the Vue component can be defined in the
                                // `index.js` of your plugin
                                'component' => 'k-helpsection-view',

                                // the document title for the current view
                                'title' => 'Hilfe',

                                // the breadcrumb can be just an array or a callback
                                // function for more complex breadcrumb logic
                                // 'breadcrumb' => function () {
                                //     // each item in the breadcrumb array
                                //     // has a label and a link attribute
                                //     return [
                                //     [
                                //         'label' => 'Buy some milk',
                                //         'link'  => '/todos/123'
                                //     ]
                                //     ];
                                // },

                                // props will be directly available in the
                                // Vue component. It's a super convenient way
                                // to send backend data to the Panel
                                'props' => [
                                    'slug' => $slug,
                                ],

                                // we can preset the search type with the
                                // search attribute
                                'search' => 'pages'
                            ];
                        }
                    ],
                ]
            ];
        }
    ]
]);
