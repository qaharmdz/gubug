<?php
namespace Contoh\Library;

class Controller extends \Gubug\ServiceContainer
{
    protected $parseList = [];

    public function __get(string $id)
    {
        return $this->use($id);
    }

    /**
     * Wrap controller dispatch with event filter
     *
     * @param  string $path
     * @param  array  $arguments
     * @param  string $namespace
     *
     * @return \Gubug\Event\Hook
     */
    protected function load(string $path, array $arguments = [], string $namespace = 'Module')
    {
        /**
         * This event allows you to change the arguments that will be passed to the controller.
         *
         * @return \Gubug\Event\Hook $eventArguments
         */
        $eventArguments = $this->event->filter($this->parseEventName($namespace . '/' . $path, 'args'), $arguments);

        /**
         * Dispatch module to get response
         *
         * @return \Symfony\Component\HttpFoundation\Response $response
         */
        $response = $this->dispatcher->controller($path, $eventArguments->getAllData(), $namespace);

        /**
         * This event allows you to modify or replace the content that will be replied.
         */
        return $this->event->filter(
            $this->parseEventName($namespace . '/' . $path, 'content'),
            ['_content' => $response->getContent()]
        );
    }

    /**
     * Wrap template render with event filter
     *
     * @param  string $template
     * @param  array  $variables
     * @param  string $eventName
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function render(string $template, array $variables, string $eventName = '')
    {
        $eventName = $eventName ?: $this->parseEventName($template, 'vars');
        $variables['_template'] = $template;

        /**
         * This event allows you to modify or replace the variables that will be rendered.
         *
         * @return \Gubug\Event\Hook $variables
         */
        $variables = $this->event->filter($eventName, $variables)->getAllData();

        $template = $this->config->get('themePath') . 'template/' . $variables['_template'] . '.tpl';

        return $this->response->render($template, $variables);
    }

    /**
     * Format given name in dot notation
     *
     * @param  string $name
     * @param  string $verb
     *
     * @return string
     */
    protected function parseEventName(string $name, string $verb)
    {
        $name = strtolower($name);

        if (empty($this->parseList[$name])) {
            $this->parseList[$name] = implode('.', array_unique(explode('/', $name)));
        }

        return $this->parseList[$name] . '.' . $verb;
    }
}
