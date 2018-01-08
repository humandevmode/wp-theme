<?php

namespace Theme\View;

class Template extends \League\Plates\Template\Template {
	public function block($name, array $data = []) {
		$dir = explode('--', $name)[0];

		return $this->engine->render("src/blocks/{$dir}/{$name}", $data);
	}
}
