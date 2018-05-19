<?php
/*
 * This file is part of the Gubug package.
 *
 * (c) A Qahar Mudzakkir <qaharmdz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gubug;

use Pimple\Container;

/**
 * Container of all services
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
     * @param bool      $override
     */
    public static function setContainer(Container $storage, bool $override = true)
    {
        if (self::$storage === null || $override) {
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
     * @param  string $id Service identifier
     *
     * @return mixed
     */
    protected function use(string $id)
    {
        return self::$storage[$id];
    }
}
