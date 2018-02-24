<?php
/*
 * Copyright (c) 2018 A. Qahar Mudzakkir
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Gubug\Library;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * {@inheritdoc}
 *
 * @author Mudzakkir <qaharmdz@gmail.com>
 */
class Event extends EventDispatcher
{
    // Todo: Simple events like wordpress hook: action and filter

    // $this->event->trigger('action.alpha.init');
    // $this->event->trigger('filter.alpha.init', [$data]);

    public function trigger($eventType, $eventName, $data, GenericEvent $event = null)
    {
        if ($event === null) {
            if ($eventType == 'action') {
                $event = new Gubug\Event\Action();
            } else {
                $event = new Gubug\Event\Filter();
            }
        }

        if (!$event instanceof GenericEvent) {
            throw new \LogicException('The Event must return an instance of Symfony\Component\HttpFoundation\Request.');
        }

        return parent::dispatch($eventName, $event);
    }

    /**
     * [add description]
     * @param [type]  $eventName
     * @param [type]  $listener  Callback
     * @param integer $priority  The higher, the earlier called
     */
    public function add($eventName, $listener, $priority = 0)
    {
        parent::addListener($eventName, $listener, $priority);
    }

    public function has($eventName = null)
    {
        return parent::hasListeners($eventName);
    }

    public function remove($eventName, $listener)
    {
        return parent::removeListener($eventName, $listener);
    }
}
