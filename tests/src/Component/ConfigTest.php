<?php
namespace Gubug\Test\Component;

class ConfigTest extends \PHPUnit\Framework\TestCase
{
    protected $config;

    protected function setUp()
    {
        $this->config = new \Gubug\Component\Config();
    }

    protected function tearDown()
    {
        $this->config = null;
    }

    public function testInstance()
    {
        $this->assertInstanceOf('Gubug\Component\Config', $this->config);
    }

    public function testSetGet()
    {
        $this->config->set('foo', 'bar');
        $this->config->set('baz', ['foo' => 'bar', 'world' => 'cool']);

        $this->assertSame('bar', $this->config->get('foo'));
        $this->assertSame('bar', $this->config->get('baz.foo')); // dot-notation
    }

    public function testGetDefault()
    {
        $this->assertSame('world', $this->config->get('foo', 'world'));
        $this->assertSame('cool', $this->config->get('baz.foo', 'cool'));
    }

    public function testGetArray()
    {
        $this->config->set('foo', 'bar');

        $this->assertEquals(['bar'], $this->config->getArray('foo'));
    }

    public function testRemove()
    {
        $this->config->set('foo', 'bar');
        $this->config->set('baz', ['foo' => 'bar', 'world' => 'cool']);


        $this->config->remove('foo');
        $this->config->remove('baz.world');
        $this->config->remove('baz.foo.cool'); // do nothing

        $this->assertSame('world', $this->config->get('foo', 'world'));
        $this->assertSame('fallback', $this->config->get('baz.world', 'fallback'));

        $this->assertSame('bar', $this->config->get('baz.foo', 'not-removed-from-baz'));
    }
}
