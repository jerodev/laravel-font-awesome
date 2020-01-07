<?php

namespace Jerodev\LaraFontAwesome\Tests;

use Jerodev\LaraFontAwesome\CssGenerator;

class CssGeneratorTest extends TestCase
{
    /** @var CssGenerator */
    private $cssGenerator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cssGenerator = resolve(CssGenerator::class);
    }

    public function testFontAwesomeCss()
    {
        $svg = $this->cssGenerator->mutateSvg('<svg viewBox="0 0 640 512">');

        $this->assertEquals('<svg viewBox="0 0 640 512" class="svg-inline--fa fa-w-20">', $svg);
    }

    public function testAditionalCss()
    {
        $svg = $this->cssGenerator->mutateSvg('<svg viewBox="0 0 448 512">', ['fa-500px']);

        $this->assertEquals('<svg viewBox="0 0 448 512" class="svg-inline--fa fa-w-14 fa-500px">', $svg);
    }

    public function testNoViewBox()
    {
        $svg = $this->cssGenerator->mutateSvg('<svg>');

        $this->assertEquals('<svg class="svg-inline--fa">', $svg);
    }
}
