<?php
namespace Gubug\Test\Component;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\HttpFoundation\ParameterBag;

class RouterTest extends \PHPUnit\Framework\TestCase
{
    protected $router;

    protected function setUp()
    {
        $collection    = new RouteCollection();
        $routerContext = new RequestContext('', 'GET', 'www.example.com', 'https');
        $urlMatcher    = new UrlMatcher($collection, $routerContext);
        $urlGenerator  = new UrlGenerator($collection, $routerContext);
        $route         = function (...$params) {
            return new Route(...$params);
        };
        $param = new ParameterBag();


        $this->router = new \Gubug\Component\Router($collection, $route, $urlMatcher, $urlGenerator, $param);
    }

    protected function tearDown()
    {
        $this->router = null;
    }

    public function testInstance()
    {
        $this->assertInstanceOf('Gubug\Component\Router', $this->router);
    }

    public function testAddRoute()
    {
        $route = $this->router->newRoute('/foo', ['_locale' => 'en'], ['_locale' => 'en'], ['utf8' => true]);
        $this->router->addRoute('base', '/foo');

        $this->assertEquals(['base' => $route], $this->router->collection->all());
        $this->assertEquals($route, $this->router->collection->get('base'));
    }

    public function testExtract()
    {
        $this->router->addRoute('base', '/foo');
        $this->router->addRoute('basepath', '/', ['_path' => 'app/home']);

        $this->assertEquals(['_locale' => 'en', '_route' => 'base'], $this->router->extract('/foo'));
        $this->assertEquals(['_locale' => 'en', '_route' => 'basepath', '_path' => 'app/home'], $this->router->extract('/'));
    }

    public function testExtractException()
    {

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('No routes in collection.');

        $this->router->extract('/foo');
    }

    public function testUrlBuild()
    {
        $this->assertEquals('', $this->router->urlBuild('foo'));

        $this->router->addRoute('base', '/foo');
        $this->router->addRoute('app/test', '/test', ['_path' => 'app/test']);

        $this->assertEquals('https://www.example.com/foo', $this->router->urlBuild('base'));
        $this->assertEquals('https://www.example.com/test', $this->router->urlBuild('app/test'));
    }

    public function testUrlGenerate()
    {
        $this->router->addRoute('base', '/', ['_path' => 'app/home']);
        $this->router->addRoute('app/post', '/post/{id}', ['_path' => 'app/post']);
        $this->router->addRoute('dynamic', '/{_path}', ['_path' => 'app/home'], ['_path' => '.*']);

        $this->assertEquals('https://www.example.com/', $this->router->urlGenerate()); // base
        $this->assertEquals('https://www.example.com/post/2', $this->router->urlGenerate('app/post', ['id' => 2])); // post
        $this->assertEquals('https://www.example.com/app/test', $this->router->urlGenerate('app/test')); // dynamic
    }
}
