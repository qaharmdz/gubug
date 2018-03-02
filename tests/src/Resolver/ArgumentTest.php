<?php
namespace Gubug\Test\Resolver;

use Psr\Log\LogLevel;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArgumentTest extends \PHPUnit\Framework\TestCase
{
    protected $request;
    protected $resolver;

    protected function setUp()
    {
        $this->request  = Request::create('/');
        $this->resolver = new \Gubug\Resolver\Argument();
    }

    protected function tearDown()
    {
        $this->request = null;
        $this->resolver = null;
    }

    public function testInstance()
    {
        $this->assertInstanceOf('Gubug\Resolver\Argument', $this->resolver);
    }

    public function testGetArguments()
    {
        $request = Request::create('/');
        $request->attributes->set('_path', 'slug');
        $request->attributes->set('foo', 'world');
        $request->attributes->set('bar', 'coffee');

        $actual = $this->resolver->getArguments($request, null);
        $expect = [[
                'foo' => 'world',
                'bar' => 'coffee'
        ]];

        // All arguments passed to first method parameter
        $this->assertEquals($expect, $actual);
    }

    public function testGetArgumentsNotPath()
    {
        $request = Request::create('/');
        $request->attributes->set('foo', 'world');
        $request->attributes->set('bar', 'coffee');
        $controller = array($this, 'controllerWithFooAndDefaultBar');

        $result = $this->resolver->getArguments($request, $controller);

        // Arguments passed per method parameter
        $this->assertEquals(['world', 'coffee'], $result);
    }

    private function controllerWithFooAndDefaultBar($foo, $bar = null) {}
}
