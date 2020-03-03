<?php

namespace Jerodev\LaraFontAwesome;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Jerodev\LaraFontAwesome\Components\FontAwesomeBladeComponent;

final class FontAwesomeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/fontawesome.php' => \config_path('fontawesome.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__ . '/config/fontawesome.php',
            'fontawesome'
        );

        $this->registerComponents();
        $this->registerDependencies();
    }

    private function registerComponents(): void
    {
        Blade::component(
            FontAwesomeBladeComponent::class,
            $this->app->get('config')->get('fontawesome.component_name')
        );
    }

    private function registerDependencies(): void
    {
        $this->app->singleton(IconViewBoxCache::class);
        $this->app->singleton(SvgParser::class);
    }
}
