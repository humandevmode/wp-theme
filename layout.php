<?php

/**
 * @var $this \Theme\View\Template
 */

$withBreadcrumbs = isset($withBreadcrumbs) ? $withBreadcrumbs : true;
$metaTitle = isset($metaTitle) ? $metaTitle : wp_title('', false);

?><!doctype html>
<html lang="ru-RU">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<title><?= $metaTitle ?></title>
	<?php wp_head() ?>
</head>

<body <?php body_class() ?>>

<?= $this->block('site-header') ?>

<div class="site-body">
	<div class="site-body__inner">

		<?php if ($withBreadcrumbs) : ?>
			<?= $this->block('breadcrumbs') ?><?php endif; ?>

		<?= $this->section('content') ?>

		<?= $this->block('sidebar') ?>

	</div>
</div>

<?= $this->block('site-footer') ?>

<?php wp_footer() ?>

</body>
</html>
