<?php

$attributes = isset($attr) ? $attr : [];
$id = isset($attributes['id']) ? $attributes['id'] : '';
$class = isset($attributes['class']) ? $attributes['class'] : '';

?>

<button id="<?= $id ?>" class="hamburger <?= $class ?>" type="button">
	<span class="hamburger-box">
		<span class="hamburger-inner"></span>
	</span>
</button>
