<?php

use JscPhp\Configs\Types\Type;

require_once '../vendor/autoload.php';

$config = new \JscPhp\Configs\Config(__DIR__ . '/test.ini');


// Test Array to INI
$test_array = [
    'DEV_MODE' => true,
    'database' => [
        'driver'   => 'sql',
        'host'     => 'localhost',
        'user'     => 'dummy',
        'password' => '12345'
    ],
    'sample'   => [
        'stone_fruit' => [
            'peaches', 'plums'
        ],
        'sweet'       => [
            'apple',
            'banana',
            'orange']
    ],
    'numbers'  => [1, 2, 3, 4]
];

$config->setAll($test_array);
print_r($config->saveAs('test.xml', Type::Xml, true));