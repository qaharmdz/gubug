<?php
namespace Contoh\Front\Component;

class Error extends \Contoh\Library\BaseController
{
    public function index($exception)
    {
        return $exception->getStatusCode() == 404 ? $this->notFound($exception) : $this->serviceError($exception);
    }

    protected function notFound($e)
    {
        $this->session->setFlash('pageInfo', [
            'title'      => '404 Not Found!',
            'body_class' => 'page-error page-404',
            'sidebar'    => false
        ]);

        return $this->response
                    ->setStatusCode($e->getStatusCode())
                    ->setContent('<h1>404 Not Found!</h1> <p>' . $e->getMessage() . '</p>');
    }

    protected function serviceError($e)
    {
        $this->session->setFlash('pageInfo', [
            'title'      => $e->getStatusCode() . ' Oops!',
            'body_class' => 'page-error page-500',
            'sidebar'    => false
        ]);

        return $this->response
                    ->setStatusCode($e->getStatusCode())
                    ->setContent(
                        '<h1>Oops, bad thing happen!</h1><p>Message: <i>' . $e->getMessage() . '</i></p>'
                    );
    }
}
