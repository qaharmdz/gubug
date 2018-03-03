<?php
namespace Contoh\Init;

class Init extends \Gubug\ServiceContainer
{
    public function index()
    {
        $data      = [];
        $component = $this->use('dispatcher')->handle($this->use('request'));

        // Component decide to send own output
        if ($component->hasOutput()) {
            return $component->getOutput();
        }

        // Main controller
        $data['component'] = $component->getContent();

        // We can use component as part of larger pages
        return $this->use('response')
                    ->render($this->use('config')->get('basePath') . 'Init/template.tpl', $data)
                    ->setStatusCode($component->getStatusCode());
    }
}
