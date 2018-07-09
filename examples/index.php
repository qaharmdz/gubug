<?php

// ini_set('display_errors', 0);
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

// ========= Autoload

$loader = require realpath(__DIR__ . '/../vendor/') . DS . 'autoload.php';
$loader->addPsr4('Contoh\\', realpath(__DIR__));

$config = require 'config.php';

if (!$config) {
    // Installation
}

// ========= Micro Framework

$gubug = new Gubug\Framework();
// $gubug->init($config)->run();

$gubug->init($config);
$gubug->run();

// ==================== TEST CODE ======================

// d($gubug::VERSION);
// d($gubug->container);

// d($gubug->config->get('namespace.plugin', ''));
d($gubug->config->all());

// d($gubug->request);
// d($gubug->request->getPathInfo());
// d($gubug->request->getBaseUrl());
// d($gubug->request->getBasePath());
// // ---
// d($gubug->request->query->all()); // $_GET
// d($gubug->request->post->all()); // $_POST
// d($gubug->request->isSecure());
// d($gubug->request->isMethod('GET'));
// // ---
// d($gubug->request->attributes->all());
// d($gubug->request->attributes->get('_controller'));


// !d([
//     'key1' => $val1 = 'value 1',
//     'key2' => $val2 = 'value 2',
//     'key3' => $config['key1'] . ' - ' . $config['key2'],
//     'key4' => $val1 . ' - ' . $val2,
// ]);
