<?php
/**
 * Example that show Gubug PAC micro framework, not project architecture skeleton.
 */

defined('DS') or define('DS', DIRECTORY_SEPARATOR);

// Autoload
$loader = require realpath(__DIR__ . '/../vendor/') . DS . 'autoload.php';
$loader->addPsr4('Contoh\\', realpath(__DIR__));

$config = require 'config.php';

// Micro framework
$gubug = new Gubug\Framework();
$gubug->init($config['framework']);

// Provide base URL and Path
$gubug->config->set('baseURL', $gubug->request->getBaseUri());
$gubug->config->set('basePath', realpath(__DIR__) . DS);

// Start to run..
$gubug->run();
