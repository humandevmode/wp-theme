<?php

the_post();
$this->layout('layout', [
  'with_breadcrumbs' => false,
]);

?>

<h1>This is from-page template</h1>

<article class="post-entry">
  <div class="post-entry__text"><?php the_content() ?></div>
</article>
