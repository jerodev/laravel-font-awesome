<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Path to svg libraries
    |--------------------------------------------------------------------------
    |
    | This is the absolute path to the folder where the icon libraries
    | containing svg files is located.
    |
    */

    'icon_path' => __DIR__ . '/../../fortawesome/font-awesome/svgs/',

    /*
    |--------------------------------------------------------------------------
    | Font Awesome Libraries
    |--------------------------------------------------------------------------
    |
    | These are the font awesome libraries that will be available.
    | The order defined here is the order the libraries will be explored in
    | when using the @fa() directive.
    |
    */

    'libraries' => [
        'regular',
        'brands',
        'solid',
    ],

    /*
    |--------------------------------------------------------------------------
    | Middleware options
    |--------------------------------------------------------------------------
    |
    | The css injection middleware is required for all pages that have icons
    | on them. If you do not include the middleware it might break your page's
    | css.
    | By default you the middleware is added to the `web` middleware group.
    | It is also possible to disable this and add the middleware yourself.
    |
    */

    'middleware' => [

        'all_requests' => true,

    ],

];
