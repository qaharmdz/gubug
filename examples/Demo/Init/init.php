<?php
namespace Contoh\Init;

class Init extends \Gubug\ServiceContainer
{
    public function index()
    {
        $component = $this->use('dispatcher')->handle($this->use('request'));


        if ($component->hasOutput() || $component->getStatusCode !== 200) {
            return $component;
        } else {
            // We can use component as part of larger pages
            return $this->use('response')->setContent('Do whatever we want');
        }
    }
}
