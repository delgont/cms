<?php

return [

    'menus' => [
        'main_menu' => 'main menu',
        'footer_menu' => 'footer menu',
        'top_bar_menu' => 'top bar menu'
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Default Page Keys
    |--------------------------------------------------------------------------
    | Each page must have a unique key eg home, about-us, services, contact-us
    | These page keys may used as labels on the navigation menu, but can be edited later
    */
    'pages' => [
        'home', 'about-us', 'services', 'blog', 'contact-us'
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Post types
    |--------------------------------------------------------------------------
    | Even though posts may be categorized futher, each post must belong to a specific type
    | Post types can also be entered manually via the cms keeping in mind that they must belong to specific pages or categories
    */
    'post_types' => [
        'blog post', 'service', 'team member'
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Categories -- used to categorise posts and any model that uses the Categorable trait
    |--------------------------------------------------------------------------
    */
    'categories' => [
        'laravel', 'php'
    ],

    'options' => [
        'option_key' => 'default-value-here'
    ],

    'templates' => [
        'web.templates.contact-us' => ['name' => 'Contact Us', 'preview' => 'img/templates/contact-us.png'],
        'web.templates.default-page' => ['name' => 'Default Page', 'preview' => 'img/templates/default-page.png']
    ],

    'sections' => [
        'web.sections.contact-us' => ['name' => 'Contact Us Section', 'preview' => 'img/templates/contact-us.png']
    ],


    'option_sidebar_link_routes' => [
        'web.settings'
    ],

];