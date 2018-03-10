<?php
namespace Contoh\Front\Module\Custom;

class Text extends \Contoh\Library\BaseController
{
    public function index()
    {
        return $this->response->setContent('<p style="text-align:center;">Sidebar Text</p>');
    }
}
