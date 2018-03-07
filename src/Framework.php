<?php
/*
 * Copyright (c) 2018 A. Qahar Mudzakkir
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
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
        $this->config->add(array_replace(
            [
                'locale'        => 'en',        // Default locale
                'locales'       => ['en'],      // Avalaible languages
                'environment'   => 'live',      // live, dev, test
                'session'       => [            // Key at http://php.net/session.configuration, omit 'session.'
                    'name' => '_gubug'
                ],
                'baseNamespace'     => '',      // Application namespace prefix
                'pathNamespace'     => '',      // Namespace prefix for _path route
                'mainController'    => '',
                'routePath'         => '',      // Default URL _path for base and dynamic route
                'errorHandler'      => '',
                'logfile'           => __DIR__ . DIRECTORY_SEPARATOR . 'error.log'
            ],
            $config
        ));
        $this->config->set('debug', in_array($this->config->get('environment'), ['dev', 'test']));

        // Service parameter
        $this->container['log.output'] = $this->config->get('logfile');
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
        // Handle errors and exceptions
        Debug\Debug::enable(E_ALL, $this->config->get('debug'));

        // Service setup
        $this->container['router.context']->fromRequest($this->request);
        $this->container['router.context']->setBaseUrl($this->request->getBasePath());

        $this->router->param->set('routeDefaults', ['_locale' => $this->config->get('locale')]);
        $this->router->param->set('routeRequirements', ['_locale' => implode('|', $this->config->get('locales'))]);

        $this->response->prepare($this->request);

        // Access to container
        ServiceContainer::setContainer($this->container);

        // First citizen of routeCollection
        $this->baseRoute();
    }

    public function coreEvent()
    {
        // Last citizen of routeCollection as fallback
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

        if ($this->config->get('errorHandler')) {
            $errorHandler = $this->container['resolver.controller']->resolve($this->config->get('errorHandler'), [], $this->config->get('pathNamespace'));

            $this->event->addSubscriber(
                new EventListener\ExceptionListener(
                    [new $errorHandler['class'], $errorHandler['method']],
                    $this->log,
                    $this->config->get('debug')
                )
            );
        }
    }

    public function run()
    {
        $this->coreEvent();

        if ($this->config->get('mainController')) {
            $mainAgent = $this->container['resolver.controller']->resolve($this->config->get('mainController'), [], $this->config->get('pathNamespace'));
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
        $this->router->addRoute('base', '/', ['_path' => $this->config->get('routePath')]);
        if (count($this->config->get('locales')) > 1) {
            $this->router->addRoute('base_locale', '/{_locale}/', ['_path' => $this->config->get('routePath')]);
        }
    }

    /**
     * Fallback must be last registered at routeCollection
     */
    public function dynamicRoute()
    {
        if (count($this->config->get('locales')) > 1) {
            $this->router->addRoute('dynamic_locale', '/{_locale}/{_path}', ['_path' => $this->config->get('routePath')], ['_path' => '.*']);
        }
        $this->router->addRoute('dynamic', '/{_path}', ['_path' => $this->config->get('routePath')], ['_path' => '.*']);
    }
}
