<?php
namespace Contoh\Front\Component\Home;

class Home extends \Contoh\Library\BaseController
{
    public function index()
    {
        return $this->response->setContent('
            <p>Welcome to Gubug</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus doloribus, quod repellat atque dolore tempore aliquid, nesciunt facere pariatur quo quaerat eveniet esse. Praesentium atque, unde sint velit obcaecati nemo!</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus doloribus, quod repellat atque dolore tempore aliquid, nesciunt facere pariatur quo quaerat eveniet esse. Praesentium atque, unde sint velit obcaecati nemo!</p>
        ');
    }
}
