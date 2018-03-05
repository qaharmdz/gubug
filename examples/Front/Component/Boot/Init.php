<?php
namespace Contoh\Front\Component\Boot;

class Init extends \Contoh\Library\BaseController
{
    public function index()
    {
        $data      = [];
        $component = $this->use('dispatcher')->handle($this->use('request'));

        // Respect component decission to send output
        if ($component->hasOutput()) {
            return $component->getOutput();
        }

        // Main page
        $data['pageInfo']  = $this->session->getFlash('pageInfo');
        $data['baseURL']   = $this->config->get('baseURL');
        $data['basePath']  = $this->config->get('basePath');

        $data['component'] = $component->getContent();
        $data['modules']   = $this->sidebar($data['pageInfo']);

        // d($data);

        // We can use component as part of larger pages
        $template = $this->use('config')->get('basePath') . 'Front/Theme/default/template/index.tpl';

        return $this->use('response')
                    ->render($template, $data)
                    ->setStatusCode($component->getStatusCode());
    }

    public function sidebar($pageInfo)
    {
        if (isset($pageInfo['sidebar']) && $pageInfo['sidebar'] === false) {
            return [];
        }

        $modules = [];

        // Lets pretend the modules path & arg provided by config or database
        $results = [
            ['nav/nav', []],
            ['custom/text', []],
            ['custom/text/html', ['text' => 'HTML']],
        ];

        foreach ($results as $mod) {
            $modules[] = $this->dispatcher->controller($mod[0], $mod[1], '\Contoh\Front\Module')->getContent();
        }

        return $modules;
    }
}
