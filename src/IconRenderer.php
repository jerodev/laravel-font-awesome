<?php

namespace Jerodev\LaraFontAwesome;

class IconRenderer
{
    /**
     * Render a Font Awesome icon as an svg.
     *
     * @param string $icon The name of the icon.
     * @param string|null $classes Extra css classes to add to the svg.
     * * @param string|null $library The icon library to use.
     * @return string|null
     */
    public static function renderSvg(string $icon, ?string $classes = null, ?string $library = null): ?string
    {
        if ($library !== null) {
            switch ($library) {
                case 'fab':
                case 'b':
                    $library = 'brands';
                    break;

                case 'far':
                case 'r':
                    $library = 'regular';
                    break;

                case 'fas':
                case 's':
                    $library = 'solid';
                    break;
            }
        }

        $svg = self::loadSvg($icon, $library);

        if ($svg !== null && $classes !== null) {
            $svg = self::addSvgCssClasses($svg, $classes);
        }

        return $svg;
    }

    /**
     * Find the svg file for this icon and return its content.
     *
     * @param string $icon The name of the icon.
     * @param string|null $library The icon library to use.
     * @return string|null
     */
    private static function loadSvg(string $icon, ?string $library = null): ?string
    {
        $path_str = __DIR__ . '/../Font-Awesome/svgs/%s/' . self::normalizeIconName($icon) . '.svg';

        foreach (['regular', 'brands', 'solid'] as $folder) {
            if ($library !== null && $folder !== $library) {
                continue;
            }

            $path = sprintf($path_str, $folder);

            if (file_exists($path)) {
                return file_get_contents($path) ?: null;
            }
        }

        return null;
    }

    /**
     * Format an icon name to the one used in the Font Awesome repository.
     *
     * @param string $icon The icon name to normalize.
     * @return string
     */
    private static function normalizeIconName(string $icon): string
    {
        // Remove 'fa-' from the start of the string.
        if (substr($icon, 0, 3) === 'fa-') {
            $icon = substr($icon, 3);
        }

        return strtolower($icon);
    }

    /**
     * Append css classes to the svg element.
     *
     * @param string $svg The raw svg string.
     * @param string $classes The css classes to be appended.
     * @return string
     */
    private static function addSvgCssClasses(string $svg, string $classes): string
    {
        // Find the svg tag
        $start = strpos($svg, '<svg');
        $end = strpos($svg, '>', $start + 3);

        // Add classes to the end of the tag.
        return substr_replace($svg, " class=\"$classes\"", $end, 0);
    }
}