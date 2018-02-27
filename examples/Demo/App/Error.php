<?php
namespace Contoh\App;

class Error extends \Gubug\ServiceContainer
{
    public function handle($exception)
    {
        return $exception->getStatusCode() == 404 ? $this->notFound($exception) : $this->serviceError($exception);
    }

    public function notFound($e)
    {
        return $this->use('response')
                    ->setStatusCode($e->getStatusCode())
                    ->setContent('<h2>Page Not Found!</h2> <p>' . $e->getMessage() . '</p>');
    }

    public function serviceError($e)
    {
        return $this->use('response')
                    ->setStatusCode($e->getStatusCode())
                    ->setContent(
                        '<h2 style="color:#d00">Oops, bad thing happen.</h2><p>Message: <i>' . $e->getMessage() . '</i></p>'
                    );
    }
}
