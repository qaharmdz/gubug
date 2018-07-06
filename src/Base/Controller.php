<?php
namespace Gubug\Base;

class Controller extends \Gubug\ServiceContainer
{
    public function __get(string $service)
    {
        return $this->use($service);
    }
}
