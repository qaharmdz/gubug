<?php
namespace Gubug\Test\Component;

class EventTest extends \PHPUnit\Framework\TestCase
{
    protected $event;

    protected function setUp()
    {
        $this->event = new \Gubug\Component\Event();
    }

    protected function tearDown()
    {
        $this->event = null;
    }

    public function testInstance()
    {
        $this->assertInstanceOf('Gubug\Component\event', $this->event);
    }

    public function testAction()
    {
        $result = $this->event->action('action.test', ['foo' => 'bar']);

        $this->assertNull($result);
    }

    public function testFilter()
    {
        $result = $this->event->filter('filter.test', ['foo' => 'bar']);

        $this->assertEquals(['foo' => 'bar'], $result);
    }
}
