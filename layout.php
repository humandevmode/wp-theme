<?php

defined('ABSPATH') or die();

?><!doctype html>
<html lang="ru-RU">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?= wp_title() ?></title>

	<?php wp_head() ?>
</head>

<body <?php body_class() ?>>

<div class="site-page">

	<?= $this->block('site-header') ?>

	<div class="site-body">
		<div class="site-body__inner">

			<?= $this->block('breadcrumbs') ?>

			<main class="l-content">
				<?= $this->section('content') ?>
			</main>

			<aside class="l-sidebar">
				<?= $this->block('sidebar') ?>
			</aside>
		</div>
	</div>

	<?= $this->block('site-footer') ?>

</div>

<?php wp_footer() ?>

</body>
</html>