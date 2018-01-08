<?php

namespace Theme;

use DOMDocument;
use DOMXPath;

class SvgSprite {
	protected $dom;
	protected $xpath;
	protected $filePath;
	protected static $sprites;

	public function __construct(string $filePath) {
		$this->filePath = $filePath;
		$content = file_get_contents($this->filePath);
		$content = str_replace('<symbol', '<svg', $content);
		$content = str_replace('</symbol>', '</svg>', $content);
		$this->dom = new DOMDocument();
		@$this->dom->loadHTML($content);
		$this->xpath = new DOMXPath($this->dom);
	}

	public static function fromFile(string $filePath): SvgSprite {
		if (!isset(static::$sprites[$filePath])) {
			static::$sprites[$filePath] = new SvgSprite($filePath);
		}

		return static::$sprites[$filePath];
	}

	public function getIcon(string $name, array $attributes = []): string {
		$result = '';
		$icons = $this->xpath->query(sprintf('//svg[@id="%s"]', $name));
		if ($icons->length) {
			/** @var $icon \DOMElement */
			$icon = $icons->item(0)->cloneNode(true);
			$icon->removeAttribute('id');
			foreach ($attributes as $key => $value) {
				$icon->setAttribute($key, $value);
			}
			$result = $this->dom->saveHTML($icon);
		}

		return $result;
	}
}
