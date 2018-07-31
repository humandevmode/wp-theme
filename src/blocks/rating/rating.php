<?php

use Core\Helpers\HtmlHelper;

$value = $value ?? 0;
$count = $count ?? 0;

$attributes = ['title' => sprintf('Рейтинг %s', $value)];
if ($count) {
  $attributes += [
    'vocab' => 'http://schema.org/',
    'typeof' => 'AggregateRating',
  ];
}

?>

<div class="rating" <?= HtmlHelper::attr($attributes) ?>>
  <?php if ($count) : ?>
    <meta property="ratingValue" content="<?= esc_attr($value) ?>"/>
    <meta property="ratingCount" content="<?= esc_attr($count) ?>"/>
  <?php endif ?>

  <?php require_once __DIR__.'/rating__gradient.php'; ?>

  <?php for ($i = 1; $i <= 5; $i++) : ?>

    <?php if ($i <= $value) {
      $gradient = 10;
    } elseif ($i - $value < 1) {
      $gradient = fmod($value, 1) * 10;
    } else {
      $gradient = 0;
    } ?>

    <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="rating__star">
      <path fill="url(#lg-<?= $gradient ?>)"
            stroke="#cbcbcb"
            d="M10 1.1l2.8 5.7 6.2.9-4.5 4.4 1.1 6.2-5.6-3-5.6 3 1.1-6.2L1 7.7l6.2-.9z"
      ></path>
    </svg>
  <?php endfor ?>
</div>
