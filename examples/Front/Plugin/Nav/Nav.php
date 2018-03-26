<?php
namespace Contoh\Front\Plugin\Nav;

use Contoh\Library\Controller;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Nav extends Controller implements EventSubscriberInterface
{
    /**
     * Add all listeners handled by this class
     */
    public static function getSubscribedEvents()
    {
        return [
            //      Event name              method     priorty
            'filter.module.nav.vars' => ['addNavItem', 10],
        ];
    }

    public function addNavItem($event)
    {
        $event->data->set('navs.', ['Not Found', $this->router->urlGenerate('404'), '404 Not Found']);
    }
}
