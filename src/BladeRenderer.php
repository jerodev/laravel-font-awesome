<?php

namespace Jerodev\LaraFontAwesome;

use Jerodev\LaraFontAwesome\Models\Icon;

/**
 * Creates php code to be rendered to blade views.
 */
class BladeRenderer
{
    /**
     * Render icons without specifying the library.
     *
     * @param string $expression The parameter string passed to the blade directive.
     * @param string $library Forcing the renderer to render the icon using this library.
     *
     * @return string|null
     */
    public static function renderGeneric(string $expression, ?string $library = null): ?string
    {
        $icon = self::parseExpression($expression, $library);

        if ($icon->isStatic()) {
            return resolve(IconRenderer::class)->renderSvg(
                $icon->getName(true),
                $icon->getCssClasses(true),
                $icon->getLibrary(true)
            );
        }

        return \implode([
            '<?php echo app(\'',
            IconRenderer::class,
            "')->renderSvg({$icon->getName()}, {$icon->getCssClasses()}, {$icon->getLibrary()}); ?>",
        ]);
    }

    /**
     * Parse a blade expression to an icon object.
     *
     * @param string $expression
     * @param string|null $library
     *
     * @return Icon
     */
    private static function parseExpression(string $expression, ?string $library = null): Icon
    {
        $part = '';
        $parts = [];
        $in_string = null;

        for ($i = 0; $i < \strlen($expression); $i++) {
            $char = $expression[$i];

            if ($char === ',' && \is_null($in_string)) {
                $parts[] = \trim($part);
                $part = '';
                continue;
            }

            if (\in_array($char, ['\'', '"'])) {
                if ($in_string === $char) {
                    $in_string = null;
                } else {
                    $in_string = $char;
                }
            }

            $part .= \trim($char);
        }

        $parts[] = $part;

        $icon = new Icon($parts[0], $library ? "'{$library}'" : 'null');
        switch (\count($parts)) {
            case 3:
                $icon->setForceSvgHref(filter_var($parts[2], FILTER_VALIDATE_BOOLEAN));
                // Fallthrough

            case 2:
                $icon->setCssClasses($parts[1]);
        }

        return $icon;
    }
}
