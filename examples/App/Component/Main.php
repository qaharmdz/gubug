<?php
namespace Contoh\App\Component;

class Main extends \Gubug\Base\Controller
{
    public function index()
    {
        $data      = [];
        $component = $this->dispatcher->handle($this->request);

        // Component direct output
        if ($component->hasOutput()) {
            return $component->getOutput();
        }

        /*
        Layout
        - Blank: No header, no footer, white canvas
        - Basic: Header, Footer
        - Sidebar: Basic + Sidebar
         */

        $output = $component->hasContent() ? $component->getContent() : 'Global Layout';

        return $this->response->setContent('<div style="background:#eee;padding:40px 20px;margin-bottom:50px;">' . $output . '</div>');

        // $variables = $this->event->filter($eventName, $variables)->getAllData();
        // $template = $this->config->get('themePath') . 'template/' . $variables['_template'] . '.tpl';

        // return $this->response->render($template, $variables);
    }
}
