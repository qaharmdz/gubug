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
        $result = $this->event->action('test', ['foo' => 'bar']);

        $this->assertNull($result);
    }

    public function testFilter()
    {
        $result = $this->event->filter('test', ['foo' => 'bar']);

        $this->assertInstanceOf('Gubug\Event\Hook', $result);
        $this->assertEquals(['foo' => 'bar'], $result->getAllData());
    }

    public function testFilterDispatch()
    {
        $this->event->addListener('filter.test', function ($event) {
            $event->data->set('baz', 'world');
        });

        $result = $this->event->filter('test', ['foo' => 'bar']);
        $actual = [
            'foo' => 'bar',
            'baz' => 'world'
        ];

        // $this->assertInstanceOf('Gubug\Event\Hook', $result);
        $this->assertEquals($actual, $result->getAllData());
    }
}
