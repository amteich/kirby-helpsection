<?php

return [
    'routes' => [
        [
            // Get the first set of pages to display primary nav
            'pattern' => 'amteich/helpsection/index',
            'action'  => function () {
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
                    'slug' => $slug,
                    'pages' => $pages,
                    'status' => 'ok',
                ];
            },
        ],
        [
            // Get the first set of pages to display primary nav
            'pattern' => 'amteich/helpsection/page/(:all)',
            'action'  => function ($slug) {
                return [
                    'rendered' => page($slug)->render(),
                ];
            }
        ],
    ],
];
