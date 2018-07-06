<?php
/*
 * This file is part of the Gubug package.
 *
 * (c) Mudzakkir <qaharmdz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
}
