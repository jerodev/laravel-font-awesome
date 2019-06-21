<?php

namespace Tests;

use Jerodev\LaraFontAwesome\BladeRenderer;
use PHPUnit\Framework\TestCase;

class BladeRendererTest extends TestCase
{
    public function testFabRenderWithClass()
    {
        $render = BladeRenderer::renderWithLibrary('\'laravel\', \'spin\'', 'fab');

        $this->assertStringContainsString('(\'laravel\', \'spin\', \'fab\')', $render);
    }

    public function testFabRenderWithoutClass()
    {
        $render = BladeRenderer::renderWithLibrary('\'laravel\'', 'fab');

        $this->assertStringContainsString('(\'laravel\', null, \'fab\')', $render);
    }

    public function testFasRender()
    {
        $render = BladeRenderer::renderWithLibrary('\'circle\'', 'fas');

        $this->assertStringContainsString('(\'circle\', null, \'fas\')', $render);
    }
}