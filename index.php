<?php

$this->layout('layout');

?>

<h1>This is from-page template</h1>

<?php if (have_posts()) : ?>

	<?php while (have_posts()) : the_post() ?>
		<article class="post-entry">
			<div class="post-entry__text"><?php the_content() ?></div>
		</article>
	<?php endwhile ?>

<?php endif ?><?php wp_reset_postdata() ?>
