<?php
namespace Contoh\Front\Module\Custom;

class Text extends \Contoh\Library\Controller
{
    public function index()
    {
        return $this->render('module/custom/text', ['content' => 'Sidebar Text']);
    }
}
