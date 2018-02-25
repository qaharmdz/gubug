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

namespace Gubug\Event;

use Symfony\Component\EventDispatcher;

/**
 * Hook event for general action and filter event
 *
 * @author Mudzakkir <qaharmdz@gmail.com>
 */
class Hook extends EventDispatcher\Event
{
    /**
     * @var array Data to store in the event
     */
    public $data;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array Readonly initial data passed to event
     */
    protected $defaultData;

    public function __construct(string $eventName, array $data = [])
    {
        $this->name = $eventName;
        $this->data = new \Gubug\Component\Config($data);

        // All event have chance to access initial data
        if ($this->defaultData === null) {
            $this->defaultData = $this->data->all();
        }
    }

    /**
     * Get triggered event name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get initial data
     *
     * @return array
     */
    public function getDefault()
    {
        return $this->defaultData;
    }

    /**
     * Get all changed data by event listener.
     *
     * @return array
     */
    public function getAllData()
    {
        return $this->data->all();
    }
}
