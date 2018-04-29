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

namespace Gubug\Resolver;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;

/**
 * Determine the controller from '_path' or 'controler' request attribute.
 *
 * @author Mudzakkir <qaharmdz@gmail.com>
 */
class Controller extends ControllerResolver
{
    /**
     * @var \Symfony\Component\HttpFoundation\ParameterBag
     */
    public $param;

    public function __construct(LoggerInterface $logger, ParameterBag $param)
    {
        parent::__construct($logger);

        $this->param = $param;
        $this->param->add([
            'baseNamespace' => '',
            'pathNamespace' => ''
        ]);
    }

    /**
     * Get controller from request
     *
     * @param  Request  $request
     *
     * @return callable|false A PHP callable representing the Controller,
     *                        or false if this resolver is not able to determine the controller
     */
    public function getController(Request $request)
    {
        if ($request->attributes->get('_path')) {
            try {
                $controller = $this->resolvePath($request);

                return [new $controller['class'], $controller['method']];
            } catch (\Exception $e) {
                return false;
            }
        }

        // Don't waste resource
        $controllerParam = $request->attributes->get('_controller');
        if (is_callable($controllerParam)) {
            return $controllerParam;
        }

        try {
            $controller = $this->resolve($controllerParam);

            return [new $controller['class'], $controller['method']];
        } catch (\Exception $e) {
            return parent::getController($request);
        }
    }

    protected function resolvePath(Request $request)
    {
        $pathNamespace = $this->param->get('pathNamespace');
        if (!$request->attributes->get('_master_request') && $request->attributes->get('_pathNamespace')) {
            $pathNamespace = $request->attributes->get('_pathNamespace');
        }

        $controller = $this->resolve($request->attributes->get('_path'), $request->attributes->all(), $pathNamespace);

        $request->attributes->replace($controller['arguments']);
        $request->attributes->set('_controller', [$controller['class'], $controller['method']]);

        return $controller;
    }

    /**
     * Determine controller from given path.
     *
     * @param  string $path
     * @param  array  $args
     * @param  string $namespace
     *
     * @return array
     */
    public function resolve(string $path, array $args = [], string $namespace = '')
    {
        $namespace = substr($namespace, 0, 1) == '\\' ? $namespace : $this->param->get('baseNamespace') . '\\' . $namespace;
        $segments = explode('/', trim($path, '/'));

        if (empty($segments[0])) {
            throw new \InvalidArgumentException('Empty "_path" segments parameter.');
        }

        $class     = $this->resolveClass($path, $namespace, $segments);
        $method    = $this->resolveMethod($segments);
        $arguments = $this->resolveArguments($args, $segments);

        return [
            'class'     => $class,
            'method'    => $method,
            'arguments' => $arguments
        ];
    }

    /**
     * @param  string $path
     * @param  string $namespace
     * @param  array  &$segments
     *
     * @return string
     */
    protected function resolveClass($path, $namespace, &$segments)
    {
        $folder = $class = ucwords(array_shift($segments));
        if (!empty($segments[0])) {
            $class = ucwords(array_shift($segments));
        }

        $class = implode('\\', [rtrim($namespace, '\\'), $folder, $class]);

        if (!class_exists($class)) {
            throw new \InvalidArgumentException(sprintf('Cannot find controller "%s" for path "%s".', $class, $path));
        }

        return $class;
    }

    /**
     * @param  array  &$segments
     *
     * @return string
     */
    protected function resolveMethod(&$segments)
    {
        if (count($segments) % 2 === 1 && !is_numeric($segments[0][0]) && substr($segments[0], 0, 2) !== '__') {
            return array_shift($segments);
        }

        return 'index';
    }

    /**
     * @param  array  $args
     * @param  array  &$segments
     *
     * @return string
     */
    protected function resolveArguments($args, &$segments)
    {
        // Remaining segments as arguments
        if (!empty($segments[0])) {
            $_args = [];
            foreach (array_chunk($segments, 2) as $pair) {
                $_args[$pair[0]] = $pair[1];
            }

            $args = array_replace($_args, $args);
        }

        return $args;
    }
}
