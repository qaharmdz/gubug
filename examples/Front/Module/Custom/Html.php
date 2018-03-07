<?php
namespace Contoh\Front\Module\Custom;

class Html extends \Contoh\Library\BaseController
{
    public function index($args = [])
    {
        return $this->response->setContent('Custom <b>' . $args['text'] . '</b> module');
    }

    public function list($args = [])
    {
        $lists = '<li>' . implode('</li><li>', $args['list']) . '</li>';

        return $this->response->setContent('The list: <ul>' . $lists . '</ul>');
    }
}
