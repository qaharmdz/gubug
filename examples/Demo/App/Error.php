<?php
namespace Contoh\App;

use Gubug\ServiceContainer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Debug\Exception\FlattenException;

class Error extends ServiceContainer
{
    /**
     * Error handle
     *
     * @param  FlattenException $exception
     *
     * @return Response
     */
    public function handle(FlattenException $exception)
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
