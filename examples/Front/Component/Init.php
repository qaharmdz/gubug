<?php
namespace Contoh\Front\Component;

class Init extends \Contoh\Library\Controller
{
    public function index()
    {
        $data      = [];
        $component = $this->dispatcher->handle($this->request); // automatically wrapped by event Middleware

        // Component direct output
        if ($component->hasOutput()) {
            return $component->getOutput();
        }

        // Main page
        $data['baseURL']    = $this->config->get('baseURL');
        $data['basePath']   = $this->config->get('basePath');
        $data['pageInfo']   = array_replace([
            'title'      => 'Gubug - PHP micro framework',
            'body_class' => '',
            'sidebar'    => true
        ], $this->session->getFlash('pageInfo'));

        $data['component']  = $component->getContent();
        $data['modules']    = $this->sidebar($data['pageInfo']);
        $data['nav']        = $this->load('nav/nav', [], 'Module')->getContent();

        $data['url_home']   = $this->router->urlGenerate();

        return $this->render('main', $data)->setStatusCode($component->getStatusCode());
    }

    public function sidebar($pageInfo)
    {
        if (empty($pageInfo['sidebar'])) {
            return [];
        }

        // Lets pretend the modules data from database
        $results = [
            ['custom/html/list', ['list' => ['Foo', 'Bar', 'Buzz']] ],
            ['custom/text', []],
            ['custom/html', ['text' => 'HTML']],
        ];

        $modules = [];
        foreach ($results as $mod) {
            try {
                list($path, $arguments) = $mod;

                $modules[] = $this->load($path, $arguments, 'Module')->getContent();
            } catch (\Exception $e) {
                $this->log->notice($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            }
        }

        return $modules;
    }
}
