<?php

function svg_icon($name, array $attributes = []) {
	return Theme\SvgSprite::fromFile(TEMPLATEPATH . '/assets/images/sprite.svg')->getIcon($name, $attributes);
}
