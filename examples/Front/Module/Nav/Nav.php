<?php
namespace Contoh\Front\Module\Nav;

class Nav extends \Contoh\Library\BaseController
{
    public function index()
    {
        return $this->response->setContent('Sidebar Nav');
    }
}
