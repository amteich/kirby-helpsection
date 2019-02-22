<?php

namespace mgfagency\helpsection;

use Kirby\CMS\KirbyTag;
use Page;
use Dir;
use Data;
use F;
use Str;
use Pages;

class TextformatsPage extends Page {
    public function children () {
        $children = [];

        foreach (KirbyTag::$types as $id => $type) {
            $slug = F::name($id);

            $content = [
                'title'    => $id,
                // 'excerpt' => $blueprint['help'] ?? '',
            ];

            if ($page = parent::children()->find($slug)) {
                $content = array_merge($content, $page->content()->toArray());
            }

            $children[] = [
                'content' => $content,
                'slug'     => Str::kebab($id),
                'model'    => 'doc',
                'template' => 'doc',
                'parent'   => $this,
            ];
        }

        return Pages::factory($children, $this);
    }
}
