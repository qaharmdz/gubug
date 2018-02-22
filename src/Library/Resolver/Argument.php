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

namespace Gubug\Library\Resolver;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;

/**
 * @author Mudzakkir <qaharmdz@gmail.com>
 */
class Argument implements ArgumentResolverInterface
{
    protected $resolver;

    public function __construct()
    {
        $this->resolver = new ArgumentResolver();
    }

    public function getArguments(Request $request, $controller)
    {
        $attributes = $request->attributes->all();

        if (isset($attributes['_route_params']) && isset($attributes['_path_params'])) {
            $attributes = array_replace($attributes, $attributes['_path_params']);
            $attributes['_route_params'] = $this->cleanArgs(
                array_replace(
                    $attributes['_route_params'],
                    $attributes['_path_params']
                )
            );
            $attributes['_sysinfo'] = [
                '_path'           => $attributes['_path'],
                '_route'          => $attributes['_route'],
                '_controller'     => $attributes['_controller'],
                '_master_request' => $attributes['_master_request'],
            ];

            // Consistent with Event Listener Route
            unset(
                $attributes['_path'],
                $attributes['_route'],
                $attributes['_controller'],
                $attributes['_master_request'],
                $attributes['_path_params']
            );

            $request->attributes->replace($attributes);

            $arguments = [$attributes['_route_params']];
        } else {
            $arguments = $this->resolver->getArguments($request, $controller);
        }

        return $arguments;
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
