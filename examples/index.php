<?php

// Quick start run CLI command inside "/example" folder: php -S localhost:8080 then visit browser: http://localhost:8080
// If you have issue with quick start above, use http://localhost/gubug/example/

// d() is shortcut of Kint::dump()

/**
 * This is example to show Gubug features, not guide to your project architecture.
 */

// =========== Lets begin

$loader = require realpath(__DIR__ . '/../vendor/') . DIRECTORY_SEPARATOR . 'autoload.php';
$loader->addPsr4('Contoh\\', realpath(__DIR__ . '/Demo/'));  // Example of namespace in deep folder

$gubug = new Gubug\Framework('dev');


// =========== Namespace prefix

$gubug->dispatcher->param->set('namespace', 'Contoh'); // Match added Psr4 prefix
// Namespace result for _path "app/home" is "Contoh\App\Home" map to path "Example/Demo/App/Home.php"


// =========== Configuration

// === Session example
$gubug->startSession(['name' => '_gubug']);
if (!$gubug->session->has('token')) {
    $gubug->session->set('token', md5(uniqid()));
}

// === Config example
$gubug->config->add([
    'default' => [
        'token' => $gubug->session->get('token'),
        'path'  => 'app/home'
    ],
    'locale'  => 'en' // assuming default locale
]);
$gubug->config->set('basePath', realpath(__DIR__ . '/Demo') . DIRECTORY_SEPARATOR);

// === Router setting

$gubug->router->param->add([
    'routeDefaults'     => ['_locale' => $gubug->config->get('locale')],        // Set default locale; auto inject to addRoute()
    'routeRequirements' => ['_locale' => 'en|id|fr'],                           // Set accepted locale; auto inject to addRoute()
    'buildLocale'       => false,                                               // Force url generate to use "_locale"
    'buildParameters'   => ['token' => $gubug->config->get('default.token')],   // Force url generate to add extra parameter
]);


// =========== Router
// Route collection used to generate url and map the incoming request.

// === Base route

$gubug->router->addRoute('base', '/', ['_path' => $gubug->config->get('default.path')]); // http://localhost:8080
$gubug->router->addRoute('base_locale', '/{_locale}/', ['_path' => $gubug->config->get('default.path')]); // http://localhost:8080/id

// === Custom Route

// http://localhost:8080/post/11
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

// === Custom route with locale

$gubug->router->addRoute('app/home/render', '/render', ['_path' => 'app/home/render']); // http://localhost:8080/render
$gubug->router->addRoute('app/home/render_locale', '/{_locale}/render', ['_path' => 'app/home/render']); // http://localhost:8080/id/render

// === Custom callback
$gubug->router->addRoute( // http://localhost:8080/closure
    'closure',
    '/closure/{test}',
    [
        'test' => '',
        '_controller' => function () use ($gubug) {
            return $gubug->response->setContent('Gubug encourage to use _path mapping to controller class to provide response, but valid callable is fine.');
        }
    ]
);

// === Dynamic route

$gubug->router->addRoute('dynamic_locale', '/{_locale}/{_path}', ['_path' => $gubug->config->get('default.path')], ['_path' => '.*']);
$gubug->router->addRoute('dynamic', '/{_path}', ['_path' => $gubug->config->get('default.path')], ['_path' => '.*']);

/*
Info:
Gubug dispatcher developed for the Dynamic Route in mind:
    - If no route match the request, dynamic route used to catch URL path
    - Map the "_path" into: folder/file-class/{method|index}/...args[key, val]
        - Arguments always in pair of key/value
        - Thus if separation of _path by "/" is odd number, Gubug assume there is specific method. Otherwise use default method "index"
    - Custom route above:
      http://localhost:8080/post/11
        -- is equal to --
      http://localhost:8080/app/home/post/pid/11/cid/22_33/custom/data
 */

// === Generate URL from route
// @see "app/home/url" or visit http://localhost:8080/app/home/url


// =========== Register new service
// This is how you add 3rd library for database, email, logger or others service you like

$gubug->container['faker'] = function ($c) {
    return Faker\Factory::create();
};


// =========== Front controller



$gubug->run();

// Uncomment to see $gubug instance
/*
echo '
<hr style="margin:60px 0 40px;border:none;border-top:1px solid #888;">
<div style="padding:0 40px;">';

d($gubug);

echo '</div>';
//*/
