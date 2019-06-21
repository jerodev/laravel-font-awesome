<?php

namespace Tests;

use Jerodev\LaraFontAwesome\IconRenderer;
use PHPUnit\Framework\TestCase;

class IconRendererTest extends TestCase
{
    /**
     *  @dataProvider svgTestCaseProvider
     */
    public function testRenderSvg(string $icon, ?string $result)
    {
        $this->assertEquals(IconRenderer::renderSvg($icon), $result);
    }

    public function testRenderSvgWithClass()
    {
        $expected = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="foo-bar"><path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200z"/></svg>';
        $circle = IconRenderer::renderSvg('circle', 'foo-bar');

        $this->assertEquals($expected, $circle);
    }

    public static function svgTestCaseProvider(): array
    {
        return [
            ['building', file_get_contents(__DIR__ . '/../Font-Awesome/svgs/regular/building.svg')],
            ['fa-laravel', file_get_contents(__DIR__ . '/../Font-Awesome/svgs/brands/laravel.svg')],
            ['foo-bar', null],
        ];
    }
}