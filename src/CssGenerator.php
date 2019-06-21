<?php

namespace Jerodev\LaraFontAwesome;

class CssGenerator
{
    /**
     * Add required css classes to the font awesome svg node.
     *
     * @param string $svg The raw svg string.
     * @param string[] $css_classes Optional css classes to add to the svg node.
     * @return string
     */
    public static function mutateSvg(string $svg, array $css_classes = []): string
    {
        $start = strpos($svg, '<svg');
        $end = strpos($svg, '>', $start);

        $css_classes = implode(' ',
            array_unique(
                array_filter(
                    array_merge(
                        self::getFontAwesomeCssClasses(substr($svg, $start, $end - $start)),
                        $css_classes
                    )
                )
            )
        );

        return substr_replace($svg, " class=\"$css_classes\"", $end, 0);
    }

    /**
     * Generates required font awesome css classes based on the svg string.
     *
     * @param string $svg The raw svg string.
     * @return string[]
     */
    private static function getFontAwesomeCssClasses(string $svg): array
    {
        $start = strpos($svg, 'viewBox="') + 9;
        $end = strpos($svg, '"', $start);
        $numbers = explode(' ', substr($svg, $start, $end - $start));
        $w = $numbers[2] / $numbers[3] * 16;

        return [
            'svg-inline--fa',
            "fa-w-$w"
        ];
    }
}