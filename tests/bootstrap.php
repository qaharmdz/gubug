<?php

$loader = require realpath(__DIR__ . '/../vendor/') . DIRECTORY_SEPARATOR . 'autoload.php';
$loader->addPsr4('Contoh\\', realpath(__DIR__ . '/Demo/'));
