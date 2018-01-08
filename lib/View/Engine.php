<?php

namespace Theme\View;

class Engine extends \League\Plates\Engine {
	public function make($name) {
		return new Template($this, $name);
	}

	public function render($template, array $data = []) {
		$folder = $this->getDirectory();
		if (strpos($template, $folder) === 0) {
			$template = substr($template, strlen($folder));
			$template = preg_replace('/\.php$/', '', $template);
		}

		return $this->make($template)->render($data);
	}
}
