<?php

return [
  'routes' => [
    [
      // Get the first set of pages to display primary nav
      'pattern' => 'mgf/documentation/index',
      'action'  => function () {
        $slug = option('mgfagency.documentation.contentfolder', 'documentation');
        $pages = [];
    
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
    
        return $pages;
      },
    ],
    [
      // Get the first set of pages to display primary nav
      'pattern' => 'mgf/documentation/page/(:all)',
      'action'  => function ($slug) {
        return [
          'rendered' => page($slug)->render(),
        ];
      }
    ],
  ],
];