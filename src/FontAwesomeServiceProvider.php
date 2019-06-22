<?php

namespace Jerodev\LaraFontAwesome;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Jerodev\LaraFontAwesome\Middleware\InjectStyleSheet;

class FontAwesomeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/fontawesome.php' => config_path('fontawesome.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__ . '/config/fontawesome.php', 'fontawesome'
        );

        $this->registerBladeDirectives();
        $this->registerMiddleware(InjectStyleSheet::class);
    }

    private function registerBladeDirectives()
    {
        Blade::directive('fa', function ($expression) {
            return BladeRenderer::renderGeneric($expression);
        });

        foreach (config('fontawesome.libraries') as $library) {
            Blade::directive('fa' . $library[0], function ($expression) use ($library) {
                return BladeRenderer::renderWithLibrary($expression, $library);
            });
        }
    }

    private function registerMiddleware($middleware)
    {
        if (config('fontawesome.middleware.all_requests')) {
            $this->app['router']->pushMiddlewareToGroup('web', $middleware);
        }
    }
}
