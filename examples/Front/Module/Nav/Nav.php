<?php
namespace Contoh\Front\Module\Nav;

class Nav extends \Contoh\Library\BaseController
{
    public function index()
    {
        $data = [];
        $data['navs'][] = ['Home', $this->router->urlGenerate(), 'Title link'];
        $data['navs'][] = ['Page x', $this->router->urlGenerate('page/2'), 'Title link'];
        $data['navs'][] = ['Redirect Home', $this->router->urlGenerate('page/301'), 'Title link'];
        $data['navs'][] = ['Not Found', $this->router->urlGenerate('404'), 'Title link'];

        $template = $this->config->get('themePath') . 'template/module/nav/nav.tpl';

        return $this->response->render($template, $data);
    }
}
