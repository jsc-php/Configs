<?php

use JscPhp\Configs\Config;

require_once '../vendor/autoload.php';

try {
    $config = new Config(__DIR__ . '/test.php', ['autosave' => false]);

    echo ($config->get('database.host')) . "\n";
    echo ($config->get('database', 'host')) . "\n";
    echo ($config->database['host']) . "\n";
    echo ($config->get('database')['host']) . "\n";
    $config->delete('database.host');
    print_r($config->get('database'));

} catch (\Exception $ex) {
    var_dump($ex->getMessage());
}
