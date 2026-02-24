<?php

use JscPhp\Configs\Config;
use JscPhp\Configs\Types\Type;

require_once '../vendor/autoload.php';

$config = new Config(__DIR__ . '/test.php');


$config->saveAs('test.yaml', Type::Yaml);