<?php

/**
 * @var $this \Theme\View\Template
 */

$this->layout('layout');

?>

<?php if (have_posts()) : ?>

	<?php while (have_posts()) : the_post() ?>

		<article class="post-entry">

			<div class="post-entry__text">
				<?php the_content() ?>
			</div>

		</article>

	<?php endwhile ?>

<?php endif ?>
