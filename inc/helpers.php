<?php

function svg_icon($name, array $attributes = [])
{
  return Theme\SvgSprite::fromFile(TEMPLATEPATH.'/assets/images/sprite.svg')->getIcon($name, $attributes);
}

function assets_uri(string $uri)
{
  return get_theme_file_uri('assets/'.ltrim($uri, '/'));
}

function assets_path(string $path)
{
  return get_theme_file_path('assets/'.ltrim($path, '/'));
}
