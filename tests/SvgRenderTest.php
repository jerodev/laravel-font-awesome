<?php

namespace Jerodev\LaraFontAwesome\Tests;

use Jerodev\LaraFontAwesome\Exceptions\MalformedViewBoxException;
use Jerodev\LaraFontAwesome\Models\Svg;

final class SvgRenderTest extends TestCase
{
    public function testMalformedViewBox(): void
    {
        $this->expectException(MalformedViewBoxException::class);

        $svg = new Svg('fa-href');
        $svg->view_box = [0, 0];
        $svg->render();
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

    public function testRenderHrefWithoutCssClasses(): void
    {
        $this->app['config']->set('fontawesome.font_awesome_css', false);

        $svg = new Svg('fa-href');
        $svg->view_box = [0, 0, 512, 512];

        $this->assertEquals(
            '<svg><use href="#fa-href"/></svg>',
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

    public function testRenderSvgWithoutCssClasses(): void
    {
        $this->app['config']->set('fontawesome.font_awesome_css', false);

        $svg = new Svg('fa-href');
        $svg->view_box = [0, 0, 512, 512];
        $svg->path = 'foo bar';

        $this->assertEquals(
            '<svg><symbol id="fa-href" viewBox="0 0 512 512"><path fill="currentColor" d="foo bar"/></symbol><use href="#fa-href"/></svg>',
            $svg->render()
        );
    }
}
