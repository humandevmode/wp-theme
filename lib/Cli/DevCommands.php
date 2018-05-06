<?php

namespace Theme\Cli;

use Core\Helpers\FileHelper;

class DevCommands extends \WP_CLI_Command {
	/**
	 * @param $args
	 * @param $assoc_args
	 * @throws \Exception
	 */
	public function block($args, $assoc_args) {
		$name = $this->parseName($args, $assoc_args);

		$path = $this->getBlockPath($name);
		if (!is_dir($path)) {
			mkdir($path, 0755);
		}
		file_put_contents($path . "/{$name}.js", "import './{$name}.scss'\n");
		file_put_contents($path . "/{$name}.scss", ".{$name} {\n\t\n}\n");
		file_put_contents($path . "/{$name}.php", ".{$name}\n");

		file_put_contents($this->getEntryPath(), $this->importLine($name), FILE_APPEND);
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
		file_put_contents(TEMPLATEPATH . "/{$name}.php", $content);
	}

	/**
	 * @param $args
	 * @param $assoc_args
	 * @throws \Exception
	 */
	public function deleteBlock($args, $assoc_args) {
		$name = $this->parseName($args, $assoc_args);

		if (is_dir($this->getBlockPath($name))) {
			FileHelper::removeDirectory($this->getBlockPath($name));
		}

		if (is_file($this->getEntryPath())) {
			$contents = file_get_contents($this->getEntryPath());
			if (strpos($contents, $this->importLine($name)) !== false) {
				file_put_contents($this->getEntryPath(), str_replace($this->importLine($name), '', $contents));
			}
		}
	}

	public function getBlockPath($name) {
		return TEMPLATEPATH . '/src/blocks/' . trim($name);
	}

	public function getEntryPath() {
		return TEMPLATEPATH . '/src/main.js';
	}

	protected function importLine($name) {
		return "import 'blocks/{$name}/{$name}';\n";
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
}
