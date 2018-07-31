<svg class="rating__gradient" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" width="1" height="1">
  <?php for ($i = 0; $i <= 10; $i++) : ?>

    <?php $percent = ceil((asin(2 * $i / 10 - 1) / M_PI + 0.5) * 100); ?>
    <linearGradient id="lg-<?= $i ?>" x1="0" x2="1" y1="0" y2="0">
      <stop offset="0%" stop-opacity="1" stop-color="#feac00"></stop>
      <stop offset="<?= $percent ?>%" stop-opacity="1" stop-color="#feac00"></stop>
      <stop offset="<?= $percent ?>%" stop-opacity="0" stop-color="#feac00"></stop>
      <stop offset="100%" stop-opacity="0" stop-color="#feac00"></stop>
    </linearGradient>

  <?php endfor ?>
</svg>
