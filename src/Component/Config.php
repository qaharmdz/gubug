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

use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Config is a container for key/value pairs.
 *
 * @author Mudzakkir <qaharmdz@gmail.com>
 */
class Config extends ParameterBag
{
    /**
     * Returns a parameter by name (dot-notation).
     *
     * @param string $key     The key
     * @param mixed  $default The default value if the parameter key does not exist
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->getDot($key, $default);
    }

    /**
     * Sets a parameter by name (dot-notation).
     *
     * @param string $key   The key
     * @param mixed  $value The value
     */
    public function set($key, $value)
    {
        $this->setDot($key, $value);
    }

    /**
     * Override default remove to use dot-notation
     *
     * @param string $key Key in dot-notation
     */
    public function remove($key)
    {
        $this->removeDot($key);
    }

    /**
     * Returns the parameter value converted to array.
     *
     * @param  string $key     The parameter key
     * @param  array  $default The default value if the parameter key does not exist
     *
     * @return array
     */
    public function getArray($key, $default = [])
    {
        return (array)$this->get($key, $default);
    }

    /**
     * Returns a parameter by dot-notation keys.
     *
     * @see   https://github.com/adbario/php-dot-notation
     *
     * @param  string $key     Key in dot-notation
     * @param  mixed  $default The default value if the parameter key does not exist
     *
     * @return mixed
     */
    public function getDot($key, $default = null)
    {
        $items = $this->parameters;

        foreach (explode('.', $key) as $segment) {
            if (!is_array($items) || !array_key_exists($segment, $items)) {
                return $default;
            }

            $items = &$items[$segment];
        }

        return $items;
    }

    /**
     * Sets a parameter by dot-notation keys.
     *
     * @see   https://github.com/adbario/php-dot-notation
     *
     * @param string $keys   Key in dot-notation
     * @param mixed  $value The value
     */
    public function setDot($keys, $value)
    {
        $items = &$this->parameters;

        foreach (explode('.', $keys) as $key) {
            if (!isset($items[$key]) || !is_array($items[$key])) {
                $items[$key] = [];
            }

            $items = &$items[$key];
        }

        $items = $value;
    }

    /**
     * Remove a parameter by dot-notation keys.
     *
     * @see   https://github.com/adbario/php-dot-notation
     *
     * @param  string $keys String key in dot-notation
     */
    public function removeDot($keys)
    {
        if (isset($this->parameters[$keys])) {
            unset($this->parameters[$keys]);
        } else {
            $items = &$this->parameters;
            $segments = explode('.', $keys);
            $lastSegment = array_pop($segments);

            foreach ($segments as $segment) {
                if (!isset($items[$segment]) || !is_array($items[$segment])) {
                    continue;
                }
                $items = &$items[$segment];
            }
            unset($items[$lastSegment]);
        }
    }
}
