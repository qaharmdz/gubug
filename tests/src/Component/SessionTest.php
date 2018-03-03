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
        // $this->expectException(\RuntimeException::class);

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Session\Flash\FlashBag', $this->session->flash());
    }

    public function testAddFlash()
    {
        // $this->expectException(\RuntimeException::class);

        $this->assertNull($this->session->addFlash('notice', 'cool'));
    }

    public function testGetFlash()
    {
        // $this->expectException(\RuntimeException::class);

        $this->session->addFlash('notice', 'world');

        $this->assertEquals(['cool', 'world'], $this->session->getFlash('notice'));
    }
}
