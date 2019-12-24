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

    'icon_path' => \base_path('/vendor/fortawesome/font-awesome/svgs/'),

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

];
