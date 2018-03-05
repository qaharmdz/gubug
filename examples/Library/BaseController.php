<?php
namespace Contoh\Library;

class BaseController extends \Gubug\ServiceContainer
{
    public function __get(string $id)
    {
        return $this->use($id);
    }
}
