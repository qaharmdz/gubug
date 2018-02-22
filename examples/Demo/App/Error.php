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
        $msg = 'Something went wrong! ('.$exception->getMessage().')';

        $this->use('response')->setStatusCode($exception->getStatusCode());
        $this->use('response')->setContent($msg);

        return $this->use('response');
    }
}
