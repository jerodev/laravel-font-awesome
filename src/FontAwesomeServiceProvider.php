<?php

namespace Jerodev\LaraFontAwesome;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class FontAwesomeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::directive('fa', function ($expression) {
            return BladeRenderer::renderGeneric($expression);
        });

        Blade::directive('fab', function ($expression) {
            return BladeRenderer::renderWithLibrary($expression, 'fab');
        });

        Blade::directive('far', function ($expression) {
            return BladeRenderer::renderWithLibrary($expression, 'far');
        });

        Blade::directive('fas', function ($expression) {
            return BladeRenderer::renderWithLibrary($expression, 'fas');
        });
    }
}