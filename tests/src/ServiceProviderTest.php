<?php
namespace Gubug\Test;

use Pimple\Container;

class ServiceProviderTest extends \PHPUnit\Framework\TestCase
{
    public function testRegister()
    {
        $container = new Container();

        $provider = new \Gubug\ServiceProvider();
        $provider->register($container);


        $this->assertInstanceOf('Symfony\Component\HttpFoundation\RequestStack', $container['request.stack']);
        $this->assertInstanceOf('Gubug\Component\Request', $container['request']);

        $this->assertInstanceOf('Symfony\Component\Routing\RouteCollection', $container['router.collection']);
        $this->assertTrue(is_callable($container['router.route']));
        $this->assertInstanceOf('Symfony\Component\Routing\Route', call_user_func($container['router.route'], '/'));
        $this->assertInstanceOf('Symfony\Component\Routing\RequestContext', $container['router.context']);
        $this->assertInstanceOf('Symfony\Component\Routing\Matcher\UrlMatcher', $container['router.matcher']);
        $this->assertInstanceOf('Symfony\Component\Routing\Generator\UrlGenerator', $container['router.generator']);
        $this->assertInstanceOf('Gubug\Component\Router', $container['router']);

        $this->assertInstanceOf('Gubug\Resolver\Controller', $container['resolver.controller']);
        $this->assertInstanceOf('Gubug\Resolver\Argument', $container['resolver.argument']);
        $this->assertInstanceOf('Gubug\Component\Dispatcher', $container['dispatcher']);

        $this->assertInstanceOf('Gubug\Component\Response', $container['response']);

        $this->assertInstanceOf('Gubug\Component\Session', $container['session']);
        $this->assertInstanceOf('Gubug\Component\Config', $container['config']);
    }
}
