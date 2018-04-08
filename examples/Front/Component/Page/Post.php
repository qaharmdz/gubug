<?php
namespace Contoh\Front\Component\Page;

class Post extends \Contoh\Library\Controller
{
    public function index($args)
    {
        $data = [];

        $data['args']    = $args;
        $data['title']   = 'Post Heading';
        $data['content'] = '
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus doloribus, quod repellat atque dolore tempore aliquid, nesciunt facere pariatur quo quaerat eveniet esse. Praesentium atque, unde sint velit obcaecati nemo!</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus doloribus, quod repellat atque dolore tempore aliquid, nesciunt facere pariatur quo quaerat eveniet esse. Praesentium atque, unde sint velit obcaecati nemo!</p>
        ';

        return $this->render('component/page/post', $data);
    }
}
