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

namespace Gubug\Component;

use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Events central point
 *
 * @author Mudzakkir <qaharmdz@gmail.com>
 */
class Event extends EventDispatcher
{
    /**
     * Shortcut for dispatchHook action
     *
     * @param  string $eventName
     * @param  array  $data
     *
     * @return array
     */
    public function action(string $eventName, array $data = [])
    {
        return $this->dispatchHook($eventName, $data, 'action');
    }

    /**
     * Shortcut for dispatchHook filter
     *
     * @param  string $eventName
     * @param  array  $data
     *
     * @return array
     */
    public function filter(string $eventName, array $data = [])
    {
        return $this->dispatchHook($eventName, $data, 'filter');
    }

    /**
     * Specifically dispatch \Gubug\Event\Hook
     *
     * @param  string $eventName
     * @param  array  $data
     * @param  string $type
     *
     * @return array
     */
    public function dispatchHook(string $eventName, array $data = [], string $type = 'action')
    {
        $eventName = $type . '.' . $eventName;
        $event     = new \Gubug\Event\Hook($eventName, $data);

        $this->dispatch($eventName, $event);

        if ($type === 'filter') {
            return $event->getAllData();
        }
    }
}
