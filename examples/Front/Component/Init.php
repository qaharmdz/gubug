<?php
namespace Contoh\Front\Component;

class Init extends \Contoh\Library\BaseController
{
    public function index()
    {
        $data      = [];
        $component = $this->dispatcher->handle($this->request);

        // Respect component decision to send output
        if ($component->hasOutput()) {
            return $component->getOutput();
        }

        // Main page
        $data['baseURL']   = $this->config->get('baseURL');
        $data['basePath']  = $this->config->get('basePath');
        $data['pageInfo']  = array_replace([
            'title'      => 'Gubug - PHP micro framework',
            'body_class' => '',
            'sidebar'    => true
        ], $this->session->getFlash('pageInfo'));

        $data['component'] = $component->getContent();
        $data['modules']   = $this->sidebar($data['pageInfo']);

        // We can use component as part of larger pages
        $template = $this->config->get('themePath') . 'template/index.tpl';

        return $this->response
                    ->render($template, $data)
                    ->setStatusCode($component->getStatusCode());
    }

    public function sidebar($pageInfo)
    {
        if (empty($pageInfo['sidebar'])) {
            return [];
        }

        // Lets pretend the modules path & arg provided by config or from database
        $results = [
            ['nav/nav', []],
            ['custom/html/list', ['list' => ['Foo', 'Bar', 'Buzz']] ],
            ['custom/text', []],
            ['custom/html', ['text' => 'HTML']],
        ];

        $modules = [];
        foreach ($results as $mod) {
            try {
                list($path, $arguments) = $mod;

                // This event allows you to change the arguments that will be passed to the controller.
                $eventArguments = $this->event->filter('sidebar.module.arguments', $arguments);

                // Dispatch module to get response
                $response = $this->dispatcher->controller($path, $eventArguments->getAllData(), 'Module');

                // This event allows you to modify or replace the content that will be replied.
                $eventResponse = $this->event->filter('sidebar.module.content', ['content' => $response->getContent()]);

                $modules[] = $eventResponse->getContent('content');
            } catch (\Exception $e) {
                $this->log->notice($e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            }
        }

        return $modules;
    }
}
