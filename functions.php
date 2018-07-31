<?php

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/inc/actions.php';
require __DIR__.'/inc/filters.php';
require __DIR__.'/inc/helpers.php';

/** @var $Plates \League\Plates\Engine */
global $Plates;

define('THEME_ENV', isset($_SERVER['HTTP_X_BROWSERSYNC']) ? 'dev' : 'prod');

add_action('wp_enqueue_scripts', function () {
  if (THEME_ENV === 'dev') {
    wp_enqueue_script('scripts-main', assets_uri('scripts/main.min.js'), [], false, true);
  } else {
    wp_enqueue_style('styles-main', assets_uri('styles/main.min.css'), [],
      filemtime(assets_path('styles/main.min.css')));

    wp_enqueue_script('scripts-main', assets_uri('scripts/main.min.js'), [],
      filemtime(assets_path('scripts/main.min.js')), true);
  }

  $js_vars = [
    'ajax_url' => admin_url('admin-ajax.php'),
    'post_url' => admin_url('admin-post.php'),
    'is_user_logged_in' => is_user_logged_in(),
  ];
  wp_localize_script('scripts-main', 'js_vars', $js_vars);

  wp_deregister_script('jquery');
  wp_deregister_script('jquery-form');
  wp_deregister_script('wp-embed');

  wp_register_script('jquery', assets_uri('scripts/lib/jquery.min.js'), [], null, true);
  wp_register_script('jquery-form', assets_uri('scripts/lib/jquery.form.min.js'), ['jquery'], null, true);
  wp_register_script('jquery-pjax', assets_uri('scripts/lib/jquery.pjax.min.js'), ['jquery'], null, true);
});

try {
  if (defined('WP_CLI') && WP_CLI) {
    WP_CLI::add_command('themedev', \Theme\Cli\DevCommands::class);
  }
} catch (Throwable $e) {
}
