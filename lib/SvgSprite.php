<?php

namespace Theme;

class SvgSprite
{
  protected $xml;
  protected static $sprites;

  public function __construct(string $filePath)
  {
    $this->xml = simplexml_load_file($filePath);
    $this->xml->registerXPathNamespace('svg', 'http://www.w3.org/2000/svg');
  }

  public static function fromFile(string $filePath): SvgSprite
  {
    if (!isset(static::$sprites[$filePath])) {
      static::$sprites[$filePath] = new SvgSprite($filePath);
    }

    return static::$sprites[$filePath];
  }

  public function getIcon(string $name, array $attributes = []): string
  {
    $result = '';
    $icons = $this->xml->xpath(sprintf('//svg:svg[@id="%s"]', $name));
    if ($icons) {
      $icon = clone $icons[0];
      unset($icon['id']);
      foreach ($attributes as $key => $value) {
        $icon[$key] = $value;
      }
      $result = $icon->asXML();
    }

    return $result;
  }
}
