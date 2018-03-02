<?php
namespace Gubug\Test;

use Pimple\Container;

class ServiceContainerTest extends \PHPUnit\Framework\TestCase
{
    protected $service;

    protected function setUp()
    {
        $container = new Container();
        $container['test'] = 'foobar';

        \Gubug\ServiceContainer::setContainer($container);

        $this->service = new class extends \Gubug\ServiceContainer {
            public function containerForTest()
            {
                return $this->container();
            }

            public function useForTest($id)
            {
                return $this->use($id);
            }
        };
    }

    protected function tearDown()
    {
        $this->service = null;
    }

    public function testInstance()
    {
        $this->assertInstanceOf('Gubug\ServiceContainer', $this->service);
    }

    public function testSetContainer()
    {
        $this->assertNull($this->service->setContainer(new Container()));
    }

    public function testContainer()
    {
        $container = new Container();
        $container['test'] = 'foobar';

        $this->assertEquals($container, $this->service->containerForTest());
    }

    public function testUse()
    {
        $this->assertEquals('foobar', $this->service->useForTest('test'));
    }
}
