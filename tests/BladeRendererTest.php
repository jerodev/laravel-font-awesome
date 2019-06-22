<?php

namespace Jerodev\LaraFontAwesome\Tests;

use Jerodev\LaraFontAwesome\BladeRenderer;

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

    public function testFabRenderWithVariable()
    {
        $render = BladeRenderer::renderWithLibrary('$expression', 'fab');

        $this->assertStringContainsString('($expression, null, \'fab\')', $render);
    }

    public function testFabRenderWithVariableAndClass()
    {
        $render = BladeRenderer::renderWithLibrary('$expression, \'spin\'', 'fab');

        $this->assertStringContainsString('($expression, \'spin\', \'fab\')', $render);
    }

    public function testFarRender()
    {
        $render = BladeRenderer::renderWithLibrary('\'circle\'', 'far');

        $this->assertStringContainsString('(\'circle\', null, \'far\')', $render);
    }

    public function testFasRender()
    {
        $render = BladeRenderer::renderWithLibrary('\'circle\'', 'fas');

        $this->assertStringContainsString('(\'circle\', null, \'fas\')', $render);
    }
}
