<?php

use Theme\SvgSprite;

function get_svg_icon($name, array $attributes = []) {
	return SvgSprite::fromFile(THEME_DIR . '/assets/images/sprite.svg')->getIcon($name, $attributes);
};
