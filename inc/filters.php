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

    return __DIR__.'/blank.php';
  }

  return $template;
}, PHP_INT_MAX);

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
  $classes[] = is_user_logged_in() ? 'logged-in' : 'logged-out';

  return array_filter($classes);
});
