<?php
namespace Contoh\Front\Component\Home;

class Home extends \Contoh\Library\BaseController
{
    public function index()
    {
        return $this->response->setContent('Welcome to Gubug');
    }
}
