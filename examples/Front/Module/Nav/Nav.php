<?php
namespace Contoh\Front\Module\Nav;

class Nav extends \Contoh\Library\Controller
{
    public function index()
    {
        $data = [];
        $data['navs'][] = ['Home', $this->router->urlGenerate(), 'Title link'];
        $data['navs'][] = ['Page', $this->router->urlGenerate('page', ['pid' => 4]), 'Title link'];
        $data['navs'][] = ['Post', $this->router->urlGenerate('page/post', ['pid' => 8, 'cid' => '9_10']), 'Title link'];

        return $this->render('module/nav/nav', $data);
    }
}
