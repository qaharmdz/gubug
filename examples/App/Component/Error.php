<?php
namespace Contoh\App\Component;

class Error extends \Contoh\System\Base\Controller
{
    public function index($exception)
    {
        echo '<h2>' . get_class($this) . '</h2>';

        return $exception->getStatusCode() == 404 ? $this->notFound($exception) : $this->serviceError($exception);
    }

    protected function notFound($exception)
    {
        $this->session->flash->set('pageInfo', [
            'title'      => '404 Not Found!',
            'body_class' => 'page-error page-404',
            'layout'     => 'blank'
        ]);

        return $this->response
            ->setStatusCode($exception->getStatusCode())
            ->setContent('<h1>404 Not Found!</h1> <p>' . $exception->getMessage() . '</p>');
    }

    protected function serviceError($exception)
    {
        $this->session->flash->set('pageInfo', [
            'title'      => $e->getStatusCode() . ' Oops!',
            'body_class' => 'page-error page-500',
            'layout'     => 'blank'
        ]);

        return $this->response
            ->setStatusCode($exception->getStatusCode())
            ->setContent(
                '<h1>Oops, bad thing happen!</h1><p>Message: <i>' . $exception->getMessage() . '</i></p>'
            )
            ->setOutput();
    }
}
