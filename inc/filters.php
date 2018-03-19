<?php

add_filter('bcn_settings_init', function ($options) {
	foreach ($options as $key => $value) {
		$len1 = strlen('<span');
		$len2 = strlen('</span>');
		if (is_string($value) && strpos($value, '<span property') === 0) {
			$value = '<li class="breadcrumbs__item"' . substr($value, $len1, strlen($value) - $len1 - $len2) . '</li>';
			$options[$key] = $value;
		};
	}

	return $options;
});

add_filter('bcn_allowed_html', function ($allowed_html) {
	$allowed_html['li'] = [
		'title' => true,
		'class' => true,
		'id' => true,
		'dir' => true,
		'align' => true,
		'lang' => true,
		'xml:lang' => true,
		'aria-hidden' => true,
		'data-icon' => true,
		'itemref' => true,
		'itemid' => true,
		'itemprop' => true,
		'itemscope' => true,
		'itemtype' => true,
		'property' => true,
		'typeof' => true,
	];

	return $allowed_html;
});

/**
 * Add <body> classes
 */
add_filter('body_class', function (array $classes) {
	/** Add page slug if it doesn't exist */
	if (is_single() || is_page() && !is_front_page()) {
		if (!in_array(basename(get_permalink()), $classes)) {
			$classes[] = basename(get_permalink());
		}
	}

	/** Clean up class names for custom templates */
	$classes = array_map(function ($class) {
		return preg_replace(['/-blade(-php)?$/', '/^page-template-views/'], '', $class);
	}, $classes);

	return array_filter($classes);
});

/**
 * Template Hierarchy should search for .blade.php files
 */
collect([
	'index',
	'404',
	'archive',
	'author',
	'category',
	'tag',
	'taxonomy',
	'date',
	'home',
	'frontpage',
	'page',
	'paged',
	'search',
	'single',
	'singular',
	'attachment',
])->map(function ($type) {
	add_filter("{$type}_template_hierarchy", 'filter_templates');
});

add_filter('template_include', function ($template) {
	if ($template) {
		echo _render_template($template);

		return __DIR__ . '/blank.php';
	}

	return $template;
}, PHP_INT_MAX);

add_filter('get_the_time', 'register_russian_datetime');
add_filter('get_the_date', 'register_russian_datetime');
add_filter('get_the_modified_date', 'register_russian_datetime');
add_filter('get_post_time', 'register_russian_datetime');
add_filter('get_comment_date', 'register_russian_datetime');
function register_russian_datetime($date = '') {
	if (substr_count($date, '---') > 0) {
		return str_replace('---', '', $date);
	}

	$replaces = [
		'Январь' => 'января',
		'Февраль' => 'февраля',
		'Март' => 'марта',
		'Апрель' => 'апреля',
		'Май' => 'мая',
		'Июнь' => 'июня',
		'Июль' => 'июля',
		'Август' => 'августа',
		'Сентябрь' => 'сентября',
		'Октябрь' => 'октября',
		'Ноябрь' => 'ноября',
		'Декабрь' => 'декабря',

		'January' => 'января',
		'February' => 'февраля',
		'March' => 'марта',
		'April' => 'апреля',
		'May' => 'мая',
		'June' => 'июня',
		'July' => 'июля',
		'August' => 'августа',
		'September' => 'сентября',
		'October' => 'октября',
		'November' => 'ноября',
		'December' => 'декабря',

		'Jan' => 'янв',
		'Feb' => 'фев',
		'Mar' => 'март',
		'Apr' => 'апр',
		'Jun' => 'июн',
		'Jul' => 'июл',
		'Aug' => 'авг',
		'Sep' => 'сен',
		'Oct' => 'окт',
		'Nov' => 'ноя',
		'Dec' => 'дек',

		'Sunday' => 'воскресенье',
		'Monday' => 'понедельник',
		'Tuesday' => 'вторник',
		'Wednesday' => 'среда',
		'Thursday' => 'четверг',
		'Friday' => 'пятница',
		'Saturday' => 'суббота',

		'Sun' => 'воскресенье',
		'Mon' => 'понедельник',
		'Tue' => 'вторник',
		'Wed' => 'среда',
		'Thu' => 'четверг',
		'Fri' => 'пятница',
		'Sat' => 'суббота',

		'th' => '',
		'st' => '',
		'nd' => '',
		'rd' => '',
	];

	return strtr($date, $replaces);
}
