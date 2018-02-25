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

use Symfony\Component\EventDispatcher\Event;

/**
 * @author Mudzakkir <qaharmdz@gmail.com>
 */
class Hook extends Event
{
    protected $name;
    protected $args;
    protected $defaultArgs;

    /**
     * {@inheritdoc}
     */
    public function __construct(string $eventName, array $arguments = [])
    {
        $this->name = $eventName;
        $this->args = new \Gubug\Library\Config($arguments);

        // All event have chance to access initial args
        if ($this->defaultArgs === null) {
            $this->defaultArgs = $this->args;
        }
    }

    /**
     * Getter for triggered event name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function default()
    {
        return $this->defaultArgs;
    }

    public function arguments()
    {
        return $this->args;
    }
}
