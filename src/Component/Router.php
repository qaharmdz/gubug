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

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Wrap Symfony routing under one roof
 *
 * @author Mudzakkir <qaharmdz@gmail.com>
 */
class Router
{
    /**
     * @var \Symfony\Component\Routing\RouteCollection
     */
    public $collection;

    /**
     * @var callable \Symfony\Component\Routing\Route
     */
    public $route;

    /**
     * @var \Symfony\Component\Routing\Matcher\UrlMatcher
     */
    public $urlMatcher;

    /**
     * @var \Symfony\Component\Routing\Generator\UrlGenerator
     */
    public $urlGenerator;

    /**
     * @var \Symfony\Component\HttpFoundation\ParameterBag
     */
    public $param;

    public function __construct(RouteCollection $collection, $route, UrlMatcher $urlMatcher, UrlGenerator $urlGenerator, ParameterBag $param)
    {
        $this->collection   = $collection;
        $this->route        = $route;
        $this->urlMatcher   = $urlMatcher;
        $this->urlGenerator = $urlGenerator;
        $this->param        = $param;

        $this->param->add([
            'routeDefaults'     => ['_locale' => 'en'], // Default addRoute
            'routeRequirements' => ['_locale' => 'en'], // Requirement addRoute, multi-language en|id|fr
            'buildLocale'       => false,               // Force urlBuild to use "_locale"
            'buildParameters'   => []                   // Force urlBuild to add extra parameter
        ]);
    }

    /**
     * Add route into collection.
     *
     * @param string          $name         Route name
     * @param string          $path         The path pattern to match
     * @param array           $defaults     An array of default parameter values
     * @param array           $requirements An array of requirements for parameters (regexes)
     * @param string|string[] $methods      A required HTTP method or an array of restricted methods
     * @param array           $options      An array of options
     * @param string          $host         The host pattern to match
     * @param string|string[] $schemes      A required URI scheme or an array of restricted schemes
     * @param string          $condition    A condition that should evaluate to true for the route to match
     */
    public function addRoute(string $name, string $path, array $defaults = [], array $requirements = [], $methods = [], array $options = ['utf8' => true], ?string $host = '', $schemes = [], ?string $condition = '')
    {
        $route = $this->newRoute(
            $path,
            array_replace($defaults, $this->param->get('routeDefaults')),
            array_replace($requirements, $this->param->get('routeRequirements')),
            $options,
            $host,
            $schemes,
            $methods,
            $condition
        );

        $this->collection->add($name, $route);
    }

    /**
     * Helper on using router route to add collection
     *
     * @param  mixed $params
     *
     * @return \Symfony\Component\Routing\Route
     */
    public function newRoute(...$params)
    {
        return call_user_func($this->route, ...$params);
    }

    /**
     * Match URL path with a route in collection then extract their attribute.
     *
     * @return \Symfony\Component\Routing\Matcher\UrlMatcher
     *
     * @throws \RuntimeException  If routing collection or resource not found
     */
    public function extract($path)
    {
        if (!$this->collection->count()) {
            throw new \RuntimeException('No routes in collection.');
        }

        return $this->urlMatcher->match($path);
    }

    /**
     * Generate url by route name
     *
     * @param  string $name       Route name
     * @param  array  $parameters Route parameter
     * @param  bool   $extraParam Should extra parameter appended, mostly url token
     *
     * @return string
     */
    public function urlBuild(string $name, array $parameters = [], bool $extraParam = true)
    {
        $result = '';

        // Check to avoid exception error
        if ($this->collection->get($name)) {
            $name = $this->param->get('buildLocale') ? preg_replace('/_locale$/', '', $name) . '_locale' : $name;
            $parameters = $extraParam ? array_replace($parameters, $this->param->get('buildParameters')) : $parameters;

            $result = $this->urlGenerator->generate($name, $parameters, UrlGenerator::ABSOLUTE_URL);
        }

        return $result;
    }

    /**
     * Helper to automatically check route $name in urlBuild
     *
     * @param  string $path       Route path
     * @param  array  $parameters Route parameter
     * @param  bool   $extraParam Append extra parameter?
     *
     * @return string
     */
    public function urlGenerate(string $path = '', array $parameters = [], bool $extraParam = true)
    {
        if (!$path) {
            return $this->urlBuild('base', $parameters, $extraParam);
        }
        if ($this->collection->get($path)) {
            return $this->urlBuild($path, $parameters, $extraParam);
        }

        $parameters['_path'] = $path;

        return $this->urlBuild('dynamic', $parameters, $extraParam);
    }
}
