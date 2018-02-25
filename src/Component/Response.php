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

use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Response represents an HTTP response.
 *
 * @author Mudzakkir <qaharmdz@gmail.com>
 */
class Response extends HttpFoundation\Response
{
    /**
     * Check if response has content
     *
     * @return bool
     */
    public function hasContent()
    {
        return $this->content ? true : false;
    }

    /**
     * Insert content before current response content.
     *
     * @param  string $content
     *
     * @return $this
     */
    public function prependContent(string $content)
    {
        $this->setContent($content . $this->content);

        return $this;
    }

    /**
     * Insert content after current response content.
     *
     * @param  string $content
     *
     * @return $this
     */
    public function appendContent(string $content)
    {
        $this->setContent($this->content . $content);

        return $this;
    }

    /**
     * Redirects to another URL.
     *
     * 301 Permanently redirect from old url to new url
     * 302 Temporary redirect to new url
     * 303 In response to a POST, redirect to new url with GET method. Redirect after form submission.
     *
     * @param  string $url     The URL should be a full URL, with schema etc.
     * @param  int    $status  The status code (302 by default)
     *
     * @return Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect(string $url, int $status = 302)
    {
        return new HttpFoundation\RedirectResponse($url, $status);
    }

    /**
     * Return a JSON response.
     *
     * @param  mixed $data    The response data
     * @param  int   $status  The response status code
     * @param  array $headers An array of response headers
     *
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function json($data = [], $status = 200, array $headers = [])
    {
        return new HttpFoundation\JsonResponse($data, $status, $headers);
    }

    /**
     * Send a file.
     *
     * @param  string $file Path to file
     * @param  string $mask Mask filename
     *
     * @return Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function sendFile(string $file, string $mask = '', array $headers = [])
    {
        $response = new HttpFoundation\BinaryFileResponse($file, 200, $headers, true);
        if ($mask) {
            $response->setContentDisposition('attachment', $mask);
        }

        return $response;
    }

    /**
     * Aborts current request by sending a HTTP error.
     *
     * @param int    $statusCode The HTTP status code
     * @param string $message    The status message
     * @param array  $headers    An array of HTTP headers
     *
     * @throws HttpException
     */
    public function abort(int $statusCode, string $message = null, array $headers = [])
    {
        $message = $message ?: parent::$statusTexts[$statusCode] ?? null;

        throw new HttpException($statusCode, $message, null, $headers);
    }

    /**
     * Basic PHP templating
     *
     * Variables is not escaped automatically
     * Suggested to use more secure templating engine like Twig, Blade, Mustache etc
     *
     * @param  string $template  Full Path to template file
     * @param  array  $variables Variables passed to template
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function render(string $template, array $variables)
    {
        if (is_file($template)) {
            extract($variables, EXTR_SKIP);

            ob_start();
            require $template;

            return $this->setContent(ob_get_clean());
        }

        throw new \RuntimeException(sprintf('Template "%s" not found.', $template));
    }
}
