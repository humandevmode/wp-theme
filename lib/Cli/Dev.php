<?php

namespace Theme\Cli;

use Core\Helpers\FileHelper;

class Dev extends \WP_CLI_Command {
	/**
	 * @param $args
	 * @param $assoc_args
	 * @throws \Exception
	 */
	public function block($args, $assoc_args) {
		$name = $this->parseName($args, $assoc_args);

		$path = TEMPLATEPATH . '/src/blocks/' . trim($name);
		if (!is_dir($path)) {
			mkdir($path, 0755);
		}
		file_put_contents($path . "/{$name}.js", '');
		file_put_contents($path . "/{$name}.scss", ".{$name} {\n\t\n}\n");
		file_put_contents($path . "/{$name}.php", <<<EOL
.{$name}
EOL
		);

		file_put_contents(TEMPLATEPATH . '/src/main.js', $this->blockRequire($name), FILE_APPEND);
		file_put_contents(TEMPLATEPATH . '/src/main.scss', $this->blockImport($name), FILE_APPEND);
	}

	/**
	 * @param $args
	 * @param $assoc_args
	 * @throws \Exception
	 */
	public function page($args, $assoc_args) {
		$name = $this->parseName($args, $assoc_args);
		$content = <<<EOL
<?php

the_post();
\$this->layout('layout');

?>

EOL;
		file_put_contents(TEMPLATEPATH . "/$name.php", $content);
	}

	/**
	 * @param $args
	 * @param $assoc_args
	 * @throws \Exception
	 */
	public function deleteBlock($args, $assoc_args) {
		$name = $this->parseName($args, $assoc_args);

		$path = TEMPLATEPATH . '/src/blocks/' . trim($name);
		if (is_dir($path)) {
			FileHelper::removeDirectory($path);
		}

		$filePath = TEMPLATEPATH . '/src/main.js';
		if (is_file($filePath)) {
			$contents = file_get_contents($filePath);
			if (strpos($contents, $this->blockRequire($name)) !== false) {
				file_put_contents($filePath, str_replace($this->blockRequire($name), '', $contents));
			}
		}

		$filePath = TEMPLATEPATH . '/src/main.scss';
		if (is_file($filePath)) {
			$contents = file_get_contents($filePath);
			if (strpos($contents, $this->blockImport($name)) !== false) {
				file_put_contents($filePath, str_replace($this->blockImport($name), '', $contents));
			}
		}
	}

	/**
	 * @param $args
	 * @param $assoc_args
	 * @return string
	 * @throws \Exception
	 */
	protected function parseName($args, $assoc_args) {
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
