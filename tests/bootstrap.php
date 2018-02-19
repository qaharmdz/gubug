<?php

$loader = require realpath(__DIR__ . '/../vendor/') . DIRECTORY_SEPARATOR . 'autoload.php';
$loader->addPsr4('Gubug\Test\\', realpath(__DIR__ . '/src/'));
