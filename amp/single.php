<?php

the_post();
$this->layout('amp/layout');

?>

<article class="entry-post">
	<h1 class="entry-post__title"><?php the_title() ?></h1>
	<div class="date">
		<div class="date__day"><?php the_date() ?></div>
		<div class="date__time"><?php the_time() ?></div>
	</div>
	<div class="entry-post__content"><?php the_content() ?></div>
</article>
