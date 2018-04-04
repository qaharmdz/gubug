<?php
namespace Contoh\Front\Plugin\Nav;

use Contoh\Library\Controller;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Nav extends Controller implements EventSubscriberInterface
{
    public function addNavItem($event)
    {
        $data = $event->data->all();

        $data['navs'][] = ['Redirect', $this->router->urlGenerate('page', ['pid' => 302]), 'Redirect to other page'];
        $data['navs'][] = ['Not Found', $this->router->urlGenerate('404'), '404 Not Found'];

        $event->data->add($data);
    }

    /**
     * Listeners handled by this class
     */
    public static function getSubscribedEvents()
    {
        return [
            //      Event name              method     priority (higher number, earlier called)
            'filter.module.nav.vars' => ['addNavItem', 10],
        ];
    }
}
