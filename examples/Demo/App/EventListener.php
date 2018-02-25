<?php
namespace Contoh\App;

use Gubug\ServiceContainer;

class EventListener extends ServiceContainer
{
    public function onHomeRenderData($event)
    {
        // d($event);
        // d($event->getName());
        // d($event->getDefault());
        // d($event->getAlldata());

        // d($event->data);
        // d($event->data->get('param.data.product')); // Dot notation

        $event->data->set('title', 'Basic PHP Render');

        // d($event->getDefault()); // All data still same
        // d($event->getAlldata()); // Data title changed
    }
}
