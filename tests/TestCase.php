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
    }

    protected function getPackageProviders($app)
    {
        return [
            FontAwesomeServiceProvider::class,
        ];
    }
}
