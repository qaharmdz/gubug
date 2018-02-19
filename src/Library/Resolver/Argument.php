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
Use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
Use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;

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
    	return $request->attributes->get('_route_args') ?: $this->resolver->getArguments($request, $controller);
    }
}