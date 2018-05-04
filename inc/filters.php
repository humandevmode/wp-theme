<?php

add_filter('template_include', function ($template) {
	global $Plates;

	if ($template) {
		$folder = $Plates->getDirectory();
		if (strpos($template, $folder) === 0) {
			$template = substr($template, strlen($folder));
			$template = preg_replace('/\.php$/', '', $template);
		}

		echo $Plates->render($template);

		return __DIR__ . '/blank.php';
	}

	return $template;
}, PHP_INT_MAX);
