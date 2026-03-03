<?php

use JscPhp\Configs\Config;

require_once '../vendor/autoload.php';

$config = new Config(__DIR__ . '/test.php');


print_r($config->getAll());
$config->saveAs(__DIR__ . '/test.yaml');