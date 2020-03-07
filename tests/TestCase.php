<?php

namespace Jerodev\LaraFontAwesome\Tests;

use Jerodev\LaraFontAwesome\FontAwesomeServiceProvider;
use Orchestra\Testbench\TestCase as TestBenchTestCase;

abstract class TestCase extends TestBenchTestCase
{
    protected function getEnvironmentSetUp($app)
    {
        // When testing, the icons reside in the vendor folder
        $app['config']->set('fontawesome.icon_path', __DIR__ . '/../vendor/fortawesome/font-awesome/svgs/');

        // Tests assume svg_href is on by default
        $app['config']->set('fontawesome.svg_href', true);

        // Tests assume font_awesome_css is on by default
        $app['config']->set('fontawesome.font_awesome_css', true);
    }

    protected function getPackageProviders($app)
    {
        return [
            FontAwesomeServiceProvider::class,
        ];
    }
}
