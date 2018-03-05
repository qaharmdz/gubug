<?php
return [
    'framework' => [
        'environment'    => 'dev', // live, dev, test
        'baseNamespace'  => 'Contoh\Front\Component',
        'mainController' => 'boot/init',
        'errorHandler'   => 'boot/error',
        'routePath'      => 'home', // Default URL _path for base and dynamic route
        'logfile'        => realpath(__DIR__ . '/Library/') . DS . 'error.log',
    ],
    'listener'  => [],
    'route'     => [
        // @see Gubug\Component\Router::addRoute
    ]
];
