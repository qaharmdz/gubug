<?php
/*
 * This file is part of the Gubug package.
 *
 * (c) A Qahar Mudzakkir <qaharmdz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gubug;

use Symfony\Component\Debug;
use Symfony\Component\HttpKernel\EventListener;

/**
 * The Gubug framework class.
 *
 * Don't think to hard, Gubug\Framework just a wrapper :)
 *
 * @author Mudzakkir <qaharmdz@gmail.com>
 */
class Framework
{
    const VERSION = '1.0.0-beta.2';

    /**
     * @var \Pimple\Container
     */
    public $container;

    /**
     * @var \Gubug\Component\Request
     */
    public $request;

    /**
     * @var \Gubug\Component\Router
     */
    public $router;

    /**
     * @var \Gubug\Component\Dispatcher
     */
    public $dispatcher;

    /**
     * @var \Gubug\Component\Response
     */
    public $response;

    /**
     * @var \Gubug\Component\Config
     */
    public $config;

    /**
     * @var \Gubug\Component\Event
     */
    public $event;

    /**
     * @var \Gubug\Component\Session
     */
    public $session;

    /**
     * @var \Symfony\Component\HttpKernel\Log\Logger
     */
    public $log;

    public function __construct()
    {
        $this->container = new \Pimple\Container;
        $this->container->register(new ServiceProvider());
    }

    /**
     * Initiialize process section
     *
     * Process separated into different method make it easy to use them separately
     *
     * @param  array  $config
     */
    public function init(array $config = [])
    {
        $this->initService($config);
        $this->initSession();
        $this->initApp();
    }

    public function initService(array $config = [])
    {
        // Configuration
        $this->config = $this->container['config'];
        $this->config->add(array_replace_recursive(
            [
                'environment'   => 'live',      // live, dev, test
                'path'          => [
                    'env'   => '',
                    'log'   => __DIR__ . DIRECTORY_SEPARATOR . 'error.log'
                ],
                'locale'        => 'en',        // Default locale
                'locales'       => ['en'],      // Avalaible languages
                'session'       => [            // Key at http://php.net/session.configuration, omit 'session.'
                    'name'  => '_gubug'
                ],
                'baseNamespace'     => '',      // Application namespace prefix
                'pathNamespace'     => '',      // Namespace prefix for _path route
                'mainController'    => '',      // Class as main agent of PAC
                'errorController'   => '',      // Class handle error page
                'defaultComponent'  => ''       // Default controller component
            ],
            $config
        ));

        // Environment config
        if ($this->config->get('path.env')) {
            $this->config->load($this->config->get('path.env'), 'env');
        }

        $this->config->set('debug', $this->config->getBoolean(
            'debug',
            in_array($this->config->get('environment'), ['dev', 'test'])
        ));

        // Service parameter
        $this->container['log.output'] = $this->config->get('path.log');
        $this->container['resolver.controller']->param->set('baseNamespace', $this->config->get('baseNamespace'));
        $this->container['resolver.controller']->param->set('pathNamespace', $this->config->get('pathNamespace'));

        // Services
        $this->request    = $this->container['request'];
        $this->router     = $this->container['router'];
        $this->dispatcher = $this->container['dispatcher'];
        $this->response   = $this->container['response'];

        $this->session    = $this->container['session'];
        $this->event      = $this->container['event'];
        $this->log        = $this->container['log'];
    }

    /**
     * Start session
     */
    public function initSession()
    {
        $this->session->setOptions($this->config->get('session', []));
        $this->session->start();
    }

    public function initApp()
    {
        ini_set('display_errors', 0);
        if ($this->config->get('debug')) {
            Debug\Debug::enable(E_ALL, true);
        }

        // Service setup
        $this->container['router.context']->fromRequest($this->request);
        $this->container['router.context']->setBaseUrl($this->request->getBasePath());

        $this->router->param->set('routeDefaults', ['_locale' => $this->config->get('locale')]);
        $this->router->param->set('routeRequirements', ['_locale' => implode('|', $this->config->get('locales'))]);

        $this->response->prepare($this->request);

        // Access to container
        ServiceContainer::setContainer($this->container);

        $this->baseRoute();
    }

    public function coreEvent()
    {
        $this->dynamicRoute();

        $this->event->addSubscriber(
            new EventListener\RouterListener(
                $this->router->urlMatcher,
                $this->container['request.stack'],
                $this->container['router.context']
            )
        );

        $this->event->addSubscriber(
            new EventListener\LocaleListener(
                $this->container['request.stack'],
                $this->config->get('locale'),
                $this->container['router.generator']
            )
        );

        if ($this->config->get('errorController')) {
            $controller = $this->container['resolver.controller']->resolve($this->config->get('errorController'), []);
            $object = [new $controller['class'], $controller['method']];

            if (is_callable($object)) {
                $this->event->addSubscriber(
                    new EventListener\ExceptionListener(
                        $object,
                        $this->log,
                        $this->config->get('debug')
                    )
                );
            }
        }
    }

    public function run()
    {
        $this->coreEvent();

        if ($this->config->get('mainController')) {
            $mainAgent = $this->container['resolver.controller']->resolve($this->config->get('mainController'), []);
            $this->response = call_user_func([new $mainAgent['class'], $mainAgent['method']]);
        } else {
            $this->response = $this->dispatcher->handle($this->request);
        }

        $this->response->send();

        $this->dispatcher->terminate($this->request, $this->response);
    }

    /**
     * Must be first registered into routeCollection
     */
    public function baseRoute()
    {
        $this->router->addRoute('base', '/', ['_path' => $this->config->get('defaultComponent')]);
        if (count($this->config->get('locales')) > 1) {
            $this->router->addRoute('base_locale', '/{_locale}/', ['_path' => $this->config->get('defaultComponent')]);
        }
    }

    /**
     * Fallback must be last registered at routeCollection
     */
    public function dynamicRoute()
    {
        if (count($this->config->get('locales')) > 1) {
            $this->router->addRoute('dynamic_locale', '/{_locale}/{_path}', ['_path' => $this->config->get('defaultComponent')], ['_path' => '.*']);
        }
        $this->router->addRoute('dynamic', '/{_path}', ['_path' => $this->config->get('defaultComponent')], ['_path' => '.*']);
    }
}
