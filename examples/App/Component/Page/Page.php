<?php
namespace Contoh\App\Component\Page;

class Page extends \Gubug\Base\Controller
{
    /**
     * For example.com/page/11/21_31?foo=bar
     * - $pid : 11
     * - $cid : '21_31'
     * - $foo : '' // not set in the route rule
     * - $this->request->query->all() : [
     *     'pid'     => '11',
     *     'cid'     => '21_31',
     *     'foo'     => 'bar',
     *     '_locale' => 'en'
     * ]
     */
    public function index(int $pid, string $cid, $foo = '')
    {
        echo '<h2>' . get_class($this) . '</h2>';

        return $this->response->setContent('cool');
    }
}
