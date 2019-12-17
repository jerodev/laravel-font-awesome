<?php

namespace Jerodev\LaraFontAwesome\Tests;

use Jerodev\LaraFontAwesome\IconRenderer;

class IconRendererTest extends TestCase
{
    public function testRenderSvgWithClass()
    {
        $expected = '<svg viewBox="0 0 512 512" class="svg-inline--fa fa-w-16 foo-bar fa-circle"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200z"/></svg>';
        $circle = IconRenderer::renderSvg('circle', 'foo-bar');

        $this->assertEquals($expected, $circle);
    }

    public function testRenderWithLibrary()
    {
        $expected = '<svg viewBox="0 0 512 512" class="svg-inline--fa fa-w-16 fa-circle"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"/></svg>';
        $circle = IconRenderer::renderSvg('circle', null, 'solid');

        $this->assertEquals($expected, $circle);
    }

    /**
     *  @dataProvider svgTestCaseProvider
     */
    public function testResolveSvg(string $icon, ?string $result)
    {
        $this->assertEquals(
            \str_replace('<path fill="currentColor"', '<path', \preg_replace('/ class=".*?"/', '', IconRenderer::renderSvg($icon))),
            \str_replace(' xmlns="http://www.w3.org/2000/svg"', '', $result)
        );
    }

    public static function svgTestCaseProvider(): array
    {
        return [
            ['building', \trim(\file_get_contents(__DIR__ . '/../vendor/fortawesome/font-awesome/svgs/regular/building.svg'))],
            ['fa-laravel', \trim(\file_get_contents(__DIR__ . '/../vendor/fortawesome/font-awesome/svgs/brands/laravel.svg'))],
            ['fa fa-circle', \trim(\file_get_contents(__DIR__ . '/../vendor/fortawesome/font-awesome/svgs/regular/circle.svg'))],
            ['far fa-square', \trim(\file_get_contents(__DIR__ . '/../vendor/fortawesome/font-awesome/svgs/regular/square.svg'))],
            ['foo-bar', null],
        ];
    }
}
