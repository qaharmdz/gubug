<?php
return [
    // App configuration
    'app'           => [],

    // Framework configuration
    'system'        => [
        'namespace'     => [
            'component' => 'Contoh\App\Component',
            // 'module'    => 'Contoh\App\Module',
            // 'plugin'    => 'Contoh\App\Plugin',
            // 'theme'     => 'Contoh\App\Theme',
        ],
        'controller'    => [
            'main'      => 'Contoh\App\Component\Main::index',
            'error'     => 'Contoh\App\Component\Error::index',
            'default'   => 'Home' // 'Contoh\App\Component\Home\Home::index'
        ],
        'path'          => [
            'theme'     => realpath(__DIR__ . '/') . DS . 'App' . DS . 'Theme' . DS,
            'env'       => realpath(__DIR__ . '/') . DS . '.env',
            'log'       => realpath(__DIR__ . '/') . DS . 'error.log'
        ],
        'serviceProvider'   => [],
        'routeCollection'   => [
            // Parameter info available at "\Gubug\Component\Router::addRoute"
            [
                'page',                             // Route name
                '/page/{pid}/{cid}',                // Path format, ex. "example.com/page/11/21"
                [ // Default parameter
                    'pid' => 0,
                    'cid' => '0',
                    '_controller' => 'page'         // Controller for the path
                ],
                [ // Parameter requirement
                    'pid' => '\d+',                 // Second segment must digits
                    'cid' => '^\d+[_\d+]*[^-_\D]+$' // Third segment must digits in format "digit" or "digit_digit_*"
                ]
            ],
        ],
        'eventSubscriber'   => [],
    ]
];
