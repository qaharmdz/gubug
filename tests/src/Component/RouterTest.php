<?php
namespace Gubug\Test\Component;

class RouterTest extends \PHPUnit\Framework\TestCase
{
    protected $request;

    protected function setUp()
    {
        $this->request = \Gubug\Component\Request::create('http://www.example.com/about');
    }

    protected function tearDown()
    {
        $this->request = null;
    }

    public function testInstance()
    {
        $this->assertInstanceOf('Gubug\Component\Request', $this->request);
    }

    public function testGetPathInfo()
    {
        $this->assertSame('/about', 'cool');
    }
}
