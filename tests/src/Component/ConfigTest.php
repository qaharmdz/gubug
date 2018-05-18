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

    public function testLoadArray()
    {
        $config = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'config.php';
        $content = "<?php return ['foo' => 'bar array'];";

        file_put_contents($config, $content);

        $this->assertSame(['foo' => 'bar array'], $this->config->load($config));
        $this->assertSame('bar array', $this->config->get('foo'));
    }

    public function testLoadJson()
    {
        $config = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'config.json';
        $content = ['foo' => 'bar json'];

        file_put_contents($config, json_encode($content));

        $this->assertSame(['foo' => 'bar json'], $this->config->load($config, 'json'));
        $this->assertSame('bar json', $this->config->get('foo'));
    }

    public function testLoadEnv()
    {
        $config = sys_get_temp_dir() . DIRECTORY_SEPARATOR . '.env';
        $content = "environment=test
        foo.bar = cool world";

        file_put_contents($config, $content);

        $actual = $this->config->load($config, 'env');
        $expect = [
            'environment' => 'test',
            'foo.bar' => 'cool world'
        ];

        $this->assertSame($expect, $actual);
        $this->assertSame('test', $this->config->get('environment'));

        unlink($config);
    }

    public function testLoadFail()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('File "');

        $this->config->load(sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'not-exist.tmp');
    }

    public function testLoadUnknownType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Config type "markdown');

        $config = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'config.php';
        $content = "<?php return ['foo' => 'bar array'];";

        file_put_contents($config, $content);

        $this->config->load($config, 'markdown');
    }
}
