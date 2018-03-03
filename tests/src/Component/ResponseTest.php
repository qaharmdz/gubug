<?php
namespace Gubug\Test\Component;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ResponseTest extends \PHPUnit\Framework\TestCase
{
    protected $response;

    protected function setUp()
    {
        $this->response = new \Gubug\Component\Response();
    }

    protected function tearDown()
    {
        $this->response = null;
    }

    public function testInstance()
    {
        $this->assertInstanceOf('Gubug\Component\Response', $this->response);
    }

    public function testSetGetOutput()
    {
        $this->assertFalse($this->response->hasOutput());

        $this->response->setOutput(new Response('world', 301));
        $output = $this->response->getOutput();

        $this->assertTrue($this->response->hasOutput());
        $this->assertEquals(301, $output->getStatusCode());
        $this->assertEquals('world', $output->getContent());
    }

    public function testHasContent()
    {
        $this->assertFalse($this->response->hasContent());

        $this->response->setContent('world');

        $this->assertTrue($this->response->hasContent());
        $this->assertEquals('world', $this->response->getContent());
    }

    public function testPreAppendContent()
    {
        $this->response->setContent('world');

        $this->response->prependContent('foo ');
        $this->response->appendContent(' bar');

        $this->assertEquals('foo world bar', $this->response->getContent());
    }

    public function testRedirect()
    {
        $result = $this->response->redirect('foo/bar');

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\RedirectResponse', $result->getOutput());
    }

    public function testJsonOutput()
    {
        $result = $this->response->jsonOutput(['foo']);

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\JsonResponse', $result->getOutput());
    }

    public function testFileOutput()
    {
        $result = $this->response->fileOutput(__DIR__ . DIRECTORY_SEPARATOR . 'ResponseTest.php', 'masking');

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\BinaryFileResponse', $result->getOutput());
    }

    public function testAbort()
    {
        $this->expectException(HttpException::class);

        $this->response->abort(500);
    }

    public function testRender()
    {
        $tmpFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'template.html';
        file_put_contents($tmpFile, 'Coffee <?php echo $foo; ?>');

        $this->assertFalse($this->response->hasContent());

        $result = $this->response->render($tmpFile, ['foo' => 'bar']);

        $this->assertTrue($this->response->hasContent());
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $result);
        $this->assertEquals('Coffee bar', $result->getContent());

        if (!@unlink($tmpFile)) {
            file_put_contents($tmpFile, '');
        }
    }

    public function testRenderException()
    {
        $this->expectException(\RuntimeException::class);

        $this->response->render('file/not_exist.html', ['foo' => 'bar']);
    }
}
