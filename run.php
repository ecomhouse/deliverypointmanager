<?php

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/config');
$dotenv->load();

//var_dump($argv);
//echo $_ENV['INPOST_API_TOKEN'] . "\n";
echo "Hello world\n";
