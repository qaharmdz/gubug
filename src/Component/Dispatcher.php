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

namespace Gubug\Component;

use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Convert request object to response.
 *
 * @author Mudzakkir <qaharmdz@gmail.com>
 */
class Dispatcher extends HttpKernel
{
    public function __construct($event, $controllerResolver, $requestStack, $argumentResolver)
    {
        parent::__construct($event, $controllerResolver, $requestStack, $argumentResolver);
    }

    /**
     * Handles a Request to convert it to a Response.
     *
     * @param  Request  $request
     * @param  int      $type
     * @param  boolean  $catch
     *
     * @return HttpFoundation\Response
     */
    public function handle(HttpFoundation\Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        $request->attributes->set('_master_request', $type === HttpKernelInterface::MASTER_REQUEST);

        return parent::handle($request, $type, $catch);
    }

    /**
     * Sub-request simulates URI request, including route parameter and event middleware
     *
     * @param  HttpFoundation\Request|string $path
     * @param  string                        $namespace
     *
     * @return HttpFoundation\Response
     */
    public function subRequest($path, string $namespace = '')
    {
        $request = $path;
        if (!$request instanceof HttpFoundation\Request) {
            $request = HttpFoundation\Request::create($path);
            $request->attributes->set('_pathNamespace', $namespace);
        }

        return $this->handle(
            $request,
            HttpKernelInterface::SUB_REQUEST,
            false
        );
    }

    /**
     * Resolve and call controller directly without middleware
     *
     * @param  string $path
     * @param  array  $args
     * @param  string $namespace
     *
     * @return mixed
     */
    public function controller(string $path, array $args = [], string $namespace = '')
    {
        $request = new HttpFoundation\Request();
        $request->attributes->set('_path', $path);
        $request->attributes->set('_pathNamespace', $namespace);

        if (false === $controller = $this->resolver->getController($request)) {
            throw new \LogicException($namespace . ' "' . $path . '" is not available.');
        }

        return call_user_func($controller, $args);
    }
}
