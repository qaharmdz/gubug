<?php
/**
 * Example that show Gubug PAC micro framework, not project skeleton.
 */

defined('DS') or define('DS', DIRECTORY_SEPARATOR);

//========= Autoload

$loader = require realpath(__DIR__ . '/../vendor/') . DS . 'autoload.php';
$loader->addPsr4('Contoh\\', realpath(__DIR__));

$config = require 'config.php';

//========= Micro Framework

$gubug = new Gubug\Framework();
$gubug->init($config['app']);

//=== Set base URL and Path
$gubug->config->set('baseURL', $gubug->request->getBaseUri());
$gubug->config->set('basePath', realpath(__DIR__) . DS);
$gubug->config->set('themePath', $gubug->config->get('basePath') . 'Front/Theme/default/');


//========= Application Setup

foreach ($config['serviceProvider'] as $provider) {
    $gubug->container->register(new $provider());
}

foreach ($config['eventSubscriber'] as $subscriber) {
    $controller = $gubug->container['resolver.controller']->resolve($subscriber, [], 'Plugin');
    $gubug->event->addSubscriber(new $controller['class']());
}

foreach ($config['routeCollection'] as $route) {
    $gubug->router->addRoute(...$route);
}

//=== Start to run..
$gubug->run();
