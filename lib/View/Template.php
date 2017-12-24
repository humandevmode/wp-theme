<?php

namespace Theme\View;

class Template extends \League\Plates\Template\Template {
	public function layout($name, array $data = []) {
		$this->layoutName = 'layouts/' . $name;
		$this->layoutData = $data;
	}
}