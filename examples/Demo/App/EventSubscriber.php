<?php
namespace Contoh\App;

use Gubug\ServiceContainer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EventSubscriber extends ServiceContainer implements EventSubscriberInterface
{
    /**
     * Add all listeners handled by this class
     */
    public static function getSubscribedEvents()
    {
        return array(
            // Event name                  method            priorty
            'filter.home.renderData' => ['onHomeRenderData1', 10], // 1st, the 2nd is EventListener.php
        );
    }

    public function onHomeRenderData1($event)
    {
        $event->data->set('title', 'Basic PHP Render (1)');

        // uncomment to stop eventistener.php for being called
        // $event->stopPropagation();
    }
}
