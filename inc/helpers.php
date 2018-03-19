<?php

use Theme\SvgSprite;
use Theme\View\Blade;

function svg_icon($name, array $attributes = []) {
	return SvgSprite::fromFile(THEME_DIR . '/assets/images/sprite.svg')->getIcon($name, $attributes);
}

function filter_templates($templates) {
	$paths = ['views'];
	$paths_pattern = "#^(" . implode('|', $paths) . ")/#";

	return collect($templates)->map(function ($template) use ($paths_pattern) {
		/** Remove .blade.php/.blade/.php from template names */
		$template = preg_replace('#\.(blade\.?)?(php)?$#', '', ltrim($template));

		/** Remove partial $paths from the beginning of template names */
		if (strpos($template, '/')) {
			$template = preg_replace($paths_pattern, '', $template);
		}

		return $template;
	})->flatMap(function ($template) use ($paths) {
		return collect($paths)->flatMap(function ($path) use ($template) {
			return [
				"{$path}/{$template}.blade.php",
				"{$path}/{$template}.php",
				"{$template}.blade.php",
				"{$template}.php",
			];
		});
	})->filter()->unique()->all();
}

function _render_template($template) {
	$views = dirname(__DIR__) . '/views';
	$cache = wp_upload_dir()['basedir'] . '/blade';

	$template = str_replace($views, '', $template);
	$template = str_replace('.blade.php', '', $template);
	$view = trim($template, '/');

	$blade = new Blade($views, $cache);
	$result = $blade->render($view);

	return $result;
}