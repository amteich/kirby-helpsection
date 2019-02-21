<?php

namespace mgfagency\documentation;

use Dir;
use F;
use Data;

class Documentation {
  public static $contentRoot = '';

  public static function readPage ($slug = '') {
    $path = static::$contentRoot;
    if ($slug != '') $path .= '/' . $slug;
    $path .= '/content.txt';

    if (F::exists($path)) {
      $content = Data::read($path);

      if (isset($content['text']))
        $content['text'] = str_replace('(\\', '(', kirbytext($content['text']));

      if (isset($content['excerpt']))
        $content['excerpt'] = kirbytext($content['excerpt']);
    }
    else {
      $content = [];
    }

    return $content;
  }

  public static function load () {
    return static::readDirs(Documentation::$contentRoot);
  }

  private static function readDirs ($root) {
    $pages = [];

    $dirs = Dir::dirs($root);
    asort($dirs, SORT_NUMERIC);

    foreach ($dirs as $page) {
      $currentPath = $root . '/' . $page;
      $currentSlug = substr($currentPath, strlen(static::$contentRoot) + 1);

      $pageObj = [
        'content' => static::readPage($currentSlug),
        'slug' => $currentSlug,
      ];

      // var_dump (Dir::dirs($currentPath));

      if (count(Dir::dirs($currentPath)) > 0) {
        $pageObj['children'] = static::readDirs($currentPath, static::$contentRoot);
      }
      $pages[$page] = $pageObj;
    }
    return $pages;
  }
}
