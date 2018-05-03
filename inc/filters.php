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
