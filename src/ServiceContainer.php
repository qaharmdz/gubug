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

namespace Gubug;

use Pimple\Container;

/**
 * Contain all services which is good as base controller
 *
 * @author Mudzakkir <qaharmdz@gmail.com>
 */
abstract class ServiceContainer
{
    private static $storage;

    /**
     * Container setter
     *
     * @param Container $storage
     */
    public static function setContainer(Container $storage)
    {
        if (self::$storage === null) {
            self::$storage = $storage;
        }
    }

    /**
     * Full access to container
     *
     * @return \Pimple\Container
     */
    protected function container()
    {
        return self::$storage;
    }

    /**
     * Access a service.
     *
     * It's important for user to aware they use service, thus no __call
     *
     * @param  string $id Service identifier
     *
     * @return mixed
     */
    protected function use($id)
    {
        return self::$storage[$id];
    }
}
