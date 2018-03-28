<?php
return [
    'framework' => [
        'environment'    => 'live', // live, dev, test
        'envPath'        => realpath(__DIR__ . '/') . DS . '.env',
        'logPath'        => realpath(__DIR__ . '/Library/') . DS . 'error.log',

        'baseNamespace'  => 'Contoh\Front',
        'pathNamespace'  => 'Component',
        'mainController' => 'component/init',
        'errorHandler'   => 'component/error',
        'routePath'      => 'home', // Default URL _path for base and dynamic route
    ],
    'serviceProvider' => [

    ],
    'eventSubscriber' => [
        'Nav'
    ],
    'routeCollection' => [
        // @see Gubug\Component\Router::addRoute
    ]
];
