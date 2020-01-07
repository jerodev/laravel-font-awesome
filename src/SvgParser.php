<?php

namespace Jerodev\LaraFontAwesome;

use Exception;
use Jerodev\LaraFontAwesome\Models\Svg;

class SvgParser
{
    public function parseXml(string $icon_id, string $xml): Svg
    {
        $svg = new Svg($icon_id);
        $svg->view_box = $this->parseViewBox(
            $this->getAttribute($xml, 'viewBox')
        );
        $svg->path = $this->getAttribute($xml, 'd');

        return $svg;
    }

    private function parseViewBox(string $str): array
    {
        $view_box = \array_map(static function (string $part) {
            return \intval($part);
        }, \explode(' ', $str));

        if (\count($view_box) !== 4) {
            throw new Exception("ViewBox should contain 4 numeric values split by spaces. Got \"{$str}\"");
        }

        return $view_box;
    }

    private function getAttribute(string $xml, string $attribute): ?string
    {
        $start = strpos($xml, "{$attribute}=\"") + strlen($attribute) + 2;
        if ($start === -1) {
            return null;
        }

        $end = strpos($xml, '"', $start);

        return substr($xml, $start, $end - $start);
    }
}
