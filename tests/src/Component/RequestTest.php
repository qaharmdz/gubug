<?php
namespace Gubug\Test\Component;

class RequestTest extends \PHPUnit\Framework\TestCase
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
        $this->assertSame('/about', $this->request->getPathInfo());
    }

    public function testGetBaseUri()
    {
        $this->assertSame('http://www.example.com/', $this->request->getBaseUri());
    }

    public function testGetUriForPath()
    {
        $this->assertSame('http://www.example.com/page/11', $this->request->getUriForPath('page/11'));
    }
}
