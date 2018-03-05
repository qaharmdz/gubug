<?php
namespace Contoh\Front\Module\Custom;

class Text extends \Contoh\Library\BaseController
{
    public function index()
    {
        return $this->use('response')->setContent('Sidebar Text');
    }

    public function html($args = [])
    {
        return $this->use('response')->setContent('Custom <b>' . $args['text'] . '</b> module');
    }
}
