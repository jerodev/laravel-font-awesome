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
     *
     * @return string|null
     */
    public static function renderSvg(string $icon, ?string $css_classes = null, ?string $library = null): ?string
    {
        $icon = self::normalizeIconName($icon);

        $svg = self::loadSvg($icon, $library);
        if ($svg !== null) {
            $svg = CssGenerator::mutateSvg($svg, explode(' ', "$css_classes fa-$icon"));
            $svg = str_replace(' xmlns="http://www.w3.org/2000/svg"', '', $svg);
        }

        return $svg;
    }

    /**
     * Find the svg file for this icon and return its content.
     *
     * @param string $icon The name of the icon.
     * @param string|null $library The icon library to use.
     *
     * @return string|null
     */
    private static function loadSvg(string $icon, ?string $library = null): ?string
    {
        $svg = null;
        $path_str = config('fontawesome.icon_path') . "%s/$icon.svg";

        foreach (config('fontawesome.libraries') as $folder) {
            if ($library !== null && $folder !== $library) {
                continue;
            }

            $path = sprintf($path_str, $folder);
            if (file_exists($path)) {
                $svg = file_get_contents($path) ?: null;
                break;
            }
        }

        return $svg;
    }

    /**
     * Format an icon name to the one used in the Font Awesome repository.
     *
     * @param string $icon The icon name to normalize.
     *
     * @return string
     */
    private static function normalizeIconName(string $icon): string
    {
        $icon = trim($icon);

        // Remove library specification prefix from the string.
        if (substr($icon, 0, 2) === 'fa' && ($spos = strpos($icon, ' ')) !== false) {
            $icon = substr($icon, $spos + 1);
        }

        // Remove 'fa-' from the start of the string.
        if (substr($icon, 0, 3) === 'fa-') {
            $icon = substr($icon, 3);
        }

        return strtolower($icon);
    }
}
