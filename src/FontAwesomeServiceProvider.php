<?php

namespace Jerodev\LaraFontAwesome;

use Illuminate\Support\ServiceProvider;

class FontAwesomeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/fontawesome.php' => \config_path('fontawesome.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__ . '/config/fontawesome.php', 'fontawesome'
        );

        $this->registerBladeDirectives();
    }

    private function registerBladeDirectives()
    {
        $this->app['blade.compiler']->directive('fa', function ($expression) {
            return BladeRenderer::renderGeneric($expression);
        });

        foreach (config('fontawesome.libraries') as $library) {
            $this->app['blade.compiler']->directive('fa' . $library[0], function ($expression) use ($library) {
                return BladeRenderer::renderGeneric($expression, $library);
            });
        }
    }
}
