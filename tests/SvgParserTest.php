<?php

namespace Jerodev\LaraFontAwesome\Tests;

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
