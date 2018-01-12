<?php

namespace Theme\Cli;

class Dev extends \WP_CLI_Command {
	public function block($args, $assoc_args) {
		$name = $this->parseBlockName($args, $assoc_args);

		$path = THEME_DIR . '/src/blocks/' . trim($name);
		if (!is_dir($path)) {
			mkdir($path, 0755);
		}
		file_put_contents($path . "/{$name}.js", '');
		file_put_contents($path . "/{$name}.php", '');
		file_put_contents($path . "/{$name}.scss", ".{$name} {\n\t\n}\n");

		file_put_contents(THEME_DIR . '/src/main.js', $this->blockRequire($name), FILE_APPEND);
		file_put_contents(THEME_DIR . '/src/main.scss', $this->blockImport($name), FILE_APPEND);
	}

	public function deleteBlock() {

	}

	protected function parseBlockName($args, $assoc_args) {
		if (isset($args[0])) {
			$name = $args[0];
		}
		elseif (isset($assoc_args['name'])) {
			$name = $assoc_args['name'];
		}
		else {
			throw new \Exception('Block name must exists');
		}

		return trim($name);
	}

	protected function blockRequire($name) {
		return "require('./blocks/{$name}/{$name}');\n";
	}

	protected function blockImport($name) {
		return "@import \"blocks/{$name}/{$name}\";\n";
	}
}
