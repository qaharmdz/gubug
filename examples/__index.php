<?php
/**
 * This is example to show Gubug features, not project architecture guide.
 */

// =========== Lets begin

$loader = require realpath(__DIR__ . '/../vendor/') . DIRECTORY_SEPARATOR . 'autoload.php';

$gubug = new Gubug\Framework();

/*
$gubug->init();
$gubug->router->addRoute('base', '/', [
    'app'         => 'Gubug',
    '_controller' => function ($app) use ($gubug) {
        return $gubug->response->setContent(
            $app . ' encourage to use dynamic route "_path", but valid "_controller" callable is fine.'
        );
    }
]);
$gubug->run();

exit();
//*/

// Example of namespace in deep folder
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
// Namespace result for _path "app/home" is "Contoh\App\Home" map to path "Example/Demo/App/Home.php"


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
// Route collection used to generate url and map the incoming request.
// Gubug provide baseRoute for accessing base url and dynamicRoute as fallback

// _path use Gubug custom controller and arguments resolver (relative to namespace)
// _controller use Symfony controller and arguments resolver (fully qualified namespace or closure)
// If both _path and _controller available, resolver will use _path and abandon _controller


// === Dynamic Route
/*
- Assumed no "_controller" as default parameter, if no route match the request,
  dynamic route used to catch URL _path
- Map the "_path" into: folder/file-class/{method|index}/...args[key, val]
    - Arguments always in pair of key/value
    - Thus if separation of _path by "/" is odd number, Gubug assume there is specific method.
      Otherwise use default method "index"
- Custom route for:
  http://localhost:8080/post/11
    -- is equal to --
  http://localhost:8080/app/home/post/pid/11/cid/22_33/custom/data
 */

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

// === Contain example using simple render

$gubug->router->addRoute('app/home/render', '/render', ['_path' => 'app/home/render']); // http://localhost:8080/render
$gubug->router->addRoute('app/home/render_locale', '/{_locale}/render', ['_path' => 'app/home/render']); // http://localhost:8080/id/render

// === Contain example generated url

// Generated url will have this parameter automatically (Offcourse there is option to ignore it)
$gubug->router->param->set('buildParameters', ['token' => $gubug->config->get('token')]);

$gubug->router->addRoute('app/home/url', '/url', ['_path' => 'app/home/url']); // http://localhost:8080/url
$gubug->router->addRoute('app/home/url_locale', '/{_locale}/url', ['_path' => 'app/home/url']); // http://localhost:8080/id/url

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


// =========== Register new service
// This is how you add 3rd library for database, email, logger or others service you like

// Assume yu have "fzaninotto/faker" depedency
// $gubug->container['faker'] = function ($c) {
//     return Faker\Factory::create();
// };
// Usage: $gubug->container['faker']->name;


// =========== Register Event Listener

// addListener($eventName, $listener, $priority = 0) The higher priority number, the earlier called
$gubug->event->addListener('filter.home.renderData', $gubug->config->get('dispatcher.namespace') . '\App\EventListener::onHomeRenderData', 0);

// $gubug->event->addSubscriber(new \Contoh\App\EventSubscriber());
$class = $gubug->config->get('dispatcher.namespace') . '\App\EventSubscriber';
$gubug->event->addSubscriber(new $class());


// =========== Start application

$gubug->run();
