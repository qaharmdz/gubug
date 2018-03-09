<?php
return [
    'framework' => [
        'environment'    => 'dev', // live, dev, test
        // 'environment'    => 'live',
        'baseNamespace'  => 'Contoh\Front',
        'pathNamespace'  => 'Component',
        'mainController' => 'component/init',
        'errorHandler'   => 'component/error',
        'routePath'      => 'home', // Default URL _path for base and dynamic route
        'logfile'        => realpath(__DIR__ . '/Library/') . DS . 'error.log',
    ],
    'serviceProvider' => [

    ],
    'eventSubscriber' => [

    ],
    'routeCollection' => [
        // @see Gubug\Component\Router::addRoute
    ]
];
