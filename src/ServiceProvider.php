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

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpKernel;
use Symfony\Component\Routing;

/**
 * Register all library to container
 *
 * @author Mudzakkir <qaharmdz@gmail.com>
 */
class ServiceProvider implements ServiceProviderInterface
{

    public function register(Container $container)
    {
        // === Request
        $container['request.stack'] = function () {
            return new HttpFoundation\RequestStack();
        };
        $container['request'] = function () {
            return Library\Request::createFromGlobals();
        };

        // === Router
        $container['router.collection'] = function () {
            return new Routing\RouteCollection();
        };
        $container['router.route'] = function () {
            return function (...$params) {
                return new \Symfony\Component\Routing\Route(...$params);
            };
        };
        $container['router.context'] = function () {
            return new Routing\RequestContext();
        };
        $container['router.matcher'] = function ($c) {
            return new Routing\Matcher\UrlMatcher($c['router.collection'], $c['router.context']);
        };
        $container['router.generator'] = function ($c) {
            return new Routing\Generator\UrlGenerator($c['router.collection'], $c['router.context']);
        };
        $container['router'] = function ($c) {
            return new Library\Router($c['router.collection'], $c['router.route'], $c['router.matcher'], $c['router.generator'], $c['config.factory']);
        };

        // === Dispatcher
        $container['resolver.controller'] = function ($c) {
            return new Resolver\Controller($c['log'], $c['config.factory']);
        };
        $container['resolver.argument'] = function () {
            return new Resolver\Argument();
        };
        $container['dispatcher'] = function ($c) {
            return new Library\Dispatcher($c['event'], $c['resolver.controller'], $c['request.stack'], $c['resolver.argument'], $c['config.factory']);
        };
        $container['event'] = function () {
            return new Library\Event();
        };

        // Response
        $container['response'] = function () {
            return new Library\Response();
        };

        // Tools
        $container['config.factory'] = $container->factory(function () {
            return new Library\Config();
        });
        $container['config'] = function ($c) {
            return $c['config.factory'];
        };

        $container['session'] = function () {
            return new Library\Session();
        };

        $container['log.output'] = '';
        $container['log'] = function ($c) {
            return new HttpKernel\Log\Logger(\Psr\Log\LogLevel::DEBUG, $c['log.output']);
        };
    }
}
