<?php

namespace Jerodev\LaraFontAwesome\Tests;

use Jerodev\LaraFontAwesome\FontAwesomeServiceProvider;
use Orchestra\Testbench\TestCase as TestBenchTestCase;

abstract class TestCase extends TestBenchTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            FontAwesomeServiceProvider::class,
        ];
    }
}