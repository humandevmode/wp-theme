<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/inc/actions.php';
require __DIR__ . '/inc/filters.php';
require __DIR__ . '/inc/helpers.php';

add_action('wp_enqueue_scripts', function () {
	wp_enqueue_style('styles-main', get_theme_file_uri('assets/styles/main.min.css'), [], filemtime(__DIR__ . '/assets/styles/main.css'));

	wp_deregister_script('jquery');
	wp_deregister_script('jquery-form');
	wp_deregister_script('wp-embed');

	wp_register_script('jquery', get_theme_file_uri('assets/scripts/lib/jquery.min.js'), [], null, true);
	wp_register_script('jquery-pjax', get_theme_file_uri('assets/scripts/lib/jquery.pjax.min.js'), ['jquery'], null, true);
	wp_register_script('jquery-form', get_theme_file_uri('assets/scripts/lib/jquery.form.min.js'), ['jquery'], null, true);

	wp_enqueue_script('scripts-main', get_theme_file_uri('assets/scripts/main.min.js'), [
//		'jquery',
	], filemtime(__DIR__ . '/assets/scripts/main.min.js'), true);

	$js_vars = [
		'ajax_url' => admin_url('admin-ajax.php'),
//		'post_url' => admin_url('admin-post.php'),
//		'is_user_logged_in' => is_user_logged_in(),
	];
	wp_localize_script('scripts-main', 'js_vars', $js_vars);
});

try {
	if (defined('WP_CLI') && WP_CLI) {
		WP_CLI::add_command('themedev', \Theme\Cli\Dev::class);
	}
} catch (Throwable $e) {
}
