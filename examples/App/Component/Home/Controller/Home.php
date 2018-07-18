<?php
namespace Contoh\App\Component\Home\Controller;

class Home extends \Gubug\Base\Controller
{
    /**
     * Can be accessed through:
     * As default controller
     * - example.com
     * - example.com/
     * And like other component controller:
     * - example.com/home
     * - example.com/home/home
     * - example.com/home/home/index
     */
    public function index($param = [])
    {
        $content = '
            <p>Welcome to Gubug</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus doloribus, quod repellat atque dolore tempore aliquid, nesciunt facere pariatur quo quaerat eveniet esse. Praesentium atque, unde sint velit obcaecati nemo!</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus doloribus, quod repellat atque dolore tempore aliquid, nesciunt facere pariatur quo quaerat eveniet esse. Praesentium atque, unde sint velit obcaecati nemo!</p>
        ';

        // Use main component for Main controller
        return $this->response->setContent($content);

        // Have own output
        // return $this->response->setContent($content)->setOutput();
    }
}
