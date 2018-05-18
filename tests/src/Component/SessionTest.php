<?php
namespace Gubug\Test\Component;

class SessionTest extends \PHPUnit\Framework\TestCase
{
    protected $session;

    protected function setUp()
    {
        $this->session = new \Gubug\Component\Session();
    }

    protected function tearDown()
    {
        $this->session = null;
    }

    public function testInstance()
    {
        $this->assertInstanceOf('Gubug\Component\Session', $this->session);
    }

    public function testSetOptions()
    {
        $this->assertNull($this->session->setOptions([]));
    }

    public function testFlash()
    {
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Session\Flash\FlashBag', $this->session->flash());
    }

    public function testSetFlash()
    {
        $this->assertNull($this->session->setFlash('notice', ['foo' => 'bar']));
    }

    public function testAddFlash()
    {
        $this->assertNull($this->session->addFlash('notice', 'cool'));
    }

    public function testGetFlash()
    {
        $this->session->addFlash('notice', 'world');

        $expect = [
            'cool',
            'world',
            'foo' => 'bar'
        ];

        $this->assertEquals($expect, $this->session->getFlash('notice'));
    }

    public function testHasFlash()
    {
        $this->session->addFlash('foo', 'bar');

        $this->assertFalse($this->session->hasFlash('notice'));
        $this->assertTrue($this->session->hasFlash('foo'));
    }
}
