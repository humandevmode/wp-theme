<?php

$query = new WP_Query([
	'post_type' => 'post',
	'posts_per_page' => -1,
]);

?>

<aside class="l-sidebar">
	<div class="sidebar">
		<?php if ($query->have_posts()) : ?>

			<?php while ($query->have_posts()) : $query->the_post() ?>

				<a href="#" class="sidebar-post">
					<?php if (has_post_thumbnail()) : ?>

						<?php the_post_thumbnail('post-thumbnail', [
							'class' => 'sidebar-post__thumb',
						]) ?>

					<?php endif; ?>
					<div class="sidebar-post__text"><?php the_title() ?></div>
				</a>

			<?php endwhile ?>

		<?php endif ?><?php wp_reset_postdata() ?>
	</div>
</aside>
