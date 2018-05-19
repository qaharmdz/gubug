<?php
/*
 * This file is part of the Gubug package.
 *
 * (c) A Qahar Mudzakkir <qaharmdz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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

            $arguments = [$request->attributes->get('_route_params')];
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
            '_master_request' => $data['_master_request'] ?? false,
            '_locale'         => $data['_locale'] ?? 'en',
            '_route'          => $data['_route'] ?? '',
            '_path'           => $data['_path'] ?? '/',
            '_controller'     => $data['_controller'] ?? '/'
        ];

        return array_replace($params, [
            '_route_params' => $params,
            '_sysinfo'      => $sysinfo
        ]);
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
