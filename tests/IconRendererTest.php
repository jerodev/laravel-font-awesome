<?php

namespace Jerodev\LaraFontAwesome\Tests;

use Jerodev\LaraFontAwesome\IconRenderer;
use Jerodev\LaraFontAwesome\SvgParser;

class IconRendererTest extends TestCase
{
    /** @var IconRenderer */
    private $iconRenderer;

    /** @var SvgParser */
    private $svgParser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->iconRenderer = resolve(IconRenderer::class);
        $this->svgParser = resolve(SvgParser::class);
    }

    public function testConsecutiveIconRendering()
    {
        $icon_1 = $this->iconRenderer->renderSvg('laravel');
        $icon_2 = $this->iconRenderer->renderSvg('laravel');

        $this->assertStringContainsString('<path ', $icon_1);
        $this->assertStringNotContainsString('<path ', $icon_2);
    }

    public function testConsecutiveIconRenderingWithoutHref()
    {
        $this->app['config']->set('fontawesome.svg_href', false);

        $icon_1 = $this->iconRenderer->renderSvg('laravel');
        $icon_2 = $this->iconRenderer->renderSvg('laravel');

        $this->assertEquals($icon_1, $icon_2);
    }

    public function testRenderSvgWithClass()
    {
        $expected = '<svg class="foo-bar svg-inline--fa fa-w-16"><symbol id="fa-circle" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200z" /></symbol><use href="#fa-circle"/></svg>';
        $circle = $this->iconRenderer->renderSvg('circle', 'foo-bar');

        $this->assertEquals($expected, $circle);
    }

    public function testRenderWithLibrary()
    {
        $expected = '<svg class="svg-inline--fa fa-w-16"><symbol id="fas-circle" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z" /></symbol><use href="#fas-circle"/></svg>';
        $circle = $this->iconRenderer->renderSvg('circle', null, 'solid');

        $this->assertEquals($expected, $circle);
    }

    /**
     *  @dataProvider svgTestCaseProvider
     */
    public function testResolveSvg(string $icon, ?string $result)
    {
        $this->assertEquals(
            $result ? $this->svgParser->parseXml('fa-' . $this->iconRenderer->normalizeIconName($icon), $result)->render() : null,
            $this->iconRenderer->renderSvg($icon)
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
