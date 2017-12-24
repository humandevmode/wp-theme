<?php

namespace Theme\View;

class Engine extends \League\Plates\Engine {
	public function make($name) {
		return new Template($this, $name);
	}
}