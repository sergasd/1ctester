<?php

require_once(__DIR__ . '/ExchangeTester.php');

$configName = isset($argv[1]) ? $argv[1] : 'example';
$configFileName = __DIR__ . "/config/$configName.php";

if (file_exists($configFileName)) {
    $configName = require_once($configFileName);
    $exchangeTester = new ExchangeTester($configName);
    $exchangeTester->testSession();
} else {
    echo "Config file $configName not found\n";
    exit(1);
}
