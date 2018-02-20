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
 * Handling HTTP response
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
     * Ready use HTTP headers.
     *
     * @param  string $name Profile name
     */
    public function loadHeaders(string $name)
    {
        switch (strtolower($name)) {
            case 'html':
                $this->headers->set('Content-Type', 'text/html;');
                break;

            case 'json':
                $this->headers->set('Expires', '0');
                $this->headers->set('Pragma', 'no-cache');
                $this->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate, post-check=0, pre-check=0');
                $this->headers->set('Content-Type', 'application/json;');
                break;

            case 'xml':
                $this->headers->set('Content-Type', 'application/xml, text/xml');
                break;

            case 'rss':
                $this->headers->set('Content-Type', 'application/rss+xml, application/xml, text/xml; charset=ISO-8859-1');
                break;

            case 'pdf':
                $this->headers->set('Content-Type', 'application/pdf');
                break;

            default:
                $this->headers->set('Content-Type', 'text/plain');
                break;
        }
    }

    /**
     * Helper to send file.
     *
     * @param  string $file Path to file
     * @param  string $mask Mask filename
     */
    public function sendFile(string $file, string $mask = '', array $headers = [])
    {
        $response = new HttpFoundation\BinaryFileResponse($file, 200, $headers, true);
        if ($mask) {
            $response->setContentDisposition('attachment', $mask);
        }

        $response->send();
    }

    /**
     * Redirects to another URL.
     *
     * 301 Permanently redirect from old url to new url
     * 302 Temporary redirect to new url
     * 303 In response to a POST, redirect to new url with GET method. Redirect after form submission.
     *
     * @param string $url     The URL should be a full URL, with schema etc.
     * @param int    $status  The status code (302 by default)
     */
    public function redirect(string $url, int $status = 302)
    {
        HttpFoundation\RedirectResponse::create($url, $status)->send();
    }

    /**
     * Aborts current request by sending a HTTP error.
     *
     * @param int    $statusCode The HTTP status code
     * @param string $message    The status message
     *
     * @throws \RuntimeException
     */
    public function abort(int $statusCode = 500, string $message = 'Internal Server Error')
    {
        throw new \RuntimeException($message, $statusCode);
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
     * @return Response
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
