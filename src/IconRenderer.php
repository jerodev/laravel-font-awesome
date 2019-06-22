<?php

namespace Jerodev\LaraFontAwesome;

class IconRenderer
{
    /**
     * Render a Font Awesome icon as an svg.
     *
     * @param string $icon The name of the icon.
     * @param string|null $css_classes Extra css classes to add to the svg.
     * @param string|null $library The icon library to use.
     * @return string|null
     */
    public static function renderSvg(string $icon, ?string $css_classes = null, ?string $library = null): ?string
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

        $svg = self::loadSvg($icon, $css_classes, $library);

        return $svg;
    }

    /**
     * Find the svg file for this icon and return its content.
     *
     * @param string $icon The name of the icon.
     * @param string|null $css_classes Aditional css classes to be added to the svg node.
     * @param string|null $library The icon library to use.
     * @return string|null
     */
    private static function loadSvg(string $icon, ?string $css_classes, ?string $library = null): ?string
    {
        $icon = self::normalizeIconName($icon);
        $css_classes .= " fa-$icon";

        $path_str = __DIR__ . '/../../../fortawesome/font-awesome/svgs/';
        if (!file_exists($path_str)) {
            $path_str = __DIR__ . '/../vendor/fortawesome/font-awesome/svgs/';
        }
        $path_str .= "%s/$icon.svg";

        $svg = null;
        foreach (['regular', 'brands', 'solid'] as $folder) {
            if ($library !== null && $folder !== $library) {
                continue;
            }

            $path = sprintf($path_str, $folder);

            if (file_exists($path)) {
                $svg = file_get_contents($path) ?: null;
                break;
            }
        }

        if ($svg !== null) {
            $svg = CssGenerator::mutateSvg($svg, explode(' ', $css_classes));
        }

        return $svg;
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
}