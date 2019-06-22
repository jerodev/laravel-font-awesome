<?php

namespace Jerodev\LaraFontAwesome;

/**
 * Creates php code to be rendered to blade views.
 */
class BladeRenderer
{
    /**
     * Render icons without specifying the library.
     *
     * @param string $expression The parameter string passed to the blade directive.
     *
     * @return string
     */
    public static function renderGeneric(string $expression): string
    {
        return "<?php echo \Jerodev\LaraFontAwesome\IconRenderer::renderSvg($expression); ?>";
    }

    /**
     * Render icons from a specific library.
     *
     * @param string $expression The parameter string passed to the blade directive.
     * @param string $library    The library to get the icon from.
     *
     * @return string
     */
    public static function renderWithLibrary(string $expression, string $library): string
    {
        if (strpos($expression, ',') === false) {
            $expression .= ', null';
        }

        return "<?php echo \Jerodev\LaraFontAwesome\IconRenderer::renderSvg($expression, '$library'); ?>";
    }
}
