<?php

remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');

global $ThemeView;

$ThemeView = new \Theme\View\Engine(THEME_DIR);

add_action('after_setup_theme', 'theme_after_setup');
function theme_after_setup() {
	show_admin_bar(false);
	add_theme_support('post-thumbnails');
}

add_action('init', 'register_theme_menus');
function register_theme_menus() {
	register_nav_menus([
		'header-menu' => __('Header Menu'),
		'sidebar-menu' => __('Sidebar Menu'),
		'footer-menu' => __('Footer Menu'),
		'mobile-menu' => __('Mobile Menu'),
	]);
}

add_action('init', 'disable_wp_emoji');
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
