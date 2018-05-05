<?php

use Core\Helpers\PostHelper;
use League\Plates;

remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_oembed_add_host_js');
remove_action('wp_head', 'wp_shortlink_wp_head', 10);

add_action('init', function () {
	initPlates();
	disable_wp_emoji();
	register_theme_menus();
});

add_action('get_header', function () {
	remove_action('wp_head', '_admin_bar_bump_cb');
});

add_action('after_switch_theme', function () {
	ensurePagesExists();
});

add_action('after_setup_theme', function () {
	add_theme_support('post-thumbnails');
	add_theme_support('admin-bar', [
		'callback' => '__return_false'
	]);
	add_theme_support('amp', [
		'template_dir' => 'amp',
	]);
});

function ensurePagesExists() {
	try {
		$page_id = PostHelper::ensurePageExist('front-page', [
			'post_title' => 'Главная страница',
		]);
		update_option('show_on_front', 'page');
		update_option('page_on_front', $page_id);
	} catch (Exception $exception) {
	}
}

function initPlates() {
	global $Plates;

	$Plates = new Plates\Engine(TEMPLATEPATH);
	$Plates->registerFunction('block', function ($name, array $data = []) use ($Plates) {
		$dir = explode('--', $name)[0];

		return $Plates->render("src/blocks/{$dir}/{$name}", $data);
	});
}

function disable_wp_emoji() {
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');
}

function register_theme_menus() {
	register_nav_menus([
		'main-menu' => __('Main Menu'),
		'mobile-menu' => __('Mobile Menu'),
	]);
}
