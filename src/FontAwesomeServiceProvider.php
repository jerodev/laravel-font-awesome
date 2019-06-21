<?php

namespace Jerodev\LaraFontAwesome;

use Illuminate\Support\ServiceProvider;

class FontAwesomeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::directive('fa', function ($expression) {
            return "<?php echo \Jerodev\LaraFontAwesome\IconRenderer::renderSvg($expression); ?>";
        });
    }
}