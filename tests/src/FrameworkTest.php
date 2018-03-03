<?php
namespace Gubug\Test;

use Pimple\Container;
use Symfony\Component\HttpFoundation\Response;

class FrameworkTest extends \PHPUnit\Framework\TestCase
{
    protected $gubug;

    protected function setUp()
    {
        if (\PHP_SESSION_ACTIVE === session_status()) {
            session_destroy();
        }

        $this->gubug = new \Gubug\Framework();
        $this->tmpFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'log';
    }

    protected function tearDown()
    {
        $this->gubug = null;

        if (!@unlink($this->tmpFile)) {
            file_put_contents($this->tmpFile, '');
        }
    }

    public function testInstance()
    {
        $this->assertInstanceOf('Gubug\Framework', $this->gubug);
    }

    public function testFramework()
    {
        $config = [
            'baseNamespace' => 'Gubug',
            'routePath'     => 'test/app', // index
            'errorHandler'  => 'test/error/handle',
            'logfile'       => $this->tmpFile
        ];

        $this->gubug->init($config);

        ob_start();

        $this->gubug->run();

        $response = ob_get_clean();

        $this->assertEquals('java coffee', $response);
    }

    public function testFrameworkError()
    {
        $config = [
            'baseNamespace' => 'Gubug',
            'routePath'     => 'test/app/world',
            'errorHandler'  => 'test/error/handle',
            'logfile'       => $this->tmpFile
        ];

        $this->gubug->init($config);

        ob_start();

        $this->gubug->run();

        $response = ob_get_clean();

        $this->assertEquals('error response', $response);
    }

    public function testMainController()
    {
        $config = [
            'baseNamespace'  => 'Gubug',
            'mainController' => 'test/main',
            'routePath'      => 'test/app', // index
            'errorHandler'   => 'test/error/handle',
            'logfile'        => $this->tmpFile
        ];

        $this->gubug->init($config);

        ob_start();

        $this->gubug->run();

        $response = ob_get_clean();

        $this->assertEquals('main response: java coffee', $response);
    }
}

class App
{
    public function index()
    {
        return new Response('java coffee');
    }
}

class Error
{
    public function handle()
    {
        return new Response('error response');
    }
}

class Main {
    public function index()
    {
        $app = new App();

        return new Response('main response: ' . $app->index()->getContent());
    }
}
