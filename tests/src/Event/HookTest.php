<?php
namespace Gubug\Test\Event;

use Psr\Log\LogLevel;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HookTest extends \PHPUnit\Framework\TestCase
{
    protected $hook;

    protected function setUp()
    {
        $this->hook = new \Gubug\Event\Hook('filter.test', ['foo' => 'bar']);
    }

    protected function tearDown()
    {
        $this->hook = null;
    }

    public function testInstance()
    {
        $this->assertInstanceOf('Gubug\Event\Hook', $this->hook);
    }

    public function testGetName()
    {
        $this->assertEquals('filter.test', $this->hook->getName());
    }

    public function testGetDefault()
    {
        $this->hook->data->set('foo', 'world');

        $this->assertEquals(['foo' => 'bar'], $this->hook->getDefault());
    }

    public function testGetAllData()
    {
        $this->hook->data->set('foo', 'world');

        $this->assertEquals(['foo' => 'world'], $this->hook->getAllData());
    }

    public function testGetContent()
    {
        $this->hook->data->set('content', 'world');

        $this->assertEquals('world', $this->hook->getContent());
    }
}
