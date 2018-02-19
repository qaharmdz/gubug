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

namespace Gubug\Library;

Use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Simple controller and arguments resolver
 *
 * @author Mudzakkir <qaharmdz@gmail.com>
 */
class Dispatcher
{
    /**
     * @var \Symfony\Component\HttpFoundation\ParameterBag
     */
    public $param;

    public function __construct(ParameterBag $param)
    {
        $this->param = $param;

        // Default parameter
        $this->param->add([
            'pathNamespace' => ''
        ]);
    }

    /**
     * Handles attributes Request and call related controller
     *
     * @param  array  $attributes Request attributes
     *
     * @return mixed
     */
    public function handle($attributes)
    {
        if (!empty($attributes['_controller'] && is_callable($attributes['_controller']))) {
            return call_user_func($attributes['_controller'], $this->cleanArgs($attributes));
        }

        if (!$attributes['_path']) {
            throw new \LogicException('Unable to look for the controller as the "_path" parameter is missing.');
        }

        list($controller, $arguments) = $this->resolve($attributes['_path'], $attributes);

        return call_user_func($controller, $arguments);
    }

    /**
     * Controller and arguments resolver
     *
     * @param  string $path      Request '_path' parameter
     * @param  array  $args      Request attrbutes
     * @param  string $namespace Override param pathNamespace
     *
     * @return array
     *
     * @throws \LogicException  Fail to act resolver
     */
    public function resolve(string $path, array $args=[], string $namespace=''): array
    {
        $namespace = $namespace ?: $this->param->get('pathNamespace');
        $segments = explode('/', trim($path, '/'));

        if (empty($segments[0])) {
            throw new \LogicException('The "_path" parameter is empty.');
        }

        // ==== Controller resolver
        $folder = $class = ucwords(array_shift($segments));
        if (!empty($segments[0])) {
            $class = ucwords(array_shift($segments));
        }

        $class = implode('\\', [rtrim($namespace, '\\'), $folder, $class]);

        if (!class_exists($class)) {
            throw new \LogicException(sprintf('Unable to find controller "%s" for path "%s".', $class, $path));
        }

        $controller = new $class();

        // Find method
        $method = 'index';
        if (!empty($segments[0])
            && count($segments) % 2 === 1
            && !is_numeric($segments[0][0])
            && substr($segments[0], 0, 2) !== '__') {
            $method = array_shift($segments);
        }

        if (!is_callable([$controller, $method])) {
            throw new \LogicException(sprintf('The controller "%s" for URI "%s" is not available.', $class . '::' . $method, $path));
        }

        // ==== Arguments resolver
        $args = $this->cleanArgs($args);

        // Remaining segments as args
        if (!empty($segments[0])) {
            $_args = [];
            foreach (array_chunk($segments, 2) as $pair) {
                $_args[$pair[0]] = $pair[1];
            }
            $args = array_replace($_args, $args);
        }

        return [
            [$controller, $method],
            $args
        ];
    }

    /**
     * Remove arguments member that start with underscore (private)
     *
     * @param  array $args
     *
     * @return array
     */
    public function cleanArgs(array $args)
    {
        return array_filter($args, function ($key) {
            return $key[0] !== '_';
        }, ARRAY_FILTER_USE_KEY);
    }
}