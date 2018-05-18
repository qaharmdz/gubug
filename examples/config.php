<?php
return [
    'app' => [
        'environment'       => 'live', // live, dev, test
        'path'              => [
            'env'   => realpath(__DIR__ . '/') . DS . '.env',
            'log'   => realpath(__DIR__ . '/Library/') . DS . 'error.log'
        ],
        'baseNamespace'     => 'Contoh\Front',
        'pathNamespace'     => 'Component',
        'mainController'    => 'component/init',
        'errorController'   => 'component/error',
        'defaultComponent'  => 'home', // Default URL _path for base and dynamic route
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
                'pid'   => 0,
                'cid'   => '0_0',
                '_path' => 'page/post'
            ],
            [
                'pid' => '\d+',
                'cid' => '^\d+[_\d+]*[^-_\D]+$'
            ]
        ]
    ]
];
