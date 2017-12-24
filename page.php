<?php

$this->layout('layout');

the_post();

?>

<article class="page-entry">

	<div class="page-entry__text">
		<?php the_content() ?>
	</div>

</article>
