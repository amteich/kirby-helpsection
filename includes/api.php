<?php

return [
  'routes' => [
    [
      // Get the first set of pages to display primary nav
      'pattern' => 'mgfagency/helpsection/index',
      'action'  => function () {
        $slug = option('mgfagency.helpsection.contentfolder', 'helpsection');
        $pages = [];
        $page = page($slug);

        if ($page == null) {
          return [
            'status' => 'failed',
            'error' => "Please create a new content-folder <code>$slug</code> to show it here.",
          ];
        }

        foreach (page($slug)->children() as $page) {
          $pagedata = [
            'title' => (string)$page->title(),
            'id' => (string)$page->id(),
          ];
    
          if ($page->hasVisibleChildren()) {
            $children = $page->children()->visible();
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
      'pattern' => 'mgfagency/helpsection/page/(:all)',
      'action'  => function ($slug) {
        return [
          'rendered' => page($slug)->render(),
        ];
      }
    ],
  ],
];