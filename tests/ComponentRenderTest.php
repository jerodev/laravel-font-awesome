<?php

namespace Jerodev\LaraFontAwesome\Tests;

use Jerodev\LaraFontAwesome\Components\FontAwesomeBladeComponent;
use Jerodev\LaraFontAwesome\IconViewBoxCache;
use Jerodev\LaraFontAwesome\SvgParser;

final class ComponentRenderTest extends TestCase
{
    public function testSimpleIconRender(): void
    {
        $component = $this->createComponent('circle');

        $this->assertEquals(
            '<svg class="svg-inline--fa fa-w-16"><symbol id="fa-circle" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200z"/></symbol><use href="#fa-circle"/></svg>',
            $component->render()
        );
    }

    public function testRenderMultipleLibraries(): void
    {
        $cache = new IconViewBoxCache();
        $component_1 = $this->createComponent('circle', $cache);
        $component_2 = $this->createComponent('circle', $cache);
        $component_2->library = 'solid';
        $component_3 = $this->createComponent('circle', $cache);

        $this->assertFalse($this->isHrefRender($component_1->render()));
        $this->assertFalse($this->isHrefRender($component_2->render()));
        $this->assertTrue($this->isHrefRender($component_3->render()));
    }

    public function testRenderSpecificLibrary(): void
    {
        $component = $this->createComponent('circle');
        $component->library = 'solid';

        $this->assertEquals(
            '<svg class="svg-inline--fa fa-w-16"><symbol id="fas-circle" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"/></symbol><use href="#fas-circle"/></svg>',
            $component->render()
        );
    }

    public function testUseHrefForConsecutiveIcons(): void
    {
        $cache = new IconViewBoxCache();
        $component_1 = $this->createComponent('circle', $cache);
        $component_2 = $this->createComponent('circle', $cache);

        $this->assertStringContainsString('<symbol id="fa-circle"', $component_1->render());
        $this->assertStringNotContainsString('<symbol id="fa-circle"', $component_2->render());
    }

    private function createComponent(string $icon, ?IconViewBoxCache $cache = null, ?SvgParser $svgParser = null): FontAwesomeBladeComponent
    {
        return new FontAwesomeBladeComponent(
            $cache ?? new IconViewBoxCache(),
            $svgParser ?? new SvgParser(),
            $icon
        );
    }

    private function isHrefRender(string $xml): bool
    {
        return \strpos($xml, '<symbol id="') === false;
    }
}
