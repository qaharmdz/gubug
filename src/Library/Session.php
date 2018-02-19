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

use Symfony\Component\HttpFoundation;

/**
 * Handling HTTP session
 *
 * @author Mudzakkir <qaharmdz@gmail.com>
 */
class Session extends HttpFoundation\Session\Session
{
    public function __construct(SessionStorageInterface $storage = null, AttributeBagInterface $attributes = null, FlashBagInterface $flashes = null)
    {
        parent::__construct($storage, $attributes, $flashes);
    }

    public function setOptions(array $options)
    {
        if ($this->storage instanceof HttpFoundation\Session\Storage\NativeSessionStorage) {
            $this->storage->setOptions($options);
        }
    }

    public function flash()
    {
        return $this->getFlashBag();
    }
}
