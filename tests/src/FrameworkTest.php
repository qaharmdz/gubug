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
            'baseNamespace'    => 'Gubug',
            'defaultComponent' => 'test/app', // index
            'path'             => [
                'log'   => $this->tmpFile
            ],
        ];

        $this->gubug->init($config);

        ob_start();

        $this->gubug->run();

        $response = ob_get_clean();

        $this->assertEquals('java coffee', $response);
    }

    public function testConfigEnv()
    {
        $envFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . '.env';
        file_put_contents($envFile, 'environment=test');

        $config = [
            'baseNamespace'    => 'Gubug',
            'defaultComponent' => 'test/app', // index
            'path'             => [
                'env'   => $envFile,
                'log'   => $this->tmpFile
            ],
        ];

        $this->gubug->init($config);

        ob_start();

        $this->gubug->run();

        $response = ob_get_clean();

        $this->assertEquals('java coffee', $response);
        unlink($envFile);
    }

    public function testMainController()
    {
        $config = [
            'locales'          => ['en', 'id'], // test baseRoute() dynamicRoute() multiple locales
            'baseNamespace'    => 'Gubug',
            'mainController'   => 'test/main',
            'path'             => [
                'log'   => $this->tmpFile
            ],
        ];

        $this->gubug->init($config);

        ob_start();

        $this->gubug->run();

        $response = ob_get_clean();

        $this->assertEquals('main response: coffee world', $response);
    }

    public function testErrorController()
    {
        $config = [
            'baseNamespace'    => 'Gubug',
            'errorController'  => 'test/error',
            'defaultComponent' => 'test/app/none',
            'path'             => [
                'log'   => $this->tmpFile
            ],
        ];

        $this->gubug->init($config);

        ob_start();

        $this->gubug->run();

        $response = ob_get_clean();

        $this->assertEquals('error response', $response);
    }
}

class App
{
    public function index()
    {
        return new Response('java coffee');
    }

    public function sub()
    {
        return new Response('coffee world');
    }
}

class Main {
    public function index()
    {
        $app = new App();

        return new Response('main response: ' . $app->sub()->getContent());
    }
}

class Error
{
    public function index()
    {
        return new Response('error response');
    }
}
