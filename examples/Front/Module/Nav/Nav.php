<?php
namespace Contoh\Front\Module\Nav;

class Nav extends \Contoh\Library\Controller
{
    public function index()
    {
        $data = [];
        $data['navs'][] = ['Home', $this->router->urlGenerate(), 'Title link'];
        $data['navs'][] = ['Page x', $this->router->urlGenerate('page/2'), 'Title link'];
        $data['navs'][] = ['Redirect Home', $this->router->urlGenerate('page/301'), 'Title link'];

        return $this->render('module/nav/nav', $data);
    }
}
