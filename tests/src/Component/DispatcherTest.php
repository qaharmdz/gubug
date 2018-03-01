<?php
namespace Gubug\Test\Component;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\EventDispatcher\EventDispatcher;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;

class DispatcherTest extends \PHPUnit\Framework\TestCase
{
    protected $dispatcher;

    protected function setUp()
    {
        $controller = function () {
            return new Response('Hello');
        };

        $controllerResolver = $this->createMock('\Gubug\Resolver\Controller', ['getController', 'resolve']);
        $controllerResolver
            ->expects($this->any())
            ->method('getController')
            ->will($this->returnValue($controller));
        $controllerResolver
            ->expects($this->any())
            ->method('resolve')
            ->will($this->returnValue(['class' => 'Gubug\Test\Component\DispatcherController', 'method' => 'world']));

        $argumentResolver = $this->createMock('\Gubug\Resolver\Argument', ['getArguments']);
        $argumentResolver
            ->expects($this->any())
            ->method('getArguments')
            ->will($this->returnValue([]));

        $this->dispatcher = new \Gubug\Component\Dispatcher(new EventDispatcher(), $controllerResolver, new RequestStack(), $argumentResolver);
    }

    protected function tearDown()
    {
        $this->dispatcher = null;
    }

    public function testInstance()
    {
        $this->assertInstanceOf('Gubug\Component\Dispatcher', $this->dispatcher);
    }

    public function testHandle()
    {
        $response = $this->dispatcher->handle(new Request(), HttpKernelInterface::MASTER_REQUEST, false);

        $this->assertEquals('Hello', $response->getContent());
    }

    public function testSubRequest()
    {
        $response = $this->dispatcher->subRequest('/foo');

        $this->assertEquals('Hello', $response->getContent());
    }

    public function testController()
    {
        $response = $this->dispatcher->controller('/foo');

        $this->assertEquals('java coffee', $response->getContent());
    }
}

class DispatcherController
{
    public function world()
    {
        return new Response('java coffee');
    }
}
