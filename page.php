<?php

defined('ABSPATH') or die();

$this->layout('layout');

?>

<?php if (have_posts()) : ?>

	<?php while (have_posts()) : the_post() ?>

		<article class="page-entry">

			<div class="page-entry__text">
				<?php the_content() ?>
			</div>

		</article>

	<?php endwhile ?>

<?php endif ?>
