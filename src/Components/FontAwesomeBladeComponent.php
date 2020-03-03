<?php

namespace Jerodev\LaraFontAwesome\Components;

use Illuminate\View\Component;
use Jerodev\LaraFontAwesome\Exceptions\UnknownIconException;
use Jerodev\LaraFontAwesome\IconViewBoxCache;
use Jerodev\LaraFontAwesome\Models\Svg;
use Jerodev\LaraFontAwesome\SvgParser;

final class FontAwesomeBladeComponent extends Component
{
    /** @var string */
    public $name;

    /** @var string|null */
    public $library;

    /** @var string|null */
    public $class;

    /** @var IconViewBoxCache */
    private $cache;

    /** @var SvgParser */
    private $svgParser;

    /** @var string|null */
    private $renderedCache;

    public function __construct(IconViewBoxCache $cache, SvgParser $svgParser, string $name, ?string $library = null, ?string $class = null)
    {
        $this->cache = $cache;
        $this->svgParser = $svgParser;

        $this->name = $this->getCleanIconName($name);
        $this->library = $library;
        $this->class = $class;
    }

    public function render()
    {
        // Blade components are evaluated multiple times.
        // We need to make sure the output stays the same for consecutive renders of the same component.
        if ($this->renderedCache === null) {
            if (\config('fontawesome.svg_href') && $this->cache->has($this->name, $this->library)) {
                $svg = new Svg(
                    $this->cache->getIconId($this->name, $this->library),
                    $this->class,
                    $this->cache->get($this->name, $this->library)
                );

                return $svg->renderAsHref();
            }

            $svg = $this->findSvg();

            $this->cache->put($this->name, $this->library, $svg->view_box);
            $this->renderedCache = $svg->render();
        }

        return $this->renderedCache;
    }

    private function findSvg(): Svg
    {
        $svg = null;
        $path_str = \config('fontawesome.icon_path') . "%s/{$this->name}.svg";

        foreach (\config('fontawesome.libraries') as $folder) {
            if ($this->library !== null && $folder !== $this->library) {
                continue;
            }

            $path = \sprintf($path_str, $folder);
            if (\file_exists($path)) {
                $svg = \trim(\file_get_contents($path));
                break;
            }
        }

        if ($svg === null) {
            throw new UnknownIconException($this->name, $this->library);
        }

        return $this->svgParser->parseXml(
            $this->cache->getIconId($this->name, $this->library),
            $svg
        );
    }

    private function getCleanIconName(string $icon): string
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
