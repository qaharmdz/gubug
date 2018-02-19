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
 * Handling HTTP request
 *
 * @author Mudzakkir <qaharmdz@gmail.com>
 */
class Request extends HttpFoundation\Request
{
    /**
     * Alias of parent::request ($_POST) properties.
     *
     * @var \Symfony\Component\HttpFoundation\ParameterBag
     */
    public $post;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->post = $this->request;
    }

    /**
     * Consistenly remove trailing slash from PathInfo
     *
     * @return string The raw path (i.e. not urldecoded)
     */
    public function getPathInfo()
    {
        return rtrim(parent::getPathInfo(), '/') ?: '/';
    }

    /**
     * Get base URI for the Request.
     *
     * @return string Base URI
     */
    public function getBaseUri()
    {
        return $this->getSchemeAndHttpHost() . $this->getBasePath() . '/';
    }
}
