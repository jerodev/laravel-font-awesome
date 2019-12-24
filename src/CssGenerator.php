<?php

namespace Jerodev\LaraFontAwesome;

class CssGenerator
{
    /**
     * Add required css and style attributes to the svg string.
     *
     * @param string $svg The raw svg string.
     * @param string[] $css_classes Optional css classes to add to the svg node.
     *
     * @return string
     */
    public static function mutateSvg(string $svg, array $css_classes = []): string
    {
        $svg = self::addSvgClasses($svg, $css_classes);
        $svg = self::addPathAttributes($svg);

        return $svg;
    }

    /**
     * Inject the css classes into the svg node.
     *
     * @param string $svg The raw svg string.
     * @param string[] $css_classes Additional css classes to add.
     *
     * @return string
     */
    private static function addSvgClasses(string $svg, array $css_classes = []): string
    {
        $start = \strpos($svg, '<svg');
        $end = \strpos($svg, '>', $start);

        $css_classes = \implode(' ',
            \array_unique(
                \array_filter(
                    \array_merge(
                        self::getFontAwesomeCssClasses(\substr($svg, $start, $end - $start)),
                        $css_classes
                    )
                )
            )
        );

        return \substr_replace($svg, " class=\"$css_classes\"", $end, 0);
    }

    /**
     * Generates required font awesome css classes based on the svg string.
     *
     * @param string $svg The raw svg string.
     *
     * @return string[]
     */
    private static function getFontAwesomeCssClasses(string $svg): array
    {
        $css_classes = ['svg-inline--fa'];

        if (($start = \strpos($svg, 'viewBox="')) !== false) {
            $start += 9;
            $end = \strpos($svg, '"', $start);
            $numbers = \explode(' ', \substr($svg, $start, $end - $start));
            $w = $numbers[2] / $numbers[3] * 16;

            $css_classes[] = "fa-w-$w";
        }

        return $css_classes;
    }

    /**
     * Add attributes to the path nodes in the svg to copy styles.
     *
     * @param string $svg The raw svg string.
     *
     * @return string
     */
    private static function addPathAttributes(string $svg): string
    {
        return \str_replace('<path ', '<path fill="currentColor" ', $svg);
    }
}
