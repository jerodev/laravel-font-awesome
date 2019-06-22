<?php

namespace Tests;

use Jerodev\LaraFontAwesome\CssGenerator;
use PHPUnit\Framework\TestCase;

class CssGeneratorTest extends TestCase
{
    public function testFontAwesomeCss()
    {
        $svg = CssGenerator::mutateSvg('<svg viewBox="0 0 640 512">');

        $this->assertEquals('<svg viewBox="0 0 640 512" class="svg-inline--fa fa-w-20">', $svg);
    }

    public function testAditionalCss()
    {
        $svg = CssGenerator::mutateSvg('<svg viewBox="0 0 448 512">', ['fa-500px']);

        $this->assertEquals('<svg viewBox="0 0 448 512" class="svg-inline--fa fa-w-14 fa-500px">', $svg);
    }

    public function testNoViewBox()
    {
        $svg = CssGenerator::mutateSvg('<svg>');

        $this->assertEquals('<svg class="svg-inline--fa">', $svg);
    }
}
