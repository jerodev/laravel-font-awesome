<?php

namespace Jerodev\LaraFontAwesome;

class IconRenderer
{
    /** @var CssGenerator */
    private $cssGenerator;

    /** @var string[] */
    private $rendered_icons = [];

    public function __construct(CssGenerator $css_generator)
    {
        $this->cssGenerator = $css_generator;
    }

    /**
     * Render a Font Awesome icon as an svg.
     *
     * @param string $icon The name of the icon.
     * @param string|null $css_classes Extra css classes to add to the svg.
     * @param string|null $library The icon library to use.
     * @param bool $force_svg_href Force rendering as svg use:href.
     *
     * @return string|null
     */
    public function renderSvg(string $icon, ?string $css_classes = null, ?string $library = null, bool $force_svg_href = false): ?string
    {
        $icon = $this->normalizeIconName($icon);

        $icon_id = 'fa' . ($library ? $library[0] : null) . "-{$icon}";
        if (\config('fontawesome.svg_href') && ($force_svg_href || \in_array($icon_id, $this->rendered_icons, true))) {
            return $this->renderSvgHref($icon_id, $css_classes);
        }

        $svg = $this->loadSvg($icon, $library);
        if ($svg !== null) {
            $svg = $this->cssGenerator->mutateSvg($svg, \explode(' ', "$css_classes fa-$icon"));

            if (\config('fontawesome.svg_href')) {
                $svg = \str_replace('xmlns="http://www.w3.org/2000/svg"', "id=\"{$icon_id}\"", $svg);
                $this->rendered_icons[] = $icon_id;
            } else {
                $svg = \str_replace(' xmlns="http://www.w3.org/2000/svg"', '', $svg);
            }
        }

        return $svg;
    }

    /**
     * Render an svg linking to an already existing svg in the DOM.
     *
     * @param string $icon_id
     * @param string|null $css_classes
     *
     * @return string
     */
    private function renderSvgHref(string $icon_id, ?string $css_classes = null): string
    {
        $css = null;
        if ($css_classes !== null) {
            $css = " class=\"{$css_classes}\"";
        }

        return "<svg{$css}><use href=\"#{$icon_id}\"/></svg>";
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
