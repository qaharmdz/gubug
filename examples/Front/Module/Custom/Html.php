<?php
namespace Contoh\Front\Module\Custom;

class Html extends \Contoh\Library\Controller
{
    public function index($args = [])
    {
        $data = [];
        $data['title']   = 'Micro Framework';
        $data['content'] = "Good thing about micro is unlimited possibility to make it your own highly opiniated full-stack framework.";

        return $this->render('module/custom/html', $data);
    }

    public function list($args = [])
    {
        $lists = '<li>' . implode('</li><li>', $args['list']) . '</li>';

        return $this->response->setContent('The list: <ul style="margin:5px 0;">' . $lists . '</ul>');
    }
}
