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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;

/**
 * Determine the arguments passed to controller method.
 *
 * @author Mudzakkir <qaharmdz@gmail.com>
 */
class Argument implements ArgumentResolverInterface
{
    /**
     * @var \Symfony\Component\HttpKernel\Controller\ArgumentResolver
     */
    protected $resolver;

    public function __construct()
    {
        $this->resolver = new ArgumentResolver();
    }

    /**
     * Returns the arguments to pass to the controller.
     *
     * @param  Request  $request
     * @param  callable $controller
     *
     * @return array
     */
    public function getArguments(Request $request, $controller)
    {
        $attributes = $request->attributes->all();

        if (isset($attributes['_path'])) {
            $request->attributes->replace($this->parseAttributes($attributes));

            $arguments = [$request->attributes->get('params')];
        } else {
            $arguments = $this->resolver->getArguments($request, $controller);
        }

        return $arguments;
    }

    /**
     * Standardize attributes data
     *
     * @param  array  $data
     *
     * @return array
     */
    public function parseAttributes(array $data)
    {
        $params  = $this->cleanArgs($data);
        $sysinfo = [
            '_master_request' => $data['_master_request'],
            '_locale'         => $data['_locale'],
            '_path'           => $data['_path'],
            '_route'          => $data['_route'],
            '_controller'     => $data['_controller'],
        ];

        return [
            'params'    => $params,
            '_sysinfo'  => $sysinfo
        ];
    }


    /**
     * Remove arguments with underscore key
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
