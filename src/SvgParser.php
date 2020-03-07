<?php

namespace Jerodev\LaraFontAwesome;

use Jerodev\LaraFontAwesome\Models\Svg;

final class SvgParser
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
        return \array_map(static function (string $part) {
            return \intval($part);
        }, \explode(' ', $str));
    }

    private function getAttribute(string $xml, string $attribute): ?string
    {
        $start = \strpos($xml, "{$attribute}=\"") + \strlen($attribute) + 2;
        if ($start === -1) {
            return null;
        }

        $end = \strpos($xml, '"', $start);

        return \substr($xml, $start, $end - $start);
    }
}
