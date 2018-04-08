<?php
return [
    'framework' => [
        'environment'    => 'live', // live, dev, test
        'envPath'        => realpath(__DIR__ . '/') . DS . '.env',
        'logPath'        => realpath(__DIR__ . '/Library/') . DS . 'error.log',

        'test_array'     => realpath(__DIR__ . '/') . DS . 'test.php',
        'test_json'      => realpath(__DIR__ . '/') . DS . 'test.json',

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
        ['page', '/page/{pid}', ['pid' => 0, '_path' => 'page'], ['pid' => '\d+']],
        [
            'page/post',                            // Route name. Recommended same as "_path".
            '/post/{pid}/{cid}',                    // Path format.
            [
                'pid' => 0,
                'cid' => '0_0',
                '_path' => 'page/post'
            ],
            [
                'pid' => '\d+',
                'cid' => '^\d+[_\d+]*[^-_\D]+$'
            ]
        ]
    ]
];
