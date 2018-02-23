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
    const VERSION = '1.0.0-beta.0';

    /**
     * @var \Pimple\Container
     */
    public $container;

    /**
     * @var \Gubug\Library\Request
     */
    public $request;

    /**
     * @var \Gubug\Library\Request
     */
    public $router;

    /**
     * @var \Gubug\Library\Dispatcher
     */
    public $dispatcher;

    /**
     * @var \Gubug\Library\Response
     */
    public $response;

    /**
     * @var \Gubug\Library\Config
     */
    public $config;

    /**
     * @var \Gubug\Library\Event
     */
    public $event;

    /**
     * @var \Gubug\Library\Session
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
                'locale'        => 'en',                    // Default locale
                'locales'       => ['en'],                  // Avalaible languages
                'environment'   => 'live',                  // live, dev, test
                'session'       => [                        // Key at http://php.net/session.configuration, omit 'session.'
                    'name' => '_gubug'
                ],
                'route'         => [
                    '_path'         => 'app/init',          // Default URL _path for base and dynamic route
                ],
                'dispatcher'    => [
                    'namespace'     => '',
                    'error'         => 'app/error/handle'   // Fully qualified namespace
                ],
                'logfile'       => ''
            ],
            $config
        ));
        $this->config->set('debug', in_array($this->config->get('environment'), ['dev', 'test']));

        // Service parameter
        $this->container['log.output'] = $this->config->get('logfile');
        $this->container['resolver.controller']->param->set('namespace', $this->config->get('dispatcher.namespace'));

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
        // Converts all errors to exceptions
        Debug\ErrorHandler::register();
        Debug\ExceptionHandler::register($this->config->get('debug'));

        // Service parameter
        $this->container['router.context']->fromRequest($this->request);
        $this->container['router.context']->setBaseUrl($this->request->getBasePath());

        $this->router->param->set('routeDefaults', ['_locale' => $this->config->get('locale')]);
        $this->router->param->set('routeRequirements', ['_locale' => implode('|', $this->config->get('locales'))]);

        $this->response->prepare($this->request);
        $this->response->headers->set('Content-Type', 'text/html;');
        $this->response->setStatusCode(200);

        // Container as base controller
        ServiceContainer::setContainer($this->container);

        // First citizen of routeCollection
        $this->baseRoute();
    }

    public function coreEvent()
    {
        // Register last as route fallback
        $this->dynamicRoute();

        $this->event->addSubscriber(
            new EventListener\RouterListener(
                $this->router->extract($this->request->getPathInfo()),
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

        $this->event->addSubscriber(
            new EventListener\ExceptionListener(
                $this->config->get('dispatcher.errorHandler'),
                $this->log,
                $this->config->get('debug')
            )
        );
    }

    public function run()
    {
        $this->coreEvent();

        $this->response = $this->dispatcher->handle($this->request);

        $this->response->send();

        $this->dispatcher->terminate($this->request, $this->response);
    }

    /**
     * Must be first registered into routeCollection
     */
    public function baseRoute()
    {
        $this->router->addRoute('base', '/', ['_path' => $this->config->get('route._path')]);
        $this->router->addRoute('base_locale', '/{_locale}/', ['_path' => $this->config->get('route._path')]);
    }

    /**
     * Fallback must be last registered at routeCollection
     */
    public function dynamicRoute()
    {
        $this->router->addRoute('dynamic_locale', '/{_locale}/{_path}', ['_path' => $this->config->get('route._path')], ['_path' => '.*']);
        $this->router->addRoute('dynamic', '/{_path}', ['_path' => $this->config->get('route._path')], ['_path' => '.*']);
    }
}
