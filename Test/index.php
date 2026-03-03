<?php

use JscPhp\Configs\Config;

require_once '../vendor/autoload.php';

try {
    $config = new Config(__DIR__ . '/test.php');


    print_r($config->save(return: true));
} catch (\Exception $ex) {
    var_dump($ex->getMessage());
}
