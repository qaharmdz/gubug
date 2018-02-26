<?php
/**
 * This is example to show Gubug features, not project architecture guide.
 */

// =========== Lets begin

$loader = require realpath(__DIR__ . '/../vendor/') . DIRECTORY_SEPARATOR . 'autoload.php';

$gubug = new Gubug\Framework();

$loader->addPsr4('Contoh\\', realpath(__DIR__ . '/Demo/'));

$gubug->init([
    'locale'      => 'en',                  // Default locale
    'locales'     => ['en','id','fr'],      // Avalaible languages
    'environment' => 'dev',                 // live, dev, test
    'route'       => [
        '_path'         => 'app/home',      // Default _path for base and dynamic route
    ],
    'dispatcher'  => [
        'namespace'     => 'Contoh',            // Match added Psr4 prefix
        'errorHandler'  => 'app/error/handle'   // Handle error
    ],
    'logfile'     => __DIR__ . DIRECTORY_SEPARATOR . 'error.log', // Log filepath
]);


// =========== Configuration

// === Session example
if (!$gubug->session->has('token')) {
    $gubug->session->set('token', md5(uniqid()));
}

// === Config example
$gubug->config->set('token', $gubug->session->get('token'));

// Add new config that not defined before
$gubug->config->set('baseURL', $gubug->request->getBaseUri());
$gubug->config->set('basePath', realpath(__DIR__ . '/Demo') . DIRECTORY_SEPARATOR);


// =========== Router

$gubug->router->addRoute('app/home/render', '/render', ['_path' => 'app/home/render']); // http://localhost:8080/render
$gubug->router->addRoute('app/home/test', '/test', ['_path' => 'app/home/test']); // http://localhost:8080/test

$gubug->router->addRoute(
    'app/home/post',                    // Route name, can be anything but recommended same as _path to make generate url easier
    '/post/{pid}/{cid}',                // Path format. No {_locale} mean "http://localhost:8080/id/post/11" is not going to work
    [                                   // Default paramater
        'pid' => 0,                         // 'pid' default value
        'cid' => '22_33',                   // purposely nonzero value
        '_path' => 'app/home/post',         // Controller path

        // Example extra parameter
        'custom' => 'data'                  // Non underscore parameter will be passed to controller
    ],
    [                                   // Parameter requirement (regex)
        'pid' => '\d+',                     // 'pid' parameter must digit
        'cid' => '^\d+[_\d+]*[^-_\D]+$'     // single digit or multiple digit separated by underscore, ex 1_2_3
    ],
    []                                  // Methods (GET, POST, PUT, DELETE) allowed. All allowed if pass empty array
);
// === Use _controller

$gubug->router->addRoute( // http://localhost:8080/closure
    'closure',
    '/closure/{test}',
    [
        'test' => '',
        '_controller' => function () use ($gubug) {
            return $gubug->response->setContent(
                'Gubug v' . $gubug::VERSION . ' encourage to use _path mapping to controller class to provide response, but valid callable is fine.'
            );
        }
    ]
);


$gubug->coreEvent();

// $masterAgent = new \Contoh\Init\Init();

$controller = $gubug->container['resolver.controller']->resolve('init');

$gubug->response = call_user_func([new $controller['class'], $controller['method']]);

$gubug->response->send();

$gubug->dispatcher->terminate($gubug->request, $gubug->response);
