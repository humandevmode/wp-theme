<?php

namespace Theme;

use Wa72\HtmlPageDom\HtmlPageCrawler;

class SvgSprite {
	protected $filePath;
	protected $dom;
	protected static $sprites;

	public function __construct(string $filePath) {
		$this->filePath = $filePath;
		$this->dom = new HtmlPageCrawler(file_get_contents($filePath));
	}

	public static function fromFile(string $filePath): SvgSprite {
		if (!isset(static::$sprites[$filePath])) {
			static::$sprites[$filePath] = new SvgSprite($filePath);
		}

		return static::$sprites[$filePath];
	}

	public function getIcon(string $name, array $attributes = []): string {
		$result = '';
		$dom = clone $this->dom;
		$icon = $dom->filter('#' . $name);
		if ($icon->count()) {
			$icon->removeAttribute('id');
			foreach ($attributes as $key => $value) {
				$icon->setAttribute($key, $value);
			}
			$symbol = $icon->saveHTML();
			$result = '<svg' . substr($symbol, 7, strlen($symbol) - 14) . 'svg>';
		}

		return $result;
	}
}
