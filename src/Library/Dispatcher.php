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

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request as libRequest;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * @author Mudzakkir <qaharmdz@gmail.com>
 */
class Dispatcher extends HttpKernel
{
    /**
     * @var \Symfony\Component\HttpFoundation\ParameterBag
     */
    public $param;

    public function __construct($event, $controllerResolver, $requestStack, $argumentResolver, ParameterBag $param)
    {
        parent::__construct($event, $controllerResolver, $requestStack, $argumentResolver);

        $this->param = $param;

        // Default parameter
        $this->param->add([
            'namespace' => ''
        ]);
    }

    public function handle(libRequest $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        if ($this->resolver instanceof Resolver\Controller) {
            $this->resolver->param->set('pathNamespace', $this->param->get('namespace'));
        }

        return parent::handle($request, $type, $catch);
    }
}
