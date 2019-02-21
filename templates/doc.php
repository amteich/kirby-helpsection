<h1><?php echo $page->title(); ?></h1>
<div class="intro"><?php echo $page->excerpt()->kirbytext() ?></div>
<?php echo str_replace('(\\', '(', $page->text()->kirbytext()) ?>