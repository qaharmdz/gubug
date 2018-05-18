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

        $this->resolver->param->set('baseNamespace', 'Gubug\Test');
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

    public function testRequestPath()
    {
        $this->request->attributes->add([
            '_path' => 'resolver/controller'
        ]);

        $result = $this->resolver->getController($this->request);

        $this->assertEquals([new Controller(), 'index'], $result);
    }

    public function testRequestPathMethod()
    {
        $this->request->attributes->add([
            '_path' => 'resolver/controller/foo/bar/baz'
        ]);

        $result = $this->resolver->getController($this->request);

        $this->assertEquals([new Controller(), 'foo'], $result);
    }

    public function testRequestControllerCallable()
    {
        $this->request->attributes->add([
            '_controller' => 'Gubug\Test\Resolver\Controller::foo'
        ]);

        $result = $this->resolver->getController($this->request);

        $this->assertEquals('Gubug\Test\Resolver\Controller::foo', $result);
    }

    public function testRequestPathFail()
    {
        $this->request->attributes->add([
            '_path' => 'resolver/controller/bar'
        ]);

        $this->assertFalse($this->resolver->getController($this->request));
    }

    public function testRequestControllerFail()
    {
        $this->request->attributes->add([
            '_controller' => 'resolver/controller/bar'
        ]);

        $this->assertFalse($this->resolver->getController($this->request));
    }

    /**
     * Used to load subcontroller and take the advantage of middleware
     */
    public function testControllerNamespaceRequest()
    {
        $this->request->attributes->add([
            '_path'           => 'resolver/controller/bar',
            '_master_request' => false,
            '_pathNamespace'  => 'module'
        ]);

        $this->assertFalse($this->resolver->getController($this->request));
    }

    public function testResolve()
    {
        $actual = $this->resolver->resolve('resolver/controller/foo/bar/baz');
        $expect = [
            'class'     => $this->resolver->param->get('baseNamespace') . '\Resolver\Controller',
            'method'    => 'foo',
            'arguments' => [ 'bar' => 'baz']
        ];

        $this->assertEquals($expect, $actual);
    }
    public function testResolveEmptyPathSegments()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Empty route path parameter.');

        $this->resolver->resolve('/');
    }

    public function testResolveClassException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot find controller');

        $this->resolver->resolve('resolver/agent/test');
    }

    // protected function getLogs()
    // {
    //     return file($this->tmpFile, FILE_IGNORE_NEW_LINES);
    // }
}

class Controller
{
    public function index() {}

    public function foo()
    {
        return new Response('java coffee');
    }
}
