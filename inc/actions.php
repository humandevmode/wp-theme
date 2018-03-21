<?php

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
	$front = get_page_by_path('front-page');
	if (!$front) {
		$id = wp_insert_post([
			'post_title' => 'Главная страница',
			'post_type' => 'page',
			'post_name' => 'front-page',
			'post_status' => 'publish'
		]);
		if (is_wp_error($id)) {
			return;
		}
		$front = get_post($id);
	}
	update_option('show_on_front', 'page');
	update_option('page_on_front', $front->ID);
});

add_action('after_setup_theme', function () {
	add_theme_support('post-thumbnails');
});

add_action('init', function () {
	disable_wp_emoji();
	register_theme_menus();
});

add_action('admin_bar_init', function () {
	remove_action('wp_head', '_admin_bar_bump_cb');
	add_action('wp_head', function () {
		print '
		<style type="text/css" media="screen">
			body {
				padding-top: 32px !important;
			}
			@media screen and (max-width: 782px) {
				body {
					padding-top: 46px !important;
				}
			}
		</style>';
	});
});

function register_theme_menus() {
	register_nav_menus([
		'header-menu' => __('Header Menu'),
		'sidebar-menu' => __('Sidebar Menu'),
		'footer-menu' => __('Footer Menu'),
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

	// filter to remove TinyMCE emojis
	add_filter('tiny_mce_plugins', 'disable_emojicons_tinymce');
}
