<?php
/*
 * This file is part of the Gubug package.
 *
 * (c) A Qahar Mudzakkir <qaharmdz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
     */
    public function action(string $eventName, array $data = [])
    {
        $this->dispatchHook($eventName, $data, 'action');
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
     * Dispatch event \Gubug\Event\Hook to all registered listeners
     *
     * @param  string $eventName
     * @param  array  $data
     * @param  string $type
     *
     * @return \Gubug\Event\Hook
     */
    public function dispatchHook(string $eventName, array $data = [], string $type = 'action')
    {
        $eventName = $type . '.' . $eventName;
        $event     = new \Gubug\Event\Hook($eventName, $data);

        if ($this->getListeners($eventName)) {
            $this->dispatch($eventName, $event);
        }

        return $event;
    }
}
