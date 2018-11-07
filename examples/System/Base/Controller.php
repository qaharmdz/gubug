<?php
/*
 * This file is part of the Gubug package.
 *
 * (c) Mudzakkir <qaharmdz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Contoh\System\Base;

/**
 * @author Mudzakkir <qaharmdz@gmail.com>
 */
class Controller extends \Gubug\ServiceContainer
{
    public function __get(string $service)
    {
        return $this->use($service);
    }

    protected function template(string $template)
    {
        $file = $this->config->get('system.path.theme') . $this->config->get('setting.theme') . DS . 'Template' . DS . str_replace(['/', '\\'], DS, $template) . '.tpl';

        if (!is_file($file)) {
            $file = 'uupp';
        }

        return $file;
    }
}
