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
        $this->use('response')->setStatusCode($e->getStatusCode());
        $this->use('response')->setContent('<h2>Page Not Found!</h2>');

        return $this->use('response');
    }

    public function serviceError($e)
    {
        $this->use('response')->setStatusCode($e->getStatusCode());
        $this->use('response')->setContent(
            '<h2 style="color:#d00">Oops, bad thing happen.</h2><p>Message: <i>' . $e->getMessage() . '</i></p>'
        );

        return $this->use('response');
    }
}
