<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Route prefix for accessing the admin panel for dlegont cms -- default dashboard
    |--------------------------------------------------------------------------
    */
    'route_prefix' => 'dashboard',

     /*
    |--------------------------------------------------------------------------
    | The middlewares that protect access to the CMS dashboard.
    | By default it uses web, and auth
    |
    | 'middlewares' => ['web', 'auth'],
    |--------------------------------------------------------------------------
    */
    'middlewares' => ['web', 'auth'],

    /*
    |--------------------------------------------------------------------------
    | The media dir in storage folder
    | By default all media is stored in media dir
    |--------------------------------------------------------------------------
    */
    'media_dir' => 'media',

     /*
    |--------------------------------------------------------------------------
    | Posts configuration options.
    |--------------------------------------------------------------------------
    */
    'post_type_limiter' => '-',
    'post_key_limiter' => '-',
    'order_posts_in' => 'desc',
    'posts_per_page' => '10',
    'make_posts_commentable' => true

];