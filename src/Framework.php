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

    public function __construct(bool $init=true)
    {
        $this->container = new \Pimple\Container;
        $this->container->register(new ServiceProvider());

        if ($init) {
            $this->init();
        }
    }

    public function init()
    {
        $this->request    = $this->container['request'];
        $this->router     = $this->container['router'];
        $this->dispatcher = $this->container['dispatcher'];
        $this->response   = $this->container['response'];
        $this->config     = $this->container['config'];
        $this->event      = $this->container['event'];

        // Service configuration
        $this->container['router.context']->fromRequest($this->request);
        $this->container['router.context']->setBaseUrl($this->request->getBasePath());

        $this->response->prepare($this->request);
        $this->response->loadHeaders('html');
        $this->response->setStatusCode(200);

        // Container as base controller
        ServiceContainer::setContainer($this->container);
    }

    /**
     * Start session with configured options
     *
     * @param  array  $options Key at http://php.net/session.configuration, omit 'session.'
     */
    public function startSession(array $options=[])
    {
        $this->session = $this->container['session'];

        $this->session->setOptions($options);
        $this->session->start();
    }

    /**
     * Escapes a text for HTML.
     *
     * @param string $text         The input text to be escaped
     * @param int    $flags        The flags (@see htmlspecialchars)
     * @param string $charset      The charset
     * @param bool   $doubleEncode Whether to try to avoid double escaping or not
     *
     * @return string Escaped text
     */
    public function htmlEscape($text, $flags=ENT_QUOTES, $charset='UTF-8', $doubleEncode=true)
    {
        return trim(htmlspecialchars($text, $flags, $charset, $doubleEncode));
    }
}