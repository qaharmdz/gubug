<?php
namespace Contoh\Front\Module\Custom;

class Html extends \Contoh\Library\BaseController
{
    public function index($args = [])
    {
        return $this->response->setContent('Custom <b>' . $args['text'] . '</b> module');
    }
}
