<?php
namespace Contoh\Front\Component\Boot;

class Init extends \Contoh\Library\BaseController
{
    public function index()
    {
        $data      = [];
        $component = $this->dispatcher->handle($this->use('request'));

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
        $template = $this->config->get('themePath') . 'template/index.tpl';

        return $this->response
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
            ['custom/html', ['text' => 'HTML']],
            ['custom/html/list', ['list' => ['Foo', 'Bar', 'Buzz']] ],
        ];

        foreach ($results as $mod) {
            try {
                $modules[] = $this->dispatcher->controller($mod[0], $mod[1], 'Module')->getContent();
            } catch (\Exception $e) {
                $this->log->warning($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            }
        }

        return $modules;
    }
}
