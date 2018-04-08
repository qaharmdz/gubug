<?php
namespace Contoh\Front\Component\Page;

class Page extends \Contoh\Library\Controller
{
    public function index($args)
    {
        $data = [];

        if (in_array($args['pid'], [301, 302])) {
            $this->session->setFlash(
                'redirect',
                [
                    'Redirected from page ' . $args['pid'],
                    'Permanent redirect visit ' . $this->router->urlGenerate('page', ['pid' => 301])
                ]
            );

            return $this->response->redirect($this->router->urlGenerate('page', ['pid' => 11]), $args['pid']);
        }

        $data['args']    = $args;
        $data['title']   = 'Page Heading';
        $data['content'] = '
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus doloribus, quod repellat atque dolore tempore aliquid, nesciunt facere pariatur quo quaerat eveniet esse. Praesentium atque, unde sint velit obcaecati nemo!</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus doloribus, quod repellat atque dolore tempore aliquid, nesciunt facere pariatur quo quaerat eveniet esse. Praesentium atque, unde sint velit obcaecati nemo!</p>
        ';

        if ($args['pid'] == 11 && $this->session->hasFlash('redirect')) {
            $data['args']['message'] = $this->session->getFlash('redirect');
            $data['args']['referer'] = $this->request->headers->get('referer');
        }

        return $this->render('component/page/page', $data);
    }
}
