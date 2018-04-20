<?php

use Core\Helpers\PostHelper;

remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_oembed_add_host_js');
remove_action('wp_head', 'wp_shortlink_wp_head', 10);

add_action('after_switch_theme', function () {
	$cache = wp_upload_dir()['basedir'] . '/blade';
	if (!is_dir($cache)) {
		mkdir($cache);
	}
	try {
		$page_id = PostHelper::ensurePageExist('front-page', [
			'post_title' => 'Главная страница'
		]);
		update_option('show_on_front', 'page');
		update_option('page_on_front', $page_id);
	}
	catch (Exception $exception) {}
});

add_action('after_setup_theme', function () {
	add_theme_support('post-thumbnails');
});

add_action('init', function () {
	disable_wp_emoji();
	register_theme_menus();
});

function register_theme_menus() {
	register_nav_menus([
		'main-menu' => __('Main Menu'),
		'mobile-menu' => __('Mobile Menu'),
	]);
}

function disable_wp_emoji() {
	// all actions related to emojis
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');
}
