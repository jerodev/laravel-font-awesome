<?php

return [

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
