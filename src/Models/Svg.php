<?php

namespace Jerodev\LaraFontAwesome\Models;

final class Svg
{
    /** @var string|null */
    public $css_classes;

    /** @var string */
    public $icon_id;

    /** @var string */
    public $path;

    /** @var int[]|null */
    public $view_box;

    public function __construct(string $icon_id, ?string $css_classes = null)
    {
        $this->icon_id = $icon_id;
        $this->css_classes = $css_classes;

        $this->view_box = null;
    }

    public function render(): string
    {
        $svg_viewBox = '';
        $symbol_start = '';
        $symbol_end = '';
        if (\config('fontawesome.svg_href')) {
            $symbol_start = "<symbol id=\"{$this->icon_id}\" viewBox=\"" . \implode(' ', $this->view_box) . '">';
            $symbol_end = "</symbol><use href=\"#{$this->icon_id}\"/>";
        } else {
            $svg_viewBox = ' viewBox="' . \implode(' ', $this->view_box) . '"';
        }

        return "<svg class=\"{$this->renderCssClasses()}\"{$svg_viewBox}>{$symbol_start}<path fill=\"currentColor\" d=\"{$this->path}\"/>{$symbol_end}</svg>";
    }

    public function renderAsHref(): string
    {
        return "<svg class=\"{$this->renderCssClasses()}\"><use href=\"#{$this->icon_id}\"/></svg>";
    }

    private function renderCssClasses(): string
    {
        $classes = \array_filter(\explode(' ', $this->css_classes));
        $classes[] = 'svg-inline--fa';
        $classes[] = 'fa-w-' . ($this->view_box[2] / $this->view_box[3] * 16);

        return \implode(' ', \array_unique($classes));
    }
}
