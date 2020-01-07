<?php

namespace Jerodev\LaraFontAwesome;

use Jerodev\LaraFontAwesome\Models\Svg;

class IconRenderer
{
    /** @var int[][] */
    private $rendered_icons = [];

    /** @var SvgParser */
    private $svgParser;

    public function __construct(SvgParser $svgParser)
    {
        $this->svgParser = $svgParser;
    }

    /**
     * Render a Font Awesome icon as an svg.
     *
     * @param string $icon The name of the icon.
     * @param string|null $css_classes Extra css classes to add to the svg.
     * @param string|null $library The icon library to use.
     *
     * @return string|null
     */
    public function renderSvg(string $icon, ?string $css_classes = null, ?string $library = null): ?string
    {
        $icon = $this->normalizeIconName($icon);

        $icon_id = 'fa' . ($library ? $library[0] : null) . "-{$icon}";
        if (\config('fontawesome.svg_href') && \array_key_exists($icon_id, $this->rendered_icons)) {
            $svg = new Svg($icon_id, $css_classes);
            $svg->view_box = $this->rendered_icons[$icon_id];

            return $svg->renderAsHref();
        }

        $svg_str = $this->loadSvg($icon, $library);
        if ($svg_str !== null) {
            $svg = $this->svgParser->parseXml($icon_id, $svg_str);
            $svg->css_classes = $css_classes;

            $this->rendered_icons[$icon_id] = $svg->view_box;

            return $svg->render();
        }

        return null;
    }

    /**
     * Find the svg file for this icon and return its content.
     *
     * @param string $icon The name of the icon.
     * @param string|null $library The icon library to use.
     *
     * @return string|null
     */
    private function loadSvg(string $icon, ?string $library = null): ?string
    {
        $svg = null;
        $path_str = \config('fontawesome.icon_path') . "%s/$icon.svg";

        foreach (\config('fontawesome.libraries') as $folder) {
            if ($library !== null && $folder !== $library) {
                continue;
            }

            $path = \sprintf($path_str, $folder);
            if (\file_exists($path)) {
                $svg = \trim(\file_get_contents($path));
                break;
            }
        }

        return $svg;
    }

    /**
     * Inject a symbol element in the svg string containing the icon id.
     *
     * @param string $svg
     * @param string $icon_id
     *
     * @return string
     */
    private function injectSymbol(string $svg, string $icon_id): string
    {
        $pos = \strpos($svg, '>');
        $svg = \substr_replace($svg, "><symbol id=\"{$icon_id}\">", $pos, 1);

        $svg = \str_replace('</svg>', '</symbol></svg>', $svg);

        return $svg;
    }

    /**
     * Format an icon name to the one used in the Font Awesome repository.
     *
     * @param string $icon The icon name to normalize.
     *
     * @return string
     */
    public function normalizeIconName(string $icon): string
    {
        $icon = \trim($icon);

        // Remove library specification prefix from the string.
        if (\substr($icon, 0, 2) === 'fa' && ($spos = \strpos($icon, ' ')) !== false) {
            $icon = \substr($icon, $spos + 1);
        }

        // Remove 'fa-' from the start of the string.
        if (\substr($icon, 0, 3) === 'fa-') {
            $icon = \substr($icon, 3);
        }

        return \strtolower($icon);
    }
}
