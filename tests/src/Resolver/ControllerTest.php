<?php
namespace Gubug\Test\Resolver;

use Psr\Log\LogLevel;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ControllerTest extends \PHPUnit\Framework\TestCase
{
    protected $request;
    protected $resolver;
    protected $logger;

    protected function setUp()
    {
        $this->tmpFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'log';
        $this->logger = new Logger(LogLevel::DEBUG, $this->tmpFile);

        $param  = new \Symfony\Component\HttpFoundation\ParameterBag();

        $this->request  = Request::create('/');
        $this->resolver = new \Gubug\Resolver\Controller($this->logger, $param);

        $this->resolver->param->set('namespace', 'Gubug\Test');
    }

    protected function tearDown()
    {
        $this->request = null;
        $this->resolver = null;

        if (!@unlink($this->tmpFile)) {
            file_put_contents($this->tmpFile, '');
        }
    }

    public function testInstance()
    {
        $this->assertInstanceOf('Gubug\Resolver\Controller', $this->resolver);
    }

    public function testGetControllerPath()
    {
        $this->request->attributes->add([
            '_master_request' => true, // Todo: remove
            '_path' => 'resolver/controller'
        ]);

        $result = $this->resolver->getController($this->request);

        $this->assertEquals([new Controller(), 'index'], $result);
    }

    public function testGetControllerPathArgs()
    {
        $this->request->attributes->add([
            '_master_request' => true,
            '_path' => 'resolver/controller/foo/bar/baz'
        ]);

        $result = $this->resolver->getController($this->request);

        $this->assertEquals([new Controller(), 'foo'], $result);
    }

    public function testGetControllerSubRequest()
    {
        $this->request->attributes->add([
            '_master_request' => false,
            '_controller' => 'resolver/controller/foo'
        ]);

        $result = $this->resolver->getController($this->request);

        $this->assertEquals([new Controller(), 'foo'], $result);
    }

    public function testGetControllerFallback()
    {
        $this->request->attributes->add([
            '_master_request' => true,
            '_controller' => 'Gubug\Test\Resolver\Controller::foo'
        ]);

        $result = $this->resolver->getController($this->request);

        $this->assertEquals('Gubug\Test\Resolver\Controller::foo', $result);
    }

    public function testGetControllerPathException()
    {
        $this->request->attributes->add([
            '_master_request' => true,
            '_path' => 'resolver/controller/boo'
        ]);

        $this->resolver->getController($this->request);

        $this->assertContains('for URI "resolver/controller/boo" is not available.', $this->getLogs()[0]);
    }

    public function testGetControllerSubRequestException()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->request->attributes->add([
            '_master_request' => false,
            '_controller' => 'resolver/controller/boo'
        ]);

        $this->resolver->getController($this->request);
    }

    public function testResolve()
    {
        $actual = $this->resolver->resolve('resolver/controller/foo/bar/baz');
        $expect = [
            'class'     => $this->resolver->param->get('namespace') . '\Resolver\Controller',
            'method'    => 'foo',
            'arguments' => [ 'bar' => 'baz']
        ];

        $this->assertEquals($expect, $actual);
    }
    public function testResolveEmptyPathSegments()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->resolver->resolve('/');
    }

    public function testResolveClassException()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->resolver->resolve('resolver/agent/test');
    }

    protected function getLogs()
    {
        return file($this->tmpFile, FILE_IGNORE_NEW_LINES);
    }
}

class Controller
{
    public function index() {}

    public function foo()
    {
        return new Response('java coffee');
    }
}
