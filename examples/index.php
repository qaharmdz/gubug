<?php

// Quick start run CLI command inside "/example" folder: php -S localhost:8080 then visit browser: http://localhost:8080
// If you have issue with quick start above, use http://localhost/gubug/example/

// d() is shortcut of Kint::dump()

/**
 * This is example to show Gubug features, not guide to your project architecture.
 */

// =========== Lets begin

$loader = require '../vendor/autoload.php';
$loader->addPsr4('Contoh\\', realpath(__DIR__ . '/Demo/'));  // Example of namespace in deep folder

$gubug = new Gubug\Framework();


// =========== Namespace prefix

$gubug->dispatcher->param->set('pathNamespace', 'Contoh'); // Match added Psr4 prefix
// Namespace result for _path "app/home" is "Contoh\App\Home" map to path "Example/Demo/App/Home.php"


// =========== Configuration

// Session example
$gubug->startSession(['name' => '_gubug']);
if (!$gubug->session->has('token')) {
    $gubug->session->set('token', md5(uniqid()));
}

// Config example
$gubug->config->add([
    'default' => [
        'token' => $gubug->session->get('token'),
        'path'  => 'app/home'
    ],
    'locale'  => 'en'
]);
$gubug->config->set('basePath', realpath(__DIR__ . '/Demo') . DIRECTORY_SEPARATOR);


// =========== Router
// Route collection used to generate url and map the incoming request.

// ======= Router setting

$gubug->router->param->add([
    'routeDefaults'     => ['_locale' => $gubug->config->get('locale')],        // Set default locale; auto inject to addRoute()
    'routeRequirements' => ['_locale' => 'en|id|fr'],                           // Set accepted locale; auto inject to addRoute()
    'buildLocale'       => false,                                               // Force url generate to use "_locale"
    'buildParameters'   => ['token' => $gubug->config->get('default.token')],   // Force url generate to add extra parameter
]);


// ======= Add route into collection
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
        '_controller' => function($args) use ($gubug) {
            return 'Gubug encourage to use _path mapping to controller class to provide response, but valid callable is fine.';
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

try {
    // d($gubug->router->extract($gubug->request->getPathInfo())); // Uncomment to see router extract result

    $gubug->request->attributes->add(
        $gubug->router->extract(
            $gubug->request->getPathInfo()
        )
    );

    // TODO: Event - No need to be polite, things was made to be broken.
    if ($gubug->request->attributes->get('_path') == 'app/home/post') {

        switch ($gubug->request->attributes->get('pid'))
        {
            case 21: // http://localhost:8080/post/21
                $gubug->response->redirect($gubug->request->getBaseUri() . 'app/home/post/pid/21');
                break;

            case 31: // http://localhost:8080/post/31
                // Abort request and send HTTP error
                $gubug->response->abort(500, 'Oops! Not allowed to visit post with #id 31');
                break;
        }
    }

    // Update locale for consistency
    $gubug->request->setLocale($gubug->request->attributes->get('_locale'));
    $gubug->config->set('locale', $gubug->request->getLocale());


    // Set response content
    $gubug->response->setContent(
        // Controller and argument resolver
        $gubug->dispatcher->handle($gubug->request->attributes->all())
    );



// } catch (\LogicException $e) {
// } catch (\RuntimeException $e) {

// Just catch all exception
} catch (\Exception $e) {

    if ($e->getCode()) {

        // 98,7% because of $response->abort()
        $gubug->response->setStatusCode($e->getCode())
                        ->setContent($e->getMessage());

    } else {

        $gubug->response->setStatusCode(404)
                        ->setContent('
                            <h1>Oops! An Error Occured</h1>
                            <h3>The server return a "404 Not Found" message.</h3>
                        ')
                        ->appendContent('<br>Exception: ' . $e->getMessage());
    }

    /*
    // Use controller to handle 404 Not Found
    $gubug->response->setContent(
        $gubug->dispatcher->handle(['_path' => 'error/notfound']])
    );
     */
}


echo $gubug->response->send();


// Uncomment to see $gubug instance
/*
echo '
<hr style="margin:60px 0 40px;border:none;border-top:1px solid #888;">
<div style="padding:0 40px;">';

d($gubug);

echo '</div>';
//*/