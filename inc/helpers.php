<?php

use Theme\SvgSprite;
use Theme\View\Blade;

function svg_icon($name, array $attributes = []) {
	return SvgSprite::fromFile(TEMPLATEPATH . '/assets/images/sprite.svg')->getIcon($name, $attributes);
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