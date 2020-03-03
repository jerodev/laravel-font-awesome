<?php

namespace Jerodev\LaraFontAwesome\Tests;

use Jerodev\LaraFontAwesome\Models\Svg;
use Jerodev\LaraFontAwesome\SvgParser;

final class SvgParserTest extends TestCase
{
    /** @var SvgParser */
    private $svgParser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->svgParser = \resolve(SvgParser::class);
    }

    public function testMalformedViewBox(): void
    {
        $svg = new Svg('fa-href');
        $svg->view_box = [0, 0];

        $this->assertNull($svg->render());
        $this->assertNull($svg->renderAsHref());
    }

    public function testRenderHref(): void
    {
        $svg = new Svg('fa-href');
        $svg->view_box = [0, 0, 512, 512];

        $this->assertEquals(
            '<svg class="svg-inline--fa fa-w-16"><use href="#fa-href"/></svg>',
            $svg->renderAsHref()
        );
    }

    public function testRenderSvg(): void
    {
        $svg = new Svg('fa-href');
        $svg->view_box = [0, 0, 512, 512];
        $svg->path = 'foo bar';

        $this->assertEquals(
            '<svg class="svg-inline--fa fa-w-16"><symbol id="fa-href" viewBox="0 0 512 512"><path fill="currentColor" d="foo bar"/></symbol><use href="#fa-href"/></svg>',
            $svg->render()
        );
    }

    /**
     * @dataProvider svgParsingProvider
     * @param string $input The svg string to parse.
     * @param array $expected An array containing `viewBox`, `path_start` and `path_end`.
     */
    public function testSvgParsing(string $input, array $expected): void
    {
        $parsed = $this->svgParser->parseXml('icon', $input);

        $this->assertEquals($expected['viewBox'], $parsed->view_box);
        $this->assertStringStartsWith($expected['path_start'], $parsed->path);
        $this->assertStringEndsWith($expected['path_end'], $parsed->path);
    }

    public function svgParsingProvider()
    {
        yield [
            \trim(\file_get_contents(__DIR__ . '/../vendor/fortawesome/font-awesome/svgs/brands/laravel.svg')),
            [
                'viewBox' => [0, 0, 512, 512],
                'path_start' => 'M504.4,115',
                'path_end' => '.4v91.39h0Z',
            ],
        ];

        yield [
            \trim(\file_get_contents(__DIR__ . '/../vendor/fortawesome/font-awesome/svgs/solid/laugh-beam.svg')),
            [
                'viewBox' => [0, 0, 496, 512],
                'path_start' => 'M248 8C111',
                'path_end' => '.1 8.4 15.9 18z',
            ],
        ];
    }
}
